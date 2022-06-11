<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\AutogateRequest;
use App\Http\Resources\Admin\Member\AutogateResource;
use App\Http\Resources\Admin\Member\AutogateTemplate;
use App\Http\Resources\Admin\Member\ShowAutogateTemplateResource;
use App\Http\Resources\Admin\Member\UserSubdivisionResource;
use App\Models\Autogate;
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
        return AutogateResource::collection(Autogate::with('template')->orderBy('id','DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(AutogateRequest $request,Autogate $autogate)
    {
        $data = $request->validated();
        if($data){
            $data['hoa_autogate_modifiedby'] = auth()->user()->id;
        }
        $request = $autogate->create($data);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Autogate  $autogate
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Autogate  $autogate
     * @return Response
     */
    public function update(AutogateRequest $request, $id)
    {
        $autogate = Autogate::findOrFail($id);
        $data = $request->validated();
        if($data){
            $data['hoa_autogate_modifiedby'] = auth()->user()->id;
        }
        $request = $autogate->update($data);
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Autogate  $autogate
     * @return Response
     */
    public function destroy($id)
    {
        $autogate = Autogate::findOrFail($id);
        $autogate->delete();
        return response('',204);
    }

    public function search_autogate()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $user = Autogate::where(function ($query) use ($data) {
                $query->where('hoa_autogate_member_name', 'Like', '%' . $data . '%')
                    ->orWhere('user_id', 'Like', '%' . $data . '%')
                    ->orWhere('hoa_autogate_subdivision_name','Like','%'.$data.'%');

            })->paginate(10);
            $user->appends(['find' => $data]);
        } else {
            $user = User::paginate(10);
        }
        return AutogateResource::collection($user);
    }

    public function user_subdivision()
    {
        $user = User::with('lot')->paginate(50);
        return UserSubdivisionResource::collection($user);
    }

    public function template()
    {
        $autogateTemplate = Template::paginate(50);
        return AutogateTemplate::collection($autogateTemplate);
    }
}
