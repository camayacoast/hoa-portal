<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\Admin\UsersRequest;
use App\Http\Resources\Admin\UsersResource;
use App\Models\Subdivision;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UsersResource::collection(User::where('hoa_admin','1')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UsersResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        $request =  $user->update($data);
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::find($id);
        $users->delete();
        return response('', 204);
    }
    public function change_status($id)
    {
        $user = User::find($id);
        $user->hoa_member_status === 1 ? $user->update(['hoa_member_status' => 0])
            :  $user->update([
                'hoa_member_status' => 1
            ]);
        return response('', 204);
    }

    public function show_email(){
        $user = User::select('id','email')->get();
        return $user;
    }

    public function show_subdivision(){
        $subdivision = Subdivision::select('id','hoa_subd_name')->get();
        return $subdivision;
    }
}
