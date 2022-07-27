<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\ShowEmailResource;
use App\Models\User;
use Illuminate\Http\Request;

class ShowMemberUserController extends Controller
{
    public function show_member_user(){
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        if ($user->hoa_access_type === 2) {
            $datas = [];
            foreach ($user->subdivisions as $subdivision) {
                $datas[] = $subdivision->id;
            }
            $data = ShowEmailResource::collection(User::with('subdivisions')
                ->whereHas('subdivisions', function ($query) use ($datas) {
                    $query->whereIn('id', $datas);
                })
                ->orderBy('id', 'DESC')
                ->where('hoa_member', '=',1)
                ->where('hoa_admin','=',1)
                ->where('hoa_member_status', '=',1)
                ->where('hoa_access_type', "!=", 1)
                ->paginate(10));
            return $data;
        }
        $user = User::with('subdivisions')->where('hoa_member_status', 1)
            ->orderBy('id', 'DESC')
            ->where('hoa_member', 1)
            ->where('hoa_admin','=',0)
            ->paginate(10);
        return ShowEmailResource::collection($user);
    }

    public function search_member_user(){
        $data = \Request::get('find');
        $id = auth()->user()->id;
        $dropdown = 2;
        $user = User::findOrFail($id);
        //subdivision admin
        if ($user->hoa_access_type === 2) {
            return $this->search_member_user_subdivision_admin($data, $user);
        }

        //full admin
        return $this->search_member_user_full_admin($data);
    }

    private function search_member_user_full_admin($data){
        if ($data !== "") {
            $user = User::with('subdivisions')
                ->orderBy('id', 'DESC')
                ->where('hoa_member',1)
                ->where(function ($query) use ($data) {
                    $query->where('hoa_member_lname', 'Like', '%' . $data . '%')
                        ->orWhere('email', 'LIKE', '%' . $data . '%')
                        ->orWhere('hoa_member_fname', 'Like', '%' . $data . '%')
                        ->orWhereRaw("concat(hoa_member_lname, ' ', hoa_member_fname) like '%$data%' ");

                })->paginate(10);
            $user->appends(['find' => $data]);
        } else {
            $user = User::orderBy('id', 'DESC')->paginate(10);
        }
        return ShowEmailResource::collection($user);
    }

    private function search_member_user_subdivision_admin($data,$datas){
        if ($data !== "") {
            $user = User::with('subdivisions')
                ->orderBy('id', 'DESC')
                ->whereHas('subdivisions', function ($query) use ($datas) {
                    $query->whereIn('id', $datas);
                })
                ->where('hoa_member', 1)
                ->where('hoa_access_type', 2)
                ->where(function ($query) use ($data) {
                    $query->where('hoa_member_lname', 'Like', '%' . $data . '%')
                        ->orWhere('email', 'LIKE', '%' . $data . '%')
                        ->orWhere('hoa_member_fname', 'Like', '%' . $data . '%')
                        ->orWhereRaw("concat(hoa_member_lname, ' ', hoa_member_fname) like '%$data%' ");

                })->paginate(10);
            $user->appends(['find' => $data]);
        } else {

            $user = User::with('subdivisions')
                ->whereHas('subdivisions', function ($query) use ($datas) {
                    $query->whereIn('id', $datas);
                })
                ->orderBy('id', 'DESC')
                ->where('hoa_member', '1')
                ->where('hoa_access_type', 2)
                ->paginate(10);

        }
        return ShowEmailResource::collection($user);
    }
}
