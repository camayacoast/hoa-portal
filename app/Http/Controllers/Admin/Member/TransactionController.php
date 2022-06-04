<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Member\TransactionRequest;
use App\Http\Resources\Admin\Member\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{

    public function index($id)
    {
        return TransactionResource::collection(Transaction::with('card')->where('card_id',$id)->orderBy('id','DESC')->paginate(10));
    }


    public function store(TransactionRequest $request)
    {

    }


    public function show(Transaction $privilegeTransaction)
    {
        //
    }


    public function update(TransactionRequest $request, Transaction $privilegeTransaction)
    {
        //
    }


    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response('',204);
    }
}
