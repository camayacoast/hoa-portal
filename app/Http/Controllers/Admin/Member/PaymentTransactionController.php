<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\PaymentTransactionRequest;
use App\Http\Resources\Admin\Member\PaymentTransactionResource;
use App\Models\Billing;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lotId)
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $data = [];
        if($user->hoa_access_type === 2) {
            foreach ($user->subdivisions as $subdivision) {
                $data[] = $subdivision->id;
            }
            $lotIds = Lot::select('lot_id')->whereIn('subdivision_id',$data)->get();

            $billing = Billing::whereIn('lot_id',$lotIds)->paginate(10);
            return PaymentTransactionResource::collection($billing);
        }
        $billing = Billing::where('lot_id','=',$lotId)->paginate(10);
        return PaymentTransactionResource::collection($billing);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $billing = Billing::findOrFail($id);
        return new PaymentTransactionResource($billing);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentTransactionRequest $request, $id)
    {
       $data = $request->validated();
       $billing = Billing::findOrFail($id);
       $request = $billing->update($data);
       return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
