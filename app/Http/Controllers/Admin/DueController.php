<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DueRequest;
use App\Http\Resources\Admin\DueResource;
use App\Http\Resources\Admin\ScheduleResource;
use App\Models\Due;
use App\Models\Schedule;
use Illuminate\Validation\Validator;

class DueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index($id)
    {
        return DueResource::collection(Due::with('schedule')->where('subdivision_id',$id)->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DueRequest $request
     * @return void
     */
    public function store(DueRequest $request,Due $due)
    {
        $data = $request->validated();
        if($data){
            $data['hoa_subd_dues_modifiedby'] = auth()->user()->id;
        }
        $request = $due->create($data);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return void
     */
    public function show($id)
    {
        $due = Due::findOrFail($id);
        return new DueResource($due);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DueRequest $request
     * @param $id
     * @return void
     */
    public function update(DueRequest $request, $id)
    {
        $due = Due::findOrFail($id);
        $data = $request->validated();
        if($data){
            $data['hoa_subd_dues_modifiedby'] = auth()->user()->id;
        }
        $request = $due->update($data);
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return void
     */
    public function destroy($id)
    {
        $due = Due::findOrFail($id);
        $due->delete();
        return response('',204);
    }

    public function show_schedule(){
        $schedule = Schedule::paginate(50);
        return ScheduleResource::collection($schedule);
    }
}
