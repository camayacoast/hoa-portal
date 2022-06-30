<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Member\DueFeeResource;
use App\Http\Resources\Admin\Member\LotSubdivisionDuesResource;
use App\Http\Resources\Admin\Member\RegistrationResource;
use App\Http\Resources\Admin\Member\SubdivisionDuesLotResource;
use App\Http\Resources\Admin\Member\SubdivisionDuesResource;
use App\Models\Due;
use App\Models\Lot;
use App\Models\Subdivision;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DueFeeController extends Controller
{
    public function index(){
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $data = [];
        if ($user->hoa_access_type === 2) {
            foreach ($user->subdivisions as $subdivision) {
                $data[] = $subdivision->id;
            }
            $datas = Lot::with('subdivision','user')
                ->whereHas('subdivision', function ($query) use ($data) {
                    $query->whereIn('id', $data);
                })
                ->whereHas('user', function ($query){
                    $query->where('hoa_member_status','=',1);
                })
                ->orderBy('id', 'DESC')
                ->paginate(10);

            return DueFeeResource::collection($datas);
        }
        return DueFeeResource::collection(Lot::with('user','subdivision')
            ->orderBy('id','DESC')
            ->whereHas('user',function ($query){
                $query->where('hoa_member_status','=',1);
            })->paginate(10));
    }

    public function subdivision_fees($id){
        $due = Lot::with('subdivision')
            ->where('id',$id)->first();
       return new SubdivisionDuesLotResource($due);
    }
    public function search_due_fee()
    {
        $data = \Request::get('find');
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        if ($user->hoa_access_type === 2) {
            $datas = [];
            foreach ($user->subdivisions as $subdivision) {
                $datas[] = $subdivision->id;
            }
            return $this->search_due_fee_subdivision_admin($data, $datas);
        }
        return $this->search_due_fee_full_admin($data);

    }

    private function search_due_fee_subdivision_admin($data,$datas){
        if ($data !== "") {
            $dueFee = Lot::with('user','subdivision')
                ->orderBy('id','DESC')
                ->whereHas('subdivision',function ($query) use ($datas){
                    $query->whereIn('id',$datas);
                })
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
            $dueFee = Lot::orderBy('id','DESC')
                ->whereHas('subdivision', function ($query) use ($datas) {
                    $query->whereIn('id', $datas);
                })
                ->paginate(10);
        }
        return DueFeeResource::collection($dueFee);
    }

    private function search_due_fee_full_admin($data){
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
