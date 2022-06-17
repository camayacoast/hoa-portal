<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\Member\RegistrationResource;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password as RulesPassword;


class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RegistrationResource::collection(User::where('hoa_member', '1')->orderBy('id', 'DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, StoreUserRequest $request)
    {
        $data = $request->validated();
        if ($data) {
            $data['hoa_member'] = 1;
//            $data['hoa_member_fullName'] = $data['hoa_member_lname'].' '.$data['hoa_member_fname'].' '.$data['hoa_member_mname'].' '.$data['hoa_member_suffix'];
            $data['password'] = bcrypt('Camaya123');
        }
        $request = $user->create($data);
        return $request;
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
        return new RegistrationResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        if ($data) {
            $data['hoa_member'] = 1;
//            $data['hoa_member_fullName'] = $data['hoa_member_lname'].' '
//                .$data['hoa_member_fname'].' '.$data['hoa_member_mname'].' '
//                .$data['hoa_member_suffix'];
            $data['password'] = bcrypt('Camaya123');
        }
        $request = $user->update($data);
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
        if(count($users->lot) == 0 || count($users->document)){
        $users->delete();
        return response('', 204);
        }
        return response('Unable to delete',500);
    }

    public function search_member()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $user = User::where(function ($query) use ($data) {
                $query->where('hoa_member_lname', 'Like', '%' . $data . '%')
                    ->orWhere('hoa_member_fname', 'Like', '%' . $data . '%')
                    ->orWhereRaw("concat(hoa_member_lname, ' ', hoa_member_fname) like '%$data%' ");

            })->paginate(10);
            $user->appends(['find' => $data]);
        } else {
            $user = User::paginate(10);
        }
        return RegistrationResource::collection($user);
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

    public function submit_forget_password_form(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status===Password::RESET_LINK_SENT){
            return[
                'status'=>__($status)
            ];
        }

        throw ValidationException::withMessages([
            'email'=>[trans($status)]
        ]);
    }

    public function submit_reset_password_form(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'template'=> 'Password reset successfully'
            ]);
        }

        return response([
            'template'=> __($status)
        ], 500);
    }
}
