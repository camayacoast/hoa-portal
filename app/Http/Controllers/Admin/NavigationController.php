<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ShowEmailResource;
use App\Models\User;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $id = auth()->user()->id;
        return new ShowEmailResource(User::where('id','=',$id)->first());
    }
}
