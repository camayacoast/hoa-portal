<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Member\CardRequest;
use App\Http\Resources\Admin\Member\CardResource;
use App\Models\Card;
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
        return CardResource::collection(Card::with('user')->orderBy('id','DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CardRequest $request,Card $card)
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
    public function update(CardRequest $request, $id)
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
        if ($data !== "") {
            $rfid = Card::with('user')->orderBy('id', 'DESC')->whereHas('user',function ($query) use ($data) {
                $query->where('hoa_member_fname', 'Like', '%' . $data. '%')
                    ->orWhere('hoa_rfid_semnox_num','Like','%'.$data.'%')
                    ->orWhere('hoa_rfid_num','Like','%'.$data.'%')
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
