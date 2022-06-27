<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Lot;
use App\Models\Subdivision;
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
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $data = [];
        if($user->hoa_access_type === 2){
            foreach ($user->subdivisions as $subdivision){
                $data[]=$subdivision->id;

            }
            $userMember = Lot::select('subdivision_id')->whereIn('subdivision_id',$data)->count();

            $userPerMonth = Lot::with(['user'=>function($query){
                $query->where('created_at','>=', Carbon::now()->subMonth()->toDateTimeString());
            }])
                ->whereIn('subdivision_id',$data)
                ->count();

            $users = Lot::select('user_id')->whereIn('subdivision_id',$data)->get();

            $cardId = [];
            foreach ($users as $userCard){
                $cardId[] = $userCard->user_id;
            }
            $card = Card::whereIn('user_id',$cardId)->count();



            return response()->json([
                'user'=>$userMember,
                'userPerMonth'=>$userPerMonth,
                'card'=>$card
            ]);

        }

        $userMember = User::where('hoa_member','=',1)->count();
        $card = Card::count();
        $userPerMonth = User::where('created_at','>=', Carbon::now()->subMonth()->toDateTimeString())->count();

        return response()->json([
            'user'=>$userMember,
            'userPerMonth'=>$userPerMonth,
            'card'=>$card
        ]);
    }
}
