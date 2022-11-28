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

        //$request->validated();

        $query = DB::table('cards')->where('card_number', $request->card_number)->update([
            'nfc'         => $request->nfc,
        ]);

        if ($query){
            return response("success", 200);
        }else{
            return response('error', 400);
        }
    }
}
