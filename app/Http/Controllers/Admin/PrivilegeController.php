<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PrivilegeRequest;
use App\Http\Resources\Admin\PrivilegeResource;
use App\Models\Privilege;
use Illuminate\Http\Response;

class PrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return PrivilegeResource::collection(Privilege::orderBy('hoa_privilege_package_name', 'ASC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PrivilegeRequest $request
     * @param Privilege $privilege
     * @return Response
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
     * @param $id
     * @return PrivilegeResource
     */
    public function show($id)
    {
        $privilege = Privilege::findOrFail($id);
        return new PrivilegeResource($privilege);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PrivilegeRequest $request
     * @param $id
     * @return Response
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
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        $privilege = Privilege::findOrFail($id);
        $privilege->delete();
        return response('', 204);
    }

    public function search_privilege()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $privilege = Privilege::where(function ($query) use ($data) {
                $query->where('hoa_privilege_package_name', 'Like', '%' . $data . '%')
                    ->orWhere('hoa_privilege_package_category', 'Like', '%' . $data . '%');

            })->paginate(10);
            $privilege->appends(['find' => $data]);
        } else {
            $privilege = Privilege::paginate(10);
        }
        return PrivilegeResource::collection($privilege);
    }

    public function change_status($id)
    {
        $privilege = Privilege::find($id);
        $privilege->hoa_privilege_package_status === 1 ? $privilege->update(['hoa_privilege_package_status' => 0])
            :  $privilege->update([
            'hoa_privilege_package_status' => 1
        ]);
        return response('', 204);
    }
}
