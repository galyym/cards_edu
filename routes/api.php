<?php

use App\Http\Controllers\Card\CardController;
use App\Http\Controllers\Card\CardListController;
use App\Http\Controllers\Card\GenerateCardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
