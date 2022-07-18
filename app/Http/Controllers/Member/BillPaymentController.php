<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Member\BillPaymentResource;
use App\Models\Billing;
use Illuminate\Http\Request;

class BillPaymentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $billing = Billing::findOrFail($id);
        return new BillPaymentResource($billing);
    }
}
