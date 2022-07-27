<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutogateGateSyncController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {

        $decoded_filter_for_inserts_updates = json_decode($request->filter_for_inserts_updates);

        $autogates = $this->read('autogates',
            $decoded_filter_for_inserts_updates->autogates->id,
            $decoded_filter_for_inserts_updates->autogates->updated_at);

        $cards = $this->read('cards',
            $decoded_filter_for_inserts_updates->cards->id,
            $decoded_filter_for_inserts_updates->cards->updated_at);

         $designees = $this->read('designees',
             $decoded_filter_for_inserts_updates->designees->id,
             $decoded_filter_for_inserts_updates->designees->updated_at);

        $messages = $this->read('messages',
            $decoded_filter_for_inserts_updates->messages->id,
            $decoded_filter_for_inserts_updates->messages->updated_at);

        $templates = $this->read('templates',
            $decoded_filter_for_inserts_updates->templates->id,
            $decoded_filter_for_inserts_updates->templates->updated_at);



        return response()->json([
            'success' => true,
            'data' => [
                'autogates' => $autogates,
                'templates' => $templates,
                'messages' => $messages,
                'cards'=>$cards,
                'designees'=>$designees
            ]
        ]);
    }

    private function read($table, $id, $updated_at)
    {
        $query = DB::table($table);

        if ($id && $updated_at) {
            $query->where($table.'.id', '>', $id);
            $query->orWhere($table.'.updated_at', '>', $updated_at);
        }

        if (in_array($table, ['autogates', 'messages', 'templates'])) {
            if ($table == 'autogates') {
                $query->select('autogates.*');
            } else if ($table == 'messages') {
                $query->select('messages.*');
            } else if ($table == 'templates') {
                $query->select('templates.*');
            } else if($table == 'cards'){
                $query->select('cards.*');
            } else if($table == 'designees'){
                $query->select('designees.*');
            }
        }
        return $query->get();
    }
}
