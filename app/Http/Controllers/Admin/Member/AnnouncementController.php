<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\AnnouncementRequest;
use App\Http\Resources\Admin\Member\AnnouncementResource;
use App\Models\Announcement;
use App\Models\Subdivision;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return AnnouncementResource::collection(Announcement::orderBy('id','DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AnnouncementRequest $request
     * @return void
     */
    public function store(AnnouncementRequest $request,Announcement $announcement,Subdivision $subdivision)
    {
        DB::transaction(function () use ($request,$announcement,$subdivision){
            $data = $request->validated();
            if($data){
                $data['hoa_event_notices_modifiedby'] = auth()->user()->id;
            }

            if (isset($data['hoa_event_notices_photo'])) {
                $relativePath  = $this->saveImage($data['hoa_event_notices_photo']);
                $data['hoa_event_notices_photo'] = $relativePath;
            }

            $request = $announcement->create([
                'hoa_event_notices_type'=>$data['hoa_event_notices_type'],
                'hoa_event_notices_title'=>$data['hoa_event_notices_title'],
                'hoa_event_notices_desc'=>$data['hoa_event_notices_desc'],
                'hoa_event_notices_photo'=>$data['hoa_event_notices_photo'],
                'hoa_event_notices_modifiedby'=>$data['hoa_event_notices_modifiedby']
            ]);
            if($data['subdivision_id']){
                foreach($data['subdivision_id'] as $subdId){
                    $request->subdivisions()->attach($subdId);
                }
            }
            return $request;
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return Response
     */
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return new AnnouncementResource($announcement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Announcement  $announcement
     * @return Response
     */
    public function update(AnnouncementRequest $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        DB::transaction(function () use ($request,$announcement){
            $data = $request->validated();
            if($data){
                $data['hoa_event_notices_modifiedby'] = auth()->user()->id;
            }

            if (isset($data['hoa_event_notices_photo'])) {
                $relativePath  = $this->saveImage($data['hoa_event_notices_photo']);
                $data['hoa_event_notices_photo'] = $relativePath;
            }

            $request = $announcement->update([
                'hoa_event_notices_type'=>$data['hoa_event_notices_type'],
                'hoa_event_notices_title'=>$data['hoa_event_notices_title'],
                'hoa_event_notices_desc'=>$data['hoa_event_notices_desc'],
                'hoa_event_notices_photo'=>$data['hoa_event_notices_photo'],
                'hoa_event_notices_modifiedby'=>$data['hoa_event_notices_modifiedby']
            ]);
            if($data['subdivision_id']){
                foreach($data['subdivision_id'] as $subdId){
                    $announcement->subdivisions()->detach($subdId);
                    $announcement->subdivisions()->attach($subdId);
                }
            }
            return $request;
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return Response
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        DB::transaction(function () use ($announcement){
            $announcement->subdivisions()->detach();
            if ($announcement->hoa_event_notices_photo) {
                $absolutePath = public_path($announcement->hoa_event_notices_photo);
                File::delete($absolutePath);
            }
             $announcement->delete();
            return response('',204);
        });
    }

    public function search_announcement()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $announcement = Announcement::orderBy('id','DESC')->where(function ($query) use ($data) {
                $query->where('hoa_event_notices_title', 'Like', '%' . $data . '%')
                    ->orWhere('hoa_event_notices_type', 'Like', '%' . $data . '%');

            })->paginate(10);
            $announcement->appends(['find' => $data]);
        } else {
            $announcement = Announcement::orderBy('id','DESC')->paginate(10);
        }
        return AnnouncementResource::collection($announcement);
    }

    public function showStory($id){
        $announcement = Announcement::findOrFail($id);
        return new AnnouncementResource($announcement);
    }

    public function updateStory(Request $request,$id){
        $announcement = Announcement::findOrFail($id);
        $data =$request->validate([
            'hoa_event_notices_fullstory'=>'required'
        ]);
        $request = $announcement->update([
            'hoa_event_notices_fullstory'=>$data['hoa_event_notices_fullstory']
        ]);
        return $request;

    }
    private function saveImage($image)
    {
        // Check if image is valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Take out the base64 encoded text without mime type
            $image = substr($image, strpos($image, ',') + 1);
            // Get file extension
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new Exception('invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new Exception('base64_decode failed');
            }
        } else {
//            throw new Exception('did not match data URI with image data');
            return $image;
        }

        $dir = 'announcements/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }
}
