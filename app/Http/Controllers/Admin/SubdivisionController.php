<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubdivisionRequest;
use App\Http\Requests\Admin\UpdateSubdivisionRequest;
use App\Http\Resources\Admin\ShowEmailResource;
use App\Models\Subdivision;
use App\Http\Resources\Admin\SubdivisionResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class SubdivisionController extends Controller
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
            return SubdivisionResource::collection(
                Subdivision::whereIn('id',$data)
                    ->orderBy('id', 'DESC')
                    ->paginate(10));
        }
        return SubdivisionResource::collection(Subdivision::orderBy('id', 'DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\SubdivisionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubdivisionRequest $request, Subdivision $subdivision)
    {
        $data = $request->validated();
        $request = $subdivision->create($data);
        return $request;

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Subdivision $subdivision
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
     * @param \App\Http\Requests\Admin\SubdivisionRequest $request
     * @param \App\Models\Subdivision $subdivision
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubdivisionRequest $request, $id)
    {
        $subdivision = Subdivision::findOrFail($id);
        $data = $request->validated();
        $request = $subdivision->update($data);
        return $request;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Subdivision $subdivision
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subdivision = Subdivision::findOrFail($id);
        if(count($subdivision->lot) == 0){
            $subdivision->delete();
            return response('', 204);

        }
        return response('Unable to delete',500);
    }

    public function search_subdivision(){
        $data = \Request::get('find');
        if($data !==""){
            $subdivision = Subdivision::where('hoa_subd_name','like','%'.$data.'%')
                ->orWhere('hoa_subd_contact_person','%'.$data.'%')
                ->paginate(10);
            $subdivision->appends(['find'=>$data]);
        }else{
            $subdivision = Subdivision::paginate(10);
        }
        return SubdivisionResource::collection($subdivision);
    }

    public function show_email()
    {
        $user = User::where('hoa_admin','=',1)->where('hoa_member_status','=',1)->paginate(50);
        return ShowEmailResource::collection($user);
    }

    public function change_status($id)
    {
        $subdivision = Subdivision::find($id);
        $subdivision->hoa_subd_status === 1 ? $subdivision->update(['hoa_subd_status' => 0])
            : $subdivision->update([
            'hoa_subd_status' => 1
        ]);
        return response('', 204);
    }

    public function search_user()
    {
        $data = \Request::get('q');
        $user = User::orderBy('id','DESC')
                    ->where('hoa_admin','=',1)
                     ->where('hoa_member_status','=',1)
                    ->where(function($query) use ($data){
                        $query->where('hoa_member_lname', 'Like', '%' . $data . '%')
                            ->orWhere('email', 'LIKE', '%' . $data . '%')
                            ->orWhere('hoa_member_fname', 'Like', '%' . $data . '%')
                            ->orWhereRaw("concat(hoa_member_lname, ' ', hoa_member_fname) like '%$data%' ");
                    })
                    ->paginate(50);
        return ShowEmailResource::collection($user);
    }



}
