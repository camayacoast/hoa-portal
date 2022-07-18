<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Member\AnnouncementActionResource;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementActionsController extends Controller
{
    public function showEvent($id){
        $announcement = Announcement::where('id','=',$id)->where('hoa_event_notices_type','=','Event')->first();
        return new AnnouncementActionResource($announcement);
    }

    public function showNews($id){
        $event = Announcement::where('id','=',$id)->where('hoa_event_notices_type','=','News')->first();
        return new AnnouncementActionResource($event);
    }
}
