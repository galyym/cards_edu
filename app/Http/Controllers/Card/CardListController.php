<?php

namespace App\Http\Controllers\Card;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CardListController extends Controller
{
    public function list(){
        $list = DB::table('cards')->select("card_number", "rfid", "nfc")->orderBy('card_number', 'desc')->get();
        return response($list);
    }
}
