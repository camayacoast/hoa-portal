<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DirectorRequest;
use App\Http\Resources\Admin\DirectorResource;
use App\Http\Resources\Admin\showDirectorUserResource;
use App\Models\Director;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index($id)
    {
        return DirectorResource::collection(Director::where('subdivision_id',$id)->orderBy('id','DESC')->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DirectorRequest $request
     * @param Director $director
     * @return Response
     * @throws Exception
     */
    public function store(DirectorRequest $request,Director $director)
    {
        $data = $request->validated();

        if($data){
            $data['hoa_bod_modifiedby'] = auth()->user()->id;
        }

        if (isset($data['image'])) {
            $relativePath  = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }
        $request = $director->create($data);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return DirectorResource
     */
    public function show($id)
    {
        $directors = Director::findOrFail($id);
        return new DirectorResource($directors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DirectorRequest $request
     * @param $id
     * @return Response
     * @throws Exception
     */
    public function update(DirectorRequest $request, $id)
    {
        $director = Director::findOrFail($id);
        $data = $request->validated();
        // Check if image was given and save on local file system
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;

            // If there is an old image, delete it
            if ($director->image) {
                $absolutePath = public_path($director->image);
                File::delete($absolutePath);
            }
        }

        $request = $director->update($data);
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Director $director
     * @return void
     */
    public function destroy($id)
    {
        $director = Director::findOrFail($id);
        $director->delete();

        if ($director->image) {
            $absolutePath = public_path($director->image);
            File::delete($absolutePath);
        }
        return response('',204);
    }

    public function show_user($id)
    {
        $user = Director::with('user')->where('subdivision_id',$id)->paginate(50);
        return ShowDirectorUserResource::collection($user);
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
            throw new Exception('did not match data URI with image data');
        }

        $dir = 'images/';
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