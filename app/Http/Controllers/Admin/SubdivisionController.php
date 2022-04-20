<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubdivisionRequest;
use App\Http\Resources\Admin\ShowEmailResource;
use App\Models\Subdivision;
use App\Http\Requests\StoreSubdivisionRequest;
use App\Http\Requests\UpdateSubdivisionRequest;
use App\Http\Resources\Admin\SubdivisionResource;
use App\Models\User;

class SubdivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SubdivisionResource::collection(Subdivision::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubdivisionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubdivisionRequest $request,Subdivision $subdivision)
    {
        $data = $request->validated();
        $request = $subdivision->create($data);
         return $request;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subdivision  $subdivision
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subdivision = Subdivision::findOrFail($id);
        return new SubdivisionResource($subdivision);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubdivisionRequest  $request
     * @param  \App\Models\Subdivision  $subdivision
     * @return \Illuminate\Http\Response
     */
    public function update(SubdivisionRequest $request, $id)
    {
        $subdivision = Subdivision::findOrFail($id);
        return $subdivision->update($request->validated());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subdivision  $subdivision
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subdivision = Subdivision::findOrFail($id);
        $subdivision->delete();
        return response('', 204);
    }

    public function show_email(){
        $user = User::select('hoa_member_lname','hoa_member_fname','hoa_member_mname')->get();
        return ShowEmailResource::collection($user);
    }
}
