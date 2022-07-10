<?php

namespace App\Http\Controllers\Member\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Profile\DesigneeRequest;
use App\Http\Resources\Member\Profile\DesigneeResource;
use App\Models\Designee;
use Illuminate\Http\Request;

class DesigneeController extends Controller
{
    public function index(){
        $userId = auth()->user()->id;
        $designee = Designee::where('user_id',$userId)->get();
        return DesigneeResource::collection($designee);
    }

    public function store(DesigneeRequest $request){
        $data = $request->validated();
        if(count(auth()->user()->designee) === 4){
            return response('You can only add at least 4 designee!',500);
        }
        $userId = auth()->user()->id;
        if($data){
            $data['user_id'] = $userId;
            $data['hoa_member_designee_modifiedby'] = $userId;
        }
        $request = Designee::create($data);
        return $request;
    }

    public function destroy($id){
        $designee = Designee::findOrFail($id);
        $designee->delete();
        return response('',204);
    }
}
