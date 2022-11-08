<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (\Illuminate\Http\Request $request) {

    dd($request);

//    $jarr=array(
//        'data'  =>  array(
//            array(
//                'cardid'=>$_GET['cardid'],
//                'cjihao'=>$_GET['cjihao'],
//                'mjihao'=>(int)$_GET['mjihao'],
//                'status'=>0,
//                'time'=>strval(time()),
//                'output'=>2
//            ),
//        ),
//        'code'=>0,
//        'message'=>''
//    );

    \Illuminate\Support\Facades\Log::info(json_decode($jarr));

//    return response([
//        "data" => [
//            "cardid" => 54,
//            "cjihao" => "HW256097",
//            "mjihao" => 1,
//            "status" => 1,
//            "time" => 1540404036,
//            "output" => 0
//        ],
//        "code" => 0,
//        "message" => "success"
//    ]);
});

Route::get('cards', function (){
    return view('card');
});
