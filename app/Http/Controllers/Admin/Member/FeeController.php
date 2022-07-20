<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\FeeRequest;
use App\Http\Resources\Admin\Member\FeeResource;
use App\Models\Billing;
use App\Models\Fee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index($id)
    {
        return FeeResource::collection(Fee::orderBy('id', 'DESC')->where('lot_id', '=', $id)->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(FeeRequest $request, Fee $fee)
    {
        DB::transaction(function () use ($request, $fee) {
            $data = $request->validated();
            if ($data) {
                $data['hoa_fees_modifiedby'] = auth()->user()->id;
            }
            $billing = Billing::where('id', '=', $data['lot_id'])->latest()->first();
            $latestCost = $billing->hoa_billing_total_cost + $data['hoa_fees_cost'];
            $billing->update([
                'hoa_billing_total_cost' => $latestCost
            ]);
           $request = $fee->create($data);

            return $request;
        });
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return FeeResource
     */
    public function show($id)
    {
        $fee = Fee::findOrFail($id);
        return new FeeResource($fee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(FeeRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $fee = Fee::findOrFail($id);
            $data = $request->validated();
            if ($data) {
                $data['hoa_fees_modifiedby'] = auth()->user()->id;
            }
            $billing = Billing::where('id', '=', $data['lot_id'])->latest()->first();
            $latestCost = $billing->hoa_billing_total_cost + $data['hoa_fees_cost'];
            $billing->update([
                'hoa_billing_total_cost' => $latestCost
            ]);
            $request = $fee->update($data);
            return $request;
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $fee = Fee::findOrFail($id);
        $billing = Billing::where('id', '=', $fee->lot_id)->latest()->first();
        $latestCost = $billing->hoa_billing_total_cost - $fee->hoa_fees_cost;
        $billing->update([
            'hoa_billing_total_cost' => $latestCost
        ]);
        $fee->delete();
        return response('', 204);
    }

    public function search_fee()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $fee = Fee::orderBy('id', 'DESC')->where(function ($query) use ($data) {
                $query->where('hoa_fees_item', 'Like', '%' . $data . '%');

            })->paginate(10);
            $fee->appends(['find' => $data]);
        } else {
            $fee = Fee::orderBy('id', 'DESC')->paginate(10);
        }
        return FeeResource::collection($fee);
    }
}
