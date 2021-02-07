<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ContatosController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get("/contatos", [ContatosController::class, 'index']);
Route::prefix("/contatos")->group(function () {
    Route::post('/store', [ContatosController::class, 'store']);
    Route::post('/update/{id}', [ContatosController::class, 'update']);
    Route::post('/delete/{id}', [ContatosController::class, 'destroy']);
});
