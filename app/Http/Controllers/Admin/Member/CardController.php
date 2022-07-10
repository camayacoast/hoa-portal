<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\StoreCardRequest;
use App\Http\Requests\Admin\Member\UpdateCardRequest;
use App\Http\Resources\Admin\Member\CardResource;
use App\Http\Resources\Admin\ShowEmailResource;
use App\Models\Card;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $data = [];
        if ($user->hoa_access_type === 2) {
            foreach ($user->subdivisions as $subdivision) {
                $data[] = $subdivision->id;
            }
            $datas = Lot::select('user_id')->whereIn('subdivision_id',$data)->get();

            $cardId = [];
            foreach ($datas as $userCard){
                $cardId[] = $userCard->user_id;
            }
            $cards = Card::with('user')
                    ->orderBy('id','DESC')
                    ->where('user_id',$cardId)
                    ->paginate(10);
            return CardResource::collection($cards);
        }
        return CardResource::collection(Card::with('user')->orderBy('id','DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCardRequest $request,Card $card)
    {
        $data = $request->validated();
        if($data){
            $data['hoa_rfid_reg_modified'] = auth()->user()->id;
        }
        $request = $card->create($data);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $card = Card::findOrFail($id);
        return new CardResource($card);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCardRequest $request, $id)
    {
        $card = Card::findOrFail($id);
        $data = $request->validated();
        if($data){
            $data['hoa_rfid_reg_modified'] = auth()->user()->id;
        }
        $request = $card->update($data);
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search_rfid()
    {
        $data = \Request::get('find');
        $id = auth()->user()->id;
        $user = User::findOrFail($id);

        if ($user->hoa_access_type === 2) {
            foreach ($user->subdivisions as $subdivision) {
                $data[] = $subdivision->id;
            }
            $datas = Lot::select('user_id')->whereIn('subdivision_id', $data)->get();

            $cardId = [];
            foreach ($datas as $userCard) {
                $cardId[] = $userCard->user_id;
            }
            return $this->search_dues_subdivision_admin($data,$cardId);
        }
        return $this->search_dues_full_admin($data);
    }

    public function show_email()
    {
        $user = User::where('hoa_member_status','=',1)->paginate(50);
        return ShowEmailResource::collection($user);
    }

    private function search_dues_subdivision_admin($data,$datas){
        if ($data !== "") {
            $rfid = Card::with('user')
                ->orderBy('id', 'DESC')
                ->where('user_id',$datas)
                ->where('hoa_rfid_semnox_num','Like','%'.$data.'%')
                ->orWhere('hoa_rfid_num','Like','%'.$data.'%')
                ->whereHas('user',function ($query) use ($data) {
                $query->where('hoa_member_fname', 'Like', '%' . $data. '%')

                    ->orWhere('hoa_member_lname','like','%'.$data.'%')
                    ->orWhereRaw("concat(hoa_member_lname, ' ', hoa_member_fname) like '%$data%' ")
                    ->orWhereRaw("concat(hoa_member_fname, ' ', hoa_member_lname) like '%$data%' ");
            })->paginate(10);
            $rfid->appends(['find' => $data]);
        } else {
            $rfid = Card::with('user')->orderBy('id', 'DESC')->paginate(10);
        }
        return CardResource::collection($rfid);
    }

    private function search_dues_full_admin($data){
        if ($data !== "") {
            $rfid = Card::with('user')->orderBy('id', 'DESC')
                ->where(function ($query) use ($data) {
                    $query->where('hoa_rfid_semnox_num','LIKE','%'.$data.'%')
                        ->orWhere('hoa_rfid_num','LIKE','%'.$data.'%');
                })
                ->orWhereHas('user',function ($query) use ($data) {
                $query->where('hoa_member_fname', 'Like', '%' . $data. '%')
                    ->orWhere('hoa_member_lname','like','%'.$data.'%')
                    ->orWhereRaw("concat(hoa_member_lname, ' ', hoa_member_fname) like '%$data%' ")
                    ->orWhereRaw("concat(hoa_member_fname, ' ', hoa_member_lname) like '%$data%' ");
            })->paginate(10);
            $rfid->appends(['find' => $data]);
        } else {
            $rfid = Card::with('user')->orderBy('id', 'DESC')->paginate(10);
        }
        return CardResource::collection($rfid);
    }
}
