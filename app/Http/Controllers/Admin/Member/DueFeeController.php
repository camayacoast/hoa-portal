<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Member\DueFeeResource;
use App\Http\Resources\Admin\Member\LotSubdivisionDuesResource;
use App\Http\Resources\Admin\Member\SubdivisionDuesResource;
use App\Models\Due;
use App\Models\Lot;
use App\Models\Subdivision;
use Illuminate\Http\Request;

class DueFeeController extends Controller
{
    public function index(){
        return DueFeeResource::collection(Lot::with('user','subdivision')
            ->orderBy('id','DESC')
            ->whereHas('user',function ($query){
                $query->where('hoa_member_status','=',1);
            })->paginate(10));
    }

    public function subdivision_fees($id){
//        $lot = Lot::with('subdivision')->where('id',$id)->first();
        $lot = Lot::findOrFail($id);
        $subdivision = Subdivision::findOrFail($lot->subdivision_id);
        $due = Due::with('subdivision')->where('subdivision_id',$subdivision->id)
            ->where('hoa_subd_dues_status','=',1)
            ->get();
       return SubdivisionDuesResource::collection($due);
    }
    public function search_due_fee()
    {
        $data = \Request::get('find');
        if ($data !== "") {
            $dueFee = Lot::with('user','subdivision')
                ->orderBy('id','DESC')
                ->where(function ($query) use ($data) {
                $query->where('hoa_subd_lot_street_name', 'Like', '%' . $data . '%');

            })
                ->orWhereHas('user',function ($query) use ($data){
                    $query
                        ->where('hoa_member_status','=',1)
                        ->whereRaw("concat(hoa_member_lname, ' ', hoa_member_fname) like '%$data%' ");

                })
                ->paginate(10);
            $dueFee->appends(['find' => $data]);
        } else {
            $dueFee = Lot::orderBy('id','DESC')->paginate(10);
        }
        return DueFeeResource::collection($dueFee);
    }
}
