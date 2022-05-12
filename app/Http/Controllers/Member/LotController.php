<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\LotRequest;
use App\Http\Requests\Admin\Member\StoreLotRequest;
use App\Http\Requests\Admin\Member\UpdateLotRequest;
use App\Http\Resources\Admin\Member\LotResource;
use App\Http\Resources\Admin\Member\ShowAgentResource;
use App\Http\Resources\Admin\Member\ShowSubdivisionResource;
use App\Models\Agent;
use App\Models\Director;
use App\Models\Lot;
use App\Models\Subdivision;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class LotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index($id)
    {
        return LotResource::collection(Lot::where('user_id',$id)->orderBy('id','DESC')->paginate(50));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LotRequest $request
     * @param Lot $lot
     * @return Response
     */
    public function store(StoreLotRequest $request,Lot $lot)
    {
        DB::transaction(function () use ($request,$lot){
            $data = $request->validated();
            if($data){
                $data['hoa_subd_lot_createdby'] = auth()->user()->id;
            }
            $newLot = $lot->create($data);
            $request = Director::create([
                'user_id'=>$newLot->user_id,
                'subdivision_id'=>$newLot->subdivision_id,
                'hoa_bod_modifiedby'=>auth()->user()->id
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
    public function update(UpdateLotRequest $request,$id)
    {
        DB::transaction(function () use ($request,$id){
            $lot = Lot::findOrFail($id);
            $data = $request->validated();
            if($data){
                $data['hoa_subd_lot_createdby'] = auth()->user()->id;
            }
            $newLot = $lot->update($data);
            $request = Director::where('user_id',$lot->user_id)->update([
                'user_id'=>$lot->user_id,
                'subdivision_id'=>$lot->subdivision_id,
                'hoa_bod_modifiedby'=>auth()->user()->id
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
        DB::transaction(function () use ($id){
            $lot = Lot::findOrFail($id);
            $director = Director::where('user_id',$lot->user_id)->delete();
            $lot->delete();
            return response('',204);
        });

    }

    public function show_subdivision(){
        $subdivision = Subdivision::paginate(50);
        return ShowSubdivisionResource::collection($subdivision);
    }

    public function show_agent(){
        $agent = Agent::paginate(50);
        return ShowAgentResource::collection($agent);
    }

    public function search_subdivision(){
        $data = \Request::get('find');
        $subdivision = Subdivision::where('hoa_subd_name','like','%'.$data.'%')
                ->paginate(50);
        return ShowSubdivisionResource::collection($subdivision);
    }
}
