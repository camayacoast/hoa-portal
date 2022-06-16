<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $user = User::where('hoa_member','=',1)->count();
        $userPerMonth = User::where('created_at','>=', Carbon::now()->subMonth()->toDateTimeString())->count();

        return response()->json([
            'user'=>$user,
            'userPerMonth'=>$userPerMonth
        ]);
    }
}
