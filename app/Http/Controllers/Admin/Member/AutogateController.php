<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\AutogateRequest;
use App\Http\Resources\Admin\Member\AutogateResource;
use App\Http\Resources\Admin\Member\AutogateTemplate;
use App\Http\Resources\Admin\Member\ShowAutogateTemplateResource;
use App\Http\Resources\Admin\Member\UserSubdivisionResource;
use App\Models\Autogate;
use App\Models\Lot;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AutogateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
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
            $datas = Lot::select('user_id')->whereIn('subdivision_id', $data)->get();

            $autogateId = [];
            foreach ($datas as $userAutogate) {
                $autogateId[] = $userAutogate->user_id;
            }
            $cards = Autogate::with('user')
                ->orderBy('id', 'DESC')
                ->where('user_id', $autogateId)
                ->paginate(10);
            return AutogateResource::collection($cards);
        }
        return AutogateResource::collection(Autogate::with('template')->orderBy('id', 'DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(AutogateRequest $request, Autogate $autogate)
    {
        $data = $request->validated();
        if ($data) {
            $data['hoa_autogate_modifiedby'] = auth()->user()->id;
        }
        $request = $autogate->create($data);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Autogate $autogate
     * @return Response
     */
    public function show($id)
    {
        $autogate = Autogate::findOrFail($id);
        return new AutogateResource($autogate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Autogate $autogate
     * @return Response
     */
    public function update(AutogateRequest $request, $id)
    {
        $autogate = Autogate::findOrFail($id);
        $data = $request->validated();
        if ($data) {
            $data['hoa_autogate_modifiedby'] = auth()->user()->id;
        }
        $request = $autogate->update($data);
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Autogate $autogate
     * @return Response
     */
    public function destroy($id)
    {
        $autogate = Autogate::findOrFail($id);
        $autogate->delete();
        return response('', 204);
    }

    public function search_autogate()
    {
        $data = \Request::get('find');
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        if ($user->hoa_access_type === 2) {
            foreach ($user->subdivisions as $subdivision) {
                $data[] = $subdivision->id;
            }
            $datas = Lot::select('user_id')->whereIn('subdivision_id', $data)->get();

            $autogateId = [];
            foreach ($datas as $userAutogate) {
                $autogateId[] = $userAutogate->user_id;
            }
            return $this->search_autogate_subdivision_admin($data, $autogateId);
        }
        return $this->search_autogate_full_admin($data);
    }

    public function user_subdivision()
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        if ($user->hoa_access_type === 2) {
            $datas = [];
            foreach ($user->subdivisions as $subdivision) {
                $datas[] = $subdivision->id;
            }
            $data = User::with(['lot' => function ($query) use ($datas) {
                $query->whereIn('subdivision_id', $datas)
                    ->where('hoa_subd_lot_default', '=', 1);
            }])
                ->where('hoa_member', 1)
                ->where('hoa_member_status', '=', 1)
                ->paginate(50);
            return UserSubdivisionResource::collection($data);
        }
        $user = User::with(['lot' => function ($query) {
            $query->where('hoa_subd_lot_default', '=', 1);
        }])
            ->where('hoa_member', 1)
            ->where('hoa_member_status', '=', 1)
            ->paginate(50);
        return UserSubdivisionResource::collection($user);
    }

    public function search_user_subdivision()
    {
        $data = \Request::get('find');
        $id = auth()->user()->id;
        $dropdown = 2;
        $user = User::findOrFail($id);
        //subdivision admin
        if ($user->hoa_access_type === 2) {
            return $this->search_user_subdivision_subdivision_admin($data, $user);
        }

        //full admin
        return $this->search_user_subdivision_full_admin($data);
    }

    public function template()
    {
        $autogateTemplate = Template::paginate(50);
        return AutogateTemplate::collection($autogateTemplate);
    }

    private function search_autogate_subdivision_admin($data, $datas)
    {
        if ($data !== "") {
            $autogate = Autogate::where(function ($query) use ($data, $datas) {
                $query->where('hoa_autogate_member_name', 'Like', '%' . $data . '%')
                    ->where('user_id', $datas)
                    ->orWhere('user_id', 'Like', '%' . $data . '%')
                    ->orWhere('hoa_autogate_subdivision_name', 'Like', '%' . $data . '%');

            })->orderBy('id', 'DESC')->paginate(10);
            $autogate->appends(['find' => $data]);
        } else {
            $autogate = Autogate::orderBy('id', 'DESC')->paginate(10);
        }
        return AutogateResource::collection($autogate);
    }

    private function search_autogate_full_admin($data)
    {
        if ($data !== "") {
            $autogate = Autogate::where(function ($query) use ($data) {
                $query->where('hoa_autogate_member_name', 'Like', '%' . $data . '%')
                    ->orWhere('user_id', 'Like', '%' . $data . '%')
                    ->orWhere('hoa_autogate_subdivision_name', 'Like', '%' . $data . '%');

            })->orderBy('id', 'DESC')->paginate(10);
            $autogate->appends(['find' => $data]);
        } else {
            $autogate = Autogate::orderBy('id', 'DESC')->paginate(10);
        }
        return AutogateResource::collection($autogate);
    }

    private function search_user_subdivision_subdivision_admin($data, $datas)
    {
        if ($data !== "") {
            $user = User::with(['lot' => function ($query) use ($datas) {
                $query->whereIn('subdivision_id', $datas)
                    ->where('hoa_subd_lot_default', '=', 1);
            }])
                ->orderBy('id', 'DESC')
                ->where('hoa_member', 1)
                ->where('hoa_member_status', '=', 1)
                ->where(function ($query) use ($data) {
                    $query->where('hoa_member_lname', 'Like', '%' . $data . '%')
                        ->orWhere('email', 'LIKE', '%' . $data . '%')
                        ->orWhere('hoa_member_fname', 'Like', '%' . $data . '%')
                        ->orWhereRaw("concat(hoa_member_lname, ' ', hoa_member_fname) like '%$data%' ");

                })->paginate(10);
            $user->appends(['find' => $data]);
        } else {

            $user = User::with('lot.subdivision', ['lot' => function ($query) use ($datas) {
                $query->whereIn('subdivision_id', $datas)
                    ->where('hoa_subd_lot_default', '=', 1);
            }])
                ->orderBy('id', 'DESC')
                ->where('hoa_member', '1')
                ->where('hoa_member_status', '=', 1)
                ->paginate(10);

        }
        return UserSubdivisionResource::collection($user);
    }

    private function search_user_subdivision_full_admin($data)
    {
        if ($data !== "") {
            $user = User::with( ['lot' => function ($query) {
                $query->where('hoa_subd_lot_default', '=', 1);
            }])
                ->orderBy('id', 'DESC')
                ->where('hoa_member', 1)
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
        return UserSubdivisionResource::collection($user);
    }
}
