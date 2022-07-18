<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;

use App\Http\Resources\Member\PaymentResouce;
use App\Models\Lot;
use Illuminate\Http\Request;

class PaymentController extends Controller
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
        $billing = Lot::with('billing','subdivision')
            ->where('user_id',$id)
            ->where('hoa_subd_lot_default',1 )
            ->paginate(10);
        return PaymentResouce::collection($billing);
    }
}
