<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\DocumentRequest;
use App\Http\Resources\Admin\Member\DocumentResource;
use App\Models\Document;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return DocumentResource::collection(Document::where('user_id',$id)->orderBy('id','DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request,Document $document)
    {
        DB::transaction(function() use ($request,$document){
            $data = $request->validated();

            if($data){
                $data['hoa_document_modifiedby'] = auth()->user()->id;
            }
            $requestDocument = $document->create([
                'user_id'=>$data['user_id'],
                'hoa_document_name'=>$data['hoa_document_name'],
                'hoa_document_desc'=>$data['hoa_document_desc'],
                'hoa_document_tag'=>$data['hoa_document_tag'],
                'hoa_document_modifiedby'=>$data['hoa_document_modifiedby']
            ]);
            if($data['filenames']){
                foreach($data['filenames'] as $file)
                {
                    $relativePath  = $this->saveImage($file);
                    $dataFile = $relativePath;
                    $file = new File();
                    $file->document_id = $requestDocument->id;;
                    $file->filenames = $dataFile;
                    $file->save();
                }
            }
            return $requestDocument;
        });

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Document::findOrFail($id);
        return new DocumentResource($document);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentRequest $request, $id)
    {
        $document = Document::findOrFail($id);
        DB::transaction(function() use ($request,$document){
            $data = $request->validated();

            if($data){
                $data['hoa_document_modifiedby'] = auth()->user()->id;
            }
            $requestDocument = $document->update([
                'user_id'=>$data['user_id'],
                'hoa_document_name'=>$data['hoa_document_name'],
                'hoa_document_desc'=>$data['hoa_document_desc'],
                'hoa_document_tag'=>$data['hoa_document_tag'],
                'hoa_document_modifiedby'=>$data['hoa_document_modifiedby']
            ]);
            if($data['filenames']){
                foreach($data['filenames'] as $file)
                {
                    $relativePath  = $this->saveImage($file);
                    $dataFile = $relativePath;
                    $file = new File();
                    $file->document_id = $document->id;;
                    $file->filenames = $dataFile;
                    $file->save();
                }
            }
            return $requestDocument;
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id){
            $document = Document::findOrFail($id);
            $files =  File::where('document_id',$document->id)->get();
            foreach ($files as $file){
                if ($file->filenames) {
                    $absolutePath = public_path($file->filenames);
                    \Illuminate\Support\Facades\File::delete($absolutePath);
                }
                $file->delete();
            }

            $request = $document->delete();
            return $request;
        });


    }

    public function deleteFile($id){
        $file = File::findOrFail($id);
        if($file->filenames){
            $absolutePath = public_path($file->filenames);
            \Illuminate\Support\Facades\File::delete($absolutePath);
        }
        $file->delete();
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
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png','pdf'])) {
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

        $dir = 'documents/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!\Illuminate\Support\Facades\File::exists($absolutePath)) {
            \Illuminate\Support\Facades\File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }

}
