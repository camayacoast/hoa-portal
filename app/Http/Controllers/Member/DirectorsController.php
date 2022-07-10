<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Member\ShowDirectorsResource;
use App\Models\Director;
use App\Models\Lot;
use App\Models\Subdivision;
use Illuminate\Http\Request;

class DirectorsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $userId = auth()->user()->id;
        $lot = Lot::select('subdivision_id')->where('user_id',$userId)->first();
        $subdivision = Subdivision::findOrFail($lot->subdivision_id);
        $director = Director::with('user')
            ->whereNotNull('hoa_bod_position')
            ->where('subdivision_id', $subdivision->id)
            ->whereHas('user',function ($q){
                $q->where('hoa_member_status',1);
            })
            ->orderBy('id','DESC')->get();

        return ShowDirectorsResource::collection($director);
    }
}
