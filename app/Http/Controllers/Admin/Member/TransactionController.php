<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Member\TransactionRequest;
use App\Http\Resources\Admin\Member\TransactionResource;
use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function index($id)
    {
        return TransactionResource::collection(Transaction::with('card')->where('card_id',$id)->orderBy('id','DESC')->paginate(10));
    }


    public function store(TransactionRequest $request,Transaction $transaction)
    {
        DB::transaction(function () use ($request,$transaction){
            $data = $request->validated();
            if($data){
                $data['hoa_privilege_transaction_modifiedby'] = auth()->user()->id;
            }
            //finding rfid
            $rfid = Card::findOrFail($data['card_id']);

            //if there is no load
            if($rfid->hoa_rfid_reg_privilege_load === 0){
                return response()->json([
                    'data'=>['errors'=>'Sorry you dont have enough load! Please'],

                ],500);
            }

            //if the request was greater than load
            if($rfid->hoa_rfid_reg_privilege_load <= $data['hoa_privilege_transaction_amount']){
                return response()->json([
                    'data'=>['errors'=>'Sorry you dont have enough load! Please'],

                ],500);
            }

            //privilege avail
            if($data['hoa_transaction'] === 1){
                $rfid->decrement('hoa_rfid_reg_privilege_load',$data['hoa_privilege_transaction_amount']);
            }
            //privilege load
            if($data['hoa_transaction'] === 2){
                $rfid->increment('hoa_rfid_reg_privilege_load',$data['hoa_privilege_transaction_amount']);
            }
            unset($data['hoa_transaction']);
            $request = $transaction->create($data);

            return $request;
        });


    }

    public function search_transaction()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $transaction = Transaction::orderBy('id', 'DESC')
                ->where('hoa_privilege_transaction_name','LIKE','%'.$data.'%')
                ->orWhere('hoa_privilege_booking_num','LIKE','%'.$data.'%')
                ->orWhere('hoa_privilege_transaction_type','LIKE','%'.$data.'%')
                ->paginate(10);
            $transaction->appends(['find' => $data]);
        } else {
            $transaction = Transaction::orderBy('id', 'DESC')->paginate(10);
        }
        return TransactionResource::collection($transaction);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response('',204);
    }
}
