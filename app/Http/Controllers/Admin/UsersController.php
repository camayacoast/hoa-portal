<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Member\ShowSubdivisionResource;
use App\Http\Resources\Admin\ShowEmailResource;
use App\Models\Lot;
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
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $data = [];
        if ($user->hoa_access_type === 2) {
            foreach ($user->subdivisions as $subdivision) {
                $data[] = $subdivision->id;
            }
            $datas = User::with('subdivisions')
                ->where('hoa_admin', '1')
                ->where('hoa_access_type','!=',0)
                ->whereHas('subdivisions', function ($query) use ($data) {
                    $query->whereIn('id', $data);
                })
                ->orderBy('id', 'DESC')
                ->paginate(10);

            return UsersResource::collection($datas);
        }
        return UsersResource::collection(User::with('subdivisions')->orderBy('id', 'DESC')->where('hoa_admin', '1')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UsersResource($user);
    }


    public function add_user(UsersRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->hoa_admin === 1) {
            return response('This User has been already an Admin', 500);
        }
        $data = $request->validated();
        $request = $user->update([
            'hoa_access_type' => $data['hoa_access_type'],
            'hoa_member' => $data['hoa_member'],
            'hoa_admin' => $data['hoa_admin'],
        ]);

        if ($data['subdivision_id']) {
            foreach ($data['subdivision_id'] as $subdId) {
                if ($subdId === '0' || $subdId === 0) {
                    return $request;
                } else {
                    $user->subdivisions()->attach($subdId);
                }
            }
        }
        return $request;
    }

    public function update(UsersRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        $request = $user->update([
            'hoa_access_type' => $data['hoa_access_type'],
            'hoa_member' => $data['hoa_member'],
            'hoa_admin' => $data['hoa_admin'],
        ]);

        if ($data['subdivision_id']) {
            $user->subdivisions()->detach();
            foreach ($data['subdivision_id'] as $subdId) {
                if ($subdId === '0' || $subdId === 0) {
                    return $request;
                } else {
                    $user->subdivisions()->attach($subdId);
                }
            }
        }
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::find($id);
        if ($users->hoa_member = 1) {
            $users->update([
                'hoa_admin' => 0
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
            : $user->update([
            'hoa_member_status' => 1
        ]);
        return response('', 204);
    }

    public function show_subdivision()
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $datas = [];
        if ($user->hoa_access_type === 2) {
            foreach ($user->subdivisions as $subdivision) {
                $datas[] = $subdivision->id;
            }
            $data = Subdivision::whereIn('id', $datas)->paginate(50);
            return ShowSubdivisionResource::collection($data);
        }
        $subdivision = Subdivision::orderBy('hoa_subd_name', 'ASC')->paginate(50);
        return ShowSubdivisionResource::collection($subdivision);
    }

    public function show_email()
    {
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
                ->where('hoa_member', 1)
                ->where('hoa_admin','=',0)
                ->where('hoa_member_status', 1)
                ->where('hoa_access_type', "!=", 1)
                ->paginate(10));
            return $data;
        }
        $user = User::where('hoa_member_status', 1)
            ->orderBy('id', 'DESC')
            ->where('hoa_member', 1)
            ->where('hoa_admin','=',0)
            ->paginate(10);
        return ShowEmailResource::collection($user);
    }

    public function search_user()
    {
        $data = \Request::get('find');
        $id = auth()->user()->id;
        $dropdown = 1;
        $user = User::findOrFail($id);

        if ($user->hoa_access_type === 2) {
            $datas = [];
            foreach ($user->subdivisions as $subdivision) {
                $datas[] = $subdivision->id;
            }
            return $this->search_user_subdivision_admin($data, $datas, $dropdown);
        }

        //full admin
        return $this->search_user_full_admin($data, $dropdown);
    }


    public function search_show_email()
    {
        $data = \Request::get('find');
        $id = auth()->user()->id;
        $dropdown = 2;
        $user = User::findOrFail($id);
        //subdivision admin
        if ($user->hoa_access_type === 2) {
            return $this->search_user_subdivision_admin($data, $user, $dropdown);
        }

        //full admin
        return $this->search_user_full_admin($data, $dropdown);
    }

    public function search_show_subdivision()
    {
        $data = \Request::get('find');
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        //subdivision admin
        if ($user->hoa_access_type === 2) {
            $datas = [];
            foreach ($user->subdivisions as $subdivision) {
                $datas[] = $subdivision->id;
            }
            return $this->search_subdivision_subdivision_admin($data, $datas);
        }
        //full admin
        return $this->search_subdivision_full_admin($data);
    }

    private function search_user_subdivision_admin($data, $datas, $dropdown)
    {

        if ($dropdown === 1) {
            //user search
            if ($data !== "") {
                $user = User::with('subdivisions')
                    ->orderBy('id', 'DESC')
                    ->whereHas('subdivisions', function ($query) use ($datas) {
                        $query->whereIn('id', $datas);
                    })
                    ->where('hoa_admin', 1)
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
                    ->where('hoa_admin', '1')
                    ->where('hoa_access_type', 2)
                    ->paginate(10);
            }
            return UsersResource::collection($user);
        } else {
            //search per show email
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

    private function search_user_full_admin($data, $dropdown)
    {

        if ($dropdown === 1) {
            if ($data !== "") {
                $user = User::with('subdivisions')->orderBy('id', 'DESC')
                    ->where('hoa_admin', 1)
                    ->where(function ($query) use ($data) {
                        $query->where('hoa_member_lname', 'Like', '%' . $data . '%')
                            ->orWhere('email', 'LIKE', '%' . $data . '%')
                            ->orWhere('hoa_member_fname', 'Like', '%' . $data . '%')
                            ->orWhereRaw("concat(hoa_member_lname, ' ', hoa_member_fname) like '%$data%' ");

                    })->paginate(10);
                $user->appends(['find' => $data]);
            } else {
                $user = User::where('hoa_admin', 1)->orderBy('id', 'DESC')->paginate(10);
            }
            return UsersResource::collection($user);
        } else {
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
    }

    private function search_subdivision_subdivision_admin($data, $datas, $user)
    {
        if ($data !== "") {
            $subdivisionData = Subdivision::orderBy('id', 'DESC')
                ->whereIn('id', $datas)
                ->where('hoa_subd_name', 'LIKE', '%' . $data . '%')
                ->paginate(10);
            $subdivisionData->appends(['find' => $data]);
        } else {
            $subdivisionData = Subdivision::orderBy('id', 'DESC')
                ->whereIn('id', $datas)
                ->paginate(10);
        }
        return ShowSubdivisionResource::collection($subdivisionData);

    }

    private function search_subdivision_full_admin($data)
    {
        if ($data !== "") {
            $subdivisionData = Subdivision::orderBy('id', 'DESC')
                ->where('hoa_subd_name', 'LIKE', '%' . $data . '%')
                ->paginate(10);
            $subdivisionData->appends(['find' => $data]);
        } else {
            $subdivisionData = User::orderBy('id', 'DESC')->paginate(10);
        }
        return ShowSubdivisionResource::collection($subdivisionData);
    }
}
