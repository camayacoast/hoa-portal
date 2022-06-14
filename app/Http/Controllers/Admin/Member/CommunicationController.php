<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\CommunicationRequest;
use App\Http\Resources\Admin\Member\CommunicationResource;
use App\Models\Communication;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return CommunicationResource::collection(Communication::orderBy('id','DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommunicationRequest $request
     * @param Communication $communication
     * @return Response
     */
    public function store(CommunicationRequest $request,Communication $communication)
    {
        $data = $request->validated();
        if($data){
            $data['hoa_comm_template_modifiedby'] = auth()->user()->id;
        }
        $request = $communication->create($data);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $communication = Communication::findOrFail($id);
        return new CommunicationResource($communication);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(CommunicationRequest $request, $id)
    {
        $communication = Communication::findOrFail($id);
        $data = $request->validated();
        if($data){
            $data['hoa_comm_template_modifiedby'] = auth()->user()->id;
        }
        $request = $communication->update($data);
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $communication = Communication::findOrFail($id);
        DB::transaction(function () use ($communication){
            $communication->email()->delete();
            $communication->delete();
            return response('',204);
        });
    }

    public function search_communication()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $communication = Communication::where(function ($query) use ($data) {
                $query->where('hoa_comm_template_name', 'Like', '%' . $data . '%')
                    ->orWhere('hoa_comm_template_title', 'Like', '%' . $data . '%');

            })->paginate(10);
            $communication->appends(['find' => $data]);
        } else {
            $communication= Communication::orderBy('id','DESC')->paginate(10);
        }
        return CommunicationResource::collection($communication);
    }
}
