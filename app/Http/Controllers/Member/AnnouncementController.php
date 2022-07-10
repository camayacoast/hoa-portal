<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Member\NewsResource;
use App\Models\Lot;
use App\Models\Subdivision;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
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
        $lot = Lot::select('subdivision_id')->where('user_id',$userId)->where('hoa_subd_lot_default',1)->first();

        $subdivision = Subdivision::where('id',$lot->subdivision_id)->first();
        $events = $subdivision->announcements()->where('hoa_event_notices_type','=','Event')->latest()->get();

        return NewsResource::collection($events);
    }
}
