<?php

namespace App\Http\Controllers\Member\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Profile\InformationRequest;
use App\Http\Resources\Member\Profile\InformationResource;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index(){
        $userId = auth()->user()->id;
        $lot = Lot::with('user','subdivision')
            ->where('user_id',$userId)
            ->where('hoa_subd_lot_default',1)
            ->first();
        return new InformationResource($lot);
    }

    public function update(InformationRequest $request ){
        $data = $request->validated();
        $userId = auth()->user()->id;

        $user = User::findOrFail($userId);
        $userData = $user->update([
            'hoa_member_lname'=>$data['hoa_member_lname'],
            'hoa_member_fname'=>$data['hoa_member_fname'],
            'hoa_member_mname'=>$data['hoa_member_mname'],
            'email'=>$data['email'],
            'hoa_member_phone_num'=>$data['hoa_member_phone_num']
        ]);
        $request = Lot::where('id','=',$data['lotId'])->update([
            'hoa_subd_lot_house_num'=>$data['hoa_subd_lot_house_num'],
            'hoa_subd_lot_street_name'=>$data['hoa_subd_lot_street_name']
        ]);
        return $request;
    }
}
