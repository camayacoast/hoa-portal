<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PrivilegeRequest;
use App\Http\Resources\Admin\PrivilegeResource;

use App\Models\Privilege;
use App\Models\Subdivision;
use Illuminate\Http\Request;

class PrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PrivilegeResource::collection(Privilege::orderBy('hoa_privilege_package_name', 'ASC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrivilegeRequest $request,Privilege $privilege)
    {
        $data = $request->validated();
        if($data){
            $data['hoa_privilege_package_createdby'] = auth()->user()->id;
        }
        $request = $privilege->create($data);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Privilege  $privilege
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $privilege = Privilege::findOrFail($id);
        return new PrivilegeResource($privilege);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Privilege  $privilege
     * @return \Illuminate\Http\Response
     */
    public function update(PrivilegeRequest $request,$id)
    {
        $privilege = Privilege::findOrFail($id);
        $data = $request->validated();
        if($data){
            $data['hoa_privilege_package_createdby'] = auth()->user()->id;
        }
        $request = $privilege->update($data);
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Privilege  $privilege
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $privilege = Privilege::findOrFail($id);
        $privilege->delete();
        return response('', 204);
    }
}
