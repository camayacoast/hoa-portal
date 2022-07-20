<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\PaymentAddressRequest;
use App\Models\Billing;
use App\Models\Document;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentAddressController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PaymentAddressRequest $request,$id)
    {
        $data = $request->validated();
        $userId = auth()->user()->id;
        $document = Document::create([
            'user_id'=>$userId,
            'hoa_document_name'=>$data['bank_name'],
            'hoa_document_desc'=>$data['amount_paid'],
            'hoa_document_tag'=>'Receipt',
            'hoa_document_modifiedby'=>$userId
        ]);
        if($data['filenames']){
            foreach($data['filenames'] as $file)
            {
                $relativePath  = $this->saveImage($file);
                $dataFile = $relativePath;
                $file = new File();
                $file->document_id = $document->id;
                $file->filenames = $dataFile;
                $file->save();
            }
        }
        $request = Billing::where('id','=',$id)->update([
            'hoa_billing_date_paid'=>$data['date_paid'],
            'hoa_billing_amount_paid'=>$data['amount_paid'],
            'hoa_billing_status'=>'For Verification'
        ]);

        return $request;
    }

    private function saveImage($image)
    {
        // Check if image is valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type) || preg_match('/^data:application\/(\w+);base64,/', $image, $type)) {
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
