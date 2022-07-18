<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Member\BillingResource;
use App\Models\Lot;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($billingId)
    {
        $userId = auth()->user()->id;

        $billing = Lot::with(['billing'=>function($query) use ($billingId){
            if($billingId !== '0'){
                $query->where('id','=',$billingId)->first();
            }else {

                $query->latest()->first();
            }
        }],'subdivision')
            ->where('user_id',$userId)
            ->where('hoa_subd_lot_default',1 )
            ->first();
        return new BillingResource($billing);
    }
}
