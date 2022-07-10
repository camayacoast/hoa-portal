<?php

namespace App\Http\Controllers\Member\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Profile\NotificationRequest;
use App\Http\Resources\Member\Profile\NotificationResource;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(){
        $userId = auth()->user()->id;
        $user = User::findOrFail($userId);
        return new NotificationResource($user);
    }
    public function update(NotificationRequest $request){
        $data = $request->validated();
        $userId = auth()->user()->id;
        $user  = User::findOrFail($userId);
        $request = $user->update([
            'hoa_member_ebill'=>$data['hoa_member_ebill'],
            'hoa_member_sms'=>$data['hoa_member_sms']
        ]);
        return $request;
    }
}
