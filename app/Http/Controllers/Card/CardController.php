<?php

namespace App\Http\Controllers\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CardController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function index(Request $request){

        $query = DB::table('cards_ready')->where('card_number', $request->card_number)->update([
            'nfc'         => $request->nfc,
            'qr_code'     => $request->qr_code
        ]);

        if ($query){
            return response("success", 200);
        }else{
            return response('error', 400);
        }
    }

    public function getSudentName(Request $request){
        if ($request->card_number != null) {
            $query = DB::table('cards_ready')->select("full_name")->where("card_number", "=", $request->card_number)->first();
        }else{
            return response('Номер карты не найдена', 403);
        }

        if ($query){
            return response([
                "name" => $query->full_name
            ], 200);
        }else{
            return response("К этой карте никто не зарегистрировано", 400);
        }
    }
}
