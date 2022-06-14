<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\EmailRequest;
use App\Http\Resources\Admin\Member\EmailResource;
use App\Http\Resources\Admin\Member\EmailTemplate;
use App\Models\Communication;
use App\Models\Email;
use App\Models\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return EmailResource::collection(Email::with('user','schedule')->orderBy('id','DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailRequest $request,Email $email)
    {
        $data = $request->validated();
        if($data){
            $data['hoa_email_modifiedby'] = auth()->user()->id;
        }
        $request = $email->create($data);

        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $email = Email::findOrFail($id);
        return new EmailResource($email);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmailRequest $request, $id)
    {
        $email = Email::findOrFail($id);
        $data = $request->validated();
        if($data){
            $data['hoa_email_modifiedby'] = auth()->user()->id;
        }
        $request = $email->update($data);

        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $email = Email::findOrFail($id);
        $email->delete();
        return response('',204);
    }

    public function search_email()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $email = Email::with('user')->whereHas('user',function ($query) use ($data) {
                $query->where('email', 'Like', '%' . $data . '%')
                    ->orWhere('user_id', 'Like', '%' . $data . '%')
                    ->orWhereRaw("concat(hoa_member_lname, ' ', hoa_member_fname) like '%$data%' ");


            })->paginate(10);
            $email->appends(['find' => $data]);
        } else {
            $email = Email::orderBy('id','DESC')->paginate(10);
        }
        return EmailResource::collection($email);
    }

    public function communication()
    {
        $emailTemplate = Communication::paginate(50);
        return EmailTemplate::collection($emailTemplate);
    }
}
