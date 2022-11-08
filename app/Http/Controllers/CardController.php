<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CardController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function index(Request $request){

        //$request->validated();

        $query = DB::table('cards')->updateOrInsert([
            'card_number' => $request->card_number,
            'rfid'        => $request->rfid,
            'qr_code'     => $request->qr_code,
            'nfc'         => $request->nfc,
        ]);

        return response(["message" => "success"]);
    }
}
