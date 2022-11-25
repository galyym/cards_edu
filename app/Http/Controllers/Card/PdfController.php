<?php

namespace App\Http\Controllers\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\PdfEmptyCards;
use Mpdf;
use App\Jobs\PdfFullCards;

class PdfController extends Controller
{
    public function index(Request $request){

        $start = $request->start;
        $end = $request->end;
        if ($this->isHave($start) === false || $this->isHave($end) === false){
            return response("Ошибка при проверке начальную или последнею цифру.");
        }
        PdfEmptyCards::dispatch($start, $end);
        return $request->all();
    }

    // генерация карточек для учеников
    public function genaratePdfStudent(Request $request){

        $query = DB::table('mektep_students')
            ->select('surname', 'name')
            ->selectRaw('MD5(iin) as iin')
            ->where('id_mektep', $request->id)
            ->get()
            ->toArray();
        $clunk = [];

        if (count($query) > 100){
            $clunk = array_chunk($query, 100);
        } else {
            $clunk[] = $query;
        }
        $last = $this->getLastNum();
        $count = $last == null?2010000:$last->card_number+1;
        foreach ($clunk as $part){
            PdfFullCards::dispatch($part, $count, $request->id, "student")->onQueue('cards');
            $count = $count + 100;
        }

        return response('Генерация 100 карточек займет примерно 1 минута, вам придется ждать несколько минут чтобы получить pdf документ');
    }

    //генерация карточек для учителей
    public function genaratePdfTeacher(Request $request){
        $query = DB::table('mektep_teacher')
            ->select('surname', 'name')
            ->selectRaw('MD5(iin) as iin')
            ->where('id_mektep', $request->id)
            ->get()
            ->toArray();
        $clunk = [];

        if (count($query) > 100){
            $clunk = array_chunk($query, 100);
        } else {
            $clunk[] = $query;
        }
        $last = $this->getLastNum();
        $count = $last == null?2010000:$last->card_number+1;
        foreach ($clunk as $part){
            PdfFullCards::dispatch($part, $count, $request->id, "teacher")->onQueue('cards');
            $count = $count + 100;
        }

        return response('Генерация 100 карточек займет примерно 1 минута, вам придется ждать несколько минут чтобы получить pdf документ');
    }

    public function isHave($card_num){
        $query = DB::table('cards')->select('card_number')->where('card_number', $card_num)->get()->toArray();
        if (empty($query)){
            return false;
        }
        return true;
    }

    // получаем номер последнюю генерированную карту
    public function getLastNum(){
        $last_num_ready = DB::table('cards_ready')->select("card_number")->orderBy('card_number', 'desc')->first();
        $last_num_empty = DB::table('cards')->select('card_number')->orderBy('card_number', 'desc')->first();

        if ($last_num_empty > $last_num_ready){
            return $last_num_empty;
        }else{
            return $last_num_ready;
        }
    }
}
