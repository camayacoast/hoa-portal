<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Member\ShowSubdivisionResource;
use App\Http\Resources\Admin\ShowEmailResource;
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
        return UsersResource::collection(User::with('subdivisions')->orderBy('id','DESC')->where('hoa_admin','1')->paginate(10));
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


    public function add_user(UsersRequest $request, $id){
        $user = User::findOrFail($id);
        if($user->hoa_admin === 1){
            return response('This User has been already an Admin',500);
        }
        $data = $request->validated();
        $request =  $user->update([
            'hoa_access_type'=>$data['hoa_access_type'],
            'hoa_member'=>$data['hoa_member'],
            'hoa_admin'=>$data['hoa_admin'],
        ]);

        if($data['subdivision_id']){
            foreach($data['subdivision_id'] as $subdId){
                $user->subdivisions()->attach($subdId);
            }
        }
        return $request;
    }
    public function update(UsersRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        $request =  $user->update([
            'hoa_access_type'=>$data['hoa_access_type'],
            'hoa_member'=>$data['hoa_member'],
            'hoa_admin'=>$data['hoa_admin'],
        ]);

        if($data['subdivision_id']){
            $user->subdivisions()->detach();
            foreach($data['subdivision_id'] as $subdId){
                $user->subdivisions()->attach($subdId);
            }
        }
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
        if($users->hoa_member = 1){
            $users->update([
                'hoa_admin'=>0
            ]);
            return response('', 204);
        }
        $users->subdivisions->detach();
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
        $user = User::where('hoa_member_status',1)->get();
        return ShowEmailResource::collection($user);
    }

    public function search_user()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $user = User::orderBy('id','DESC')->where('hoa_admin',1)->where(function ($query) use ($data) {
                $query->where('hoa_member_lname', 'Like', '%' . $data . '%')
                    ->orWhere('email','LIKE','%'.$data.'%')
                    ->orWhere('hoa_member_fname', 'Like', '%' . $data . '%')
                    ->orWhereRaw("concat(hoa_member_lname, ' ', hoa_member_fname) like '%$data%' ");

            })->paginate(10);
            $user->appends(['find' => $data]);
        } else {
            $user = User::orderBy('id','DESC')->paginate(10);
        }
        return UsersResource::collection($user);
    }

    public function get_subdivision(){
        $subdivision = Subdivision::orderBy('hoa_subd_name','ASC')->paginate(50);
        return ShowSubdivisionResource::collection($subdivision);
    }
}
