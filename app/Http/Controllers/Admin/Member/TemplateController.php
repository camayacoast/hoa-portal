<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\TemplateRequest;
use App\Http\Resources\Admin\Member\AutogateResource;
use App\Http\Resources\Admin\Member\TemplateResource;
use App\Models\Message;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TemplateResource::collection(Template::with('message')->orderBy('id','DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(TemplateRequest $request,Template $template,Message $message)
    {
        DB::transaction(function () use ($request,$template,$message){
            $data = $request->validated();
            if($data){
                $data['hoa_autogate_tempate_modifiedby'] = auth()->user()->id;
            }
            $templates = $template->create([
                'hoa_autogate_template_name'=>$data['hoa_autogate_template_name'],
                'hoa_autogate_template_title'=>$data['hoa_autogate_template_title'],
                'hoa_autogate_template_modifiedby'=>$data['hoa_autogate_tempate_modifiedby']
            ]);
            $request = $message->create([
                'template_id'=>$templates->id,
                'hoa_autogate_template_message'=>$data['hoa_autogate_template_message']
            ]);

            return $request;
        });

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return Response
     */
    public function show($id)
    {
        $template = Template::findOrFail($id);
        return new TemplateResource($template);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return Response
     */
    public function update(TemplateRequest $request,$id)
    {
        $template = Template::findOrFail($id);

        DB::transaction(function () use ($request,$template,$id){
            $data = $request->validated();
            if($data){
                $data['hoa_autogate_tempate_modifiedby'] = auth()->user()->id;
            }
            $templates = $template->update([
                'hoa_autogate_template_name'=>$data['hoa_autogate_template_name'],
                'hoa_autogate_template_title'=>$data['hoa_autogate_template_title'],
                'hoa_autogate_template_modifiedby'=>$data['hoa_autogate_tempate_modifiedby']
            ]);
            $request = Message::where('template_id',$id)->update([
                'template_id'=>$id,
                'hoa_autogate_template_message'=>$data['hoa_autogate_template_message']
            ]);

            return $request;
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return Response
     */
    public function destroy($id)
    {
        $template = Template::findOrFail($id);
        DB::transaction(function() use ($template){
            $template->message()->delete();
            $template->autogate()->delete();
            $template->delete();
            return response('',204);
        });
    }

    public function search_template()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $template = Template::where(function ($query) use ($data) {
                $query->where('hoa_autogate_template_name', 'Like', '%' . $data . '%')
                    ->orWhere('hoa_autogate_template_title', 'Like', '%' . $data . '%');

            })->paginate(10);
            $template->appends(['find' => $data]);
        } else {
            $template = Template::orderBy('id','DESC')->paginate(10);
        }
        return TemplateResource::collection($template);
    }
}
