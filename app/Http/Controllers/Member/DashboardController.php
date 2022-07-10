<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Due;
use App\Models\Fee;
use App\Models\Lot;
use App\Models\Subdivision;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $id = auth()->user()->id;
        $lot = Lot::select('id','subdivision_id')
            ->where('user_id',$id)
            ->where('hoa_subd_lot_default',1)
            ->first();
        $due = Due::where('subdivision_id',$lot->subdivision_id)->get()->sum('hoa_subd_dues_cost');
        $fee = Fee::where('lot_id',$lot->id)->get()->sum('hoa_fees_cost');
        $month = Due::select('hoa_subd_dues_end_date')->where('subdivision_id',$lot->subdivision_id)->first();
        $card = Card::select('hoa_rfid_reg_privilege_load')
                    ->where('user_id',$id)
                    ->where('hoa_rfid_reg_status',1)
                    ->first();

        return response()->json([
            'card'=>$card ? $card->hoa_rfid_reg_privilege_load : 0,
            'lot'=>$due,
            'fee'=>$fee,
            'month'=>$month->hoa_subd_dues_end_date
        ]);
    }
}
