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
    public function index($userId)
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $data = [];
        if($user->hoa_access_type === 2) {
            foreach ($user->subdivisions as $subdivision) {
                $data[] = $subdivision->id;
            }
            $lots = Lot::select('id')->whereIn('subdivision_id',$data)->get();
            $lotIds = [];
            foreach ($lots as $lot){
                $lotIds[] = $lot->id;
            }
            $billing = Billing::whereIn('lot_id',$lotIds)->paginate(10);
            return PaymentTransactionResource::collection($billing);
        }

        $lot = Lot::select('id')->where('user_id',$userId)->get();
        $lotId = [];
        foreach ($lot as $data){
            $lotId[]=$data->id;
        }
        $billing = Billing::orderBy('id','DESC')->whereIn('lot_id',$lotId)->paginate(10);
        return PaymentTransactionResource::collection($billing);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentTransactionRequest $request)
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

    public function search_payment_transaction($id){
        $data = \Request::get('find');
        if ($data !== "") {
            $dueFee = Billing::orderBy('id','DESC')
                ->where('lot_id',$id)
                ->orWhere('hoa_billing_statement_number','LIKE','%'.$data.'%')
                ->paginate(10);
            $dueFee->appends(['find' => $data]);
        } else {
            $dueFee = Billing::orderBy('id','DESC')->paginate(10);
        }
        return PaymentTransactionResource::collection($dueFee);
    }
}
