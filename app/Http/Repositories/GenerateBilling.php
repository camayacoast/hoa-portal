<?php


namespace App\Http\Repositories;


use App\Models\Billing;
use App\Models\Lot;
use Carbon\Carbon;
use function Illuminate\Session\userId;

class GenerateBilling
{
    public function generate($scheduleId){
        $billingData = collect();
        $lots = Lot::with('subdivision.due', 'fee')
            ->get();
        $userId = 1;
        $billing = Billing::select('hoa_billing_statement_number')->get();
        foreach ($lots as $lotData){
            $generatedDates = Carbon::createFromFormat('Y-m-d', $lotData->subdivision->hoa_subd_dues_cutoff_date)
                ->addDay($lotData->subdivision->hoa_subd_dues_payment_target);
            $periodDate = $lotData->subdivision->hoa_subd_dues_cutoff_date . '-' . $lotData->subdivision->hoa_subd_dues_payment_target;
            $words = explode(" ", $lotData->subdivision->hoa_subd_name);
            $lotFirstString = '';
            foreach ($words as $w) {
                $lotFirstString .= $w[0];
            }
            $lotDateNow = Carbon::now()->format('Y');
            $lotUniqueId = mt_rand(1,9999999999999);

            $statementNumber = $lotFirstString . '-' . $lotDateNow . '-' . $lotUniqueId;
            foreach ($billing as $datas){
                if($datas->hoa_billing_statement_number === $statementNumber){
                    $lotUniqueId = mt_rand(1000000000,9999999999);
                    $statementNumber = $lotFirstString . '-' . $lotDateNow . '-' . $lotUniqueId;
                }
            }
            $totalCost = collect();
            foreach ($lotData->subdivision->due as $dueData) {
                if($dueData->hoa_subd_dues_start_date <= Carbon::now() && $dueData->hoa_subd_dues_end_date >= Carbon::now()){
                    if($dueData->schedule_id = $scheduleId){
                        if ($dueData->unit_id === 1) {
                            $totalCost[]=$dueData->hoa_subd_dues_cost *  $lotData->hoa_subd_lot_area;
                        } else if ($dueData->unit_id === 2) {
                            $totalCost[]=$dueData->hoa_subd_dues_cost;
                        } else if ($dueData->unit_id === 3) {
                            $totalCost[]=$dueData->hoa_subd_dues_cost * $lotData->user->designee()->count() + $dueData->hoa_subd_dues_cost;
                        } else {
                            $totalCost[]=0;
                        }
                    }
                    $totalCost[]=0;
                }
            }
            foreach ($lotData->fee as $feeData){
                if($feeData->hoa_fees_start_date <= Carbon::now() && $feeData->hoa_fees_end_date >= Carbon::now()){
                    if($feeData->schedule_id = $scheduleId){
                        $totalCost[]=$feeData->hoa_fees_cost;
                    }
                    $totalCost[]=0;
                }
            }
            $billingData->push([
                'lot_id'=>$lotData->id,
                'hoa_billing_period'=> $periodDate,
                'hoa_billing_total_cost'=>$totalCost->sum(),
                'hoa_billing_statement_number'=>$statementNumber,
                'hoa_billing_due_dates'=>$lotData->subdivision->hoa_subd_dues_cutoff_date,
                'hoa_billing_generated_date'=>$generatedDates,
                'hoa_billing_period' => $periodDate,
                'hoa_billing_status' => 'Unpaid',
                'hoa_billing_created_by'=>$userId
            ]);
        }

        $saveData = $billingData->toArray();
        $request = Billing::insert($saveData);
        return $request;
    }
}
