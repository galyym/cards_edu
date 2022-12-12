<?php

use App\Http\Controllers\Card\CardController;
use App\Http\Controllers\Card\CardListController;
use App\Http\Controllers\Card\GenerateCardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Card\PdfController;
use App\Http\Controllers\MergeController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('card', [CardController::class, 'index']);
Route::get('list', [CardListController::class, 'list']);
Route::post('generate', [GenerateCardController::class, 'createCard']);
Route::get('genpdf/student', [PdfController::class, 'genaratePdfStudent']);
Route::get('genpdf/teacher', [PdfController::class, 'genaratePdfTeacher']);
Route::get('genpdf/personal', [PdfController::class, 'genaratePdfPersonal']);
Route::post('gen/pdf', [PdfController::class, 'index']);
Route::get("test", [PdfController::class, 'getLastNum']);
Route::get('student/name', [CardController::class, "getSudentName"]);
Route::get("merge", [MergeController::class, "merge"]);
Route::get("test1", function (){

    Config::set('database.connections.kukadb', [
        'driver' => 'mysql',
        'url' => env('DATABASE_URL'),
        'host' => '188.0.152.123',
        'port' => '37827',
        'database' => 'cards_log',
        'username' => '192.168.31.20',
        'password' => "",
        'unix_socket' => env('DB_SOCKET', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => null
    ]);

   $query = DB::connection("kukadb")
       ->table("cards_ready")
       ->select("full_name", "qr_code")
       ->where("user_id", "=", null)
       ->get();

   $all_students = [];
   $mektep_student = DB::table("mektep_students")
       ->select("*")
       ->get()
       ->toArray();

   foreach ($mektep_student as $m){
       foreach ($query as $q){
           if ($q->qr_code == md5($m->iin) && $m->iin != 000000000000){
               $all_students[] = [
                   "iin" => $m->iin,
                   "name" => $m->name,
                   "surname" => $m->surname,
                   "id" => $m->id
               ];
           }
       }
   }

   dd($all_students);

   dd($query);
});
