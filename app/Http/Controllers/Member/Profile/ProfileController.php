<?php

namespace App\Http\Controllers\Member\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Member\Profile\ProfileResource;
use App\Models\Lot;
use Illuminate\Http\Request;

class ProfileController extends Controller
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
        $profile = Lot::with('user','subdivision')
            ->where('user_id',$userId)
            ->where('hoa_subd_lot_default',1)
            ->first();

        return new ProfileResource($profile);
    }
}
