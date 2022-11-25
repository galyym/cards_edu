<?php

namespace App\Http\Controllers\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenerateCardController extends Controller
{
    public function createCard(Request $request){

        $last_num = $this->checkLastNum();
        if ($last_num == null){
            $start = 1000;
        }else{
            $start = $last_num->card_number + 1;
        }
        $end = $start + $request->amount;
        $data = [];

        for($i = $start; $i < $end; $i++){
            $data[] = [
                'card_number' => $i
            ];
        }

        $query = DB::table('cards')->insert($data);
        $last = $this->checkLastNum();
        if ($end-1 == $last->card_number && $query == true){
            return response('success', 200);
        }
    }

    public function checkLastNum(){
        $last_num = DB::table('cards')->select('card_number')->orderBy('card_number', 'desc')->first();
        return $last_num;
    }
}
