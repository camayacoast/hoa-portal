<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\LotRequest;
use App\Http\Requests\Admin\Member\StoreLotRequest;
use App\Http\Requests\Admin\Member\UpdateLotRequest;
use App\Http\Resources\Admin\Member\LotResource;
use App\Http\Resources\Admin\Member\ShowAgentResource;
use App\Http\Resources\Admin\Member\ShowSubdivisionResource;
use App\Models\Agent;
use App\Models\Billing;
use App\Models\Director;
use App\Models\Lot;
use App\Models\Subdivision;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LotController extends Controller
{
    public function index($id)
    {
        return LotResource::collection(Lot::where('user_id', $id)->orderBy('id', 'DESC')->paginate(50));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LotRequest $request
     * @param Lot $lot
     * @return Response
     */
    public function store(StoreLotRequest $request)
    {
        $data = $request->validated();
        $subdivision = Subdivision::where('id', '=', $data['subdivision_id'])->first();
        if ((int)$data['hoa_subd_lot_block'] > (int)$subdivision->hoa_subd_blocks) {
            return response('You are Exceeding the inputs', 500);
        }

        if (count($subdivision->lot) > (int)$subdivision->hoa_subd_lots) {
            return response('You are Exceeding the inputs', 500);
        }
//        $lots = $lot->where('subdivision_id',$data['subdivision_id'])->first();


        DB::transaction(function () use ($data) {
            if ($data) {
                $data['hoa_subd_lot_createdby'] = auth()->user()->id;
            }
            $create = Lot::create($data);
            $id = $create->id;
            $this->billing($id);
            $user = User::findOrFail($create->user_id);
            $user->subdivisions()->attach($data['subdivision_id']);
            $request = Director::where('user_id', $create->user_id)->updateOrcreate([
                'subdivision_id' => $create->subdivision_id,
                'user_id' => $create->user_id
            ], [
                'subdivision_id' => $create->subdivision_id,
                'user_id' => $create->user_id,
                'hoa_bod_modifiedby' => auth()->user()->id
            ]);
            return $request;

        });
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return LotResource
     */
    public function show($id)
    {
        $lot = Lot::findOrFail($id);
        return new LotResource($lot);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LotRequest $request
     * @param $id
     * @return Response
     */
    public function update(UpdateLotRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $lot = Lot::findOrFail($id);
            $data = $request->validated();
            if ($data) {
                $data['hoa_subd_lot_createdby'] = auth()->user()->id;
            }
            $newLot = $lot->update($data);
            $user = User::findOrFail($lot->user_id);
            $user->subdivisions()->sync($data['subdivision_id']);
            $request = Director::where('user_id', $lot->user_id)->update([
                'user_id' => $lot->user_id,
                'subdivision_id' => $lot->subdivision_id,
                'hoa_bod_modifiedby' => auth()->user()->id
            ]);
            return $request;
        });

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $lot = Lot::findOrFail($id);
            if (count($lot->fee) == 0) {
                $director = Director::where('user_id', $lot->user_id)->delete();
                $lot->billing()->delete();
                $lot->delete();

                return response('', 204);
            }
            return response('Unable to delete', 500);
        });

    }

    public function show_subdivision()
    {
        $subdivision = Subdivision::paginate(50);
        return ShowSubdivisionResource::collection($subdivision);
    }

    public function show_agent()
    {
        $agent = Agent::paginate(50);
        return ShowAgentResource::collection($agent);
    }

    public function search_subdivision()
    {
        $data = \Request::get('find');
        $subdivision = Subdivision::where('hoa_subd_name', 'like', '%' . $data . '%')
            ->paginate(50);
        return ShowSubdivisionResource::collection($subdivision);
    }

    public function billing($id)
    {

        $lot = Lot::with('subdivision', 'user')
            ->where('id', '=', $id)->first();

        $lotArea = $lot->hoa_subd_lot_area;
        $cutOffDate = $lot->subdivision->hoa_subd_dues_cutoff_date;
        $paymentTargets = $lot->subdivision->hoa_subd_dues_payment_target;
        $generatedDates = Carbon::createFromFormat('Y-m-d', $cutOffDate)->addDay($paymentTargets);
        $periodDates = $cutOffDate . ' - ' . $generatedDates;
        $userId= auth()->user()->id;
        $designee = $lot->user->designee()->count();


        $words = explode(" ", $lot->subdivision->hoa_subd_name);
        $lotFirstString = '';

        foreach ($words as $w) {
            $lotFirstString .= $w[0];
        }
        $lotDateNow = Carbon::now()->format('Y');
        $lotUniqueId = $lot->id + 1;
        $statementNumber = $lotFirstString.'-'.$lotDateNow.'-'.$lotUniqueId;
        $bills = collect();

        foreach ($lot->subdivision->due as $due) {
            if ($due->unit_id === 1) {
                $bills->push($due->hoa_subd_dues_cost * $lotArea);
            } else if ($due->unit_id === 2) {
                $bills->push($due->hoa_subd_dues_cost);
            } else if($due->unit_id === 3){
                $bills->push($due->hoa_subd_dues_cost * $designee + $due->cost);
            }else{
                $bills->push(0);
            }
        }

//        foreach ($lot->fee as $fee) {
//            $bills->push($fee->hoa_fees_cost);
//        }
        $billingData = [
            'lot_id' => $id,
            'hoa_billing_statement_number' => $statementNumber,
            'hoa_billing_total_cost' => $bills->sum(),
            'hoa_billing_due_dates' => $cutOffDate,
            'hoa_billing_generated_date' => $generatedDates,
            'hoa_billing_period' => $periodDates,
            'hoa_billing_status' => 'Unpaid',
            'hoa_billing_created_by'=>$userId
        ];
        return Billing::create($billingData);
    }
}
