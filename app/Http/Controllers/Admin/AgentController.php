<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AgentRequest;
use App\Http\Requests\Admin\UpdateAgentRequest;
use App\Http\Resources\Admin\AgentResource;
use App\Models\Agent;


class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AgentResource::collection(Agent::orderBy('id', 'DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\AgentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentRequest $request,Agent $agent)
    {
        $data = $request->validated();
        $request = $agent->create($data);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agent = Agent::findOrFail($id);
        return new AgentResource($agent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\AgentRequest  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAgentRequest $request, $id)
    {
        $agent = Agent::findOrFail($id);
        $data = $request->validated();
        $request = $agent->update($data);
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->delete();
        return response('',204);
    }

    public function search_agent()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $privilege = Agent::orderBy('id', 'DESC')->where(function ($query) use ($data) {
                $query->where('hoa_sales_agent_fname', 'Like', '%' . $data. '%')
                    ->orWhere('hoa_sales_agent_email','Like','%'.$data.'%')
                    ->orWhere('hoa_sales_agent_lname','like','%'.$data.'%')
                    ->orWhereRaw("concat(hoa_sales_agent_lname, ' ', hoa_sales_agent_fname) like '%$data%' ")
                    ->orWhereRaw("concat(hoa_sales_agent_fname, ' ', hoa_sales_agent_lname) like '%$data%' ")
                    ->paginate(50);
            })->paginate(10);
            $privilege->appends(['find' => $data]);
        } else {
            $privilege = Agent::orderBy('id', 'DESC')->paginate(10);
        }
        return AgentResource::collection($privilege);
    }

    public function change_status($id)
    {
        $subdivision = Agent::find($id);
        $subdivision->hoa_sales_agent_status === 1 ? $subdivision->update(['hoa_sales_agent_status' => 0])
            :  $subdivision->update([
            'hoa_sales_agent_status' => 1
        ]);
        return response('', 204);
    }
}
