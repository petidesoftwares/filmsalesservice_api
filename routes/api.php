<?php

use App\Http\Controllers\v1\CustomerController;
use App\Http\Controllers\v1\FilmController;
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

Route::post('/create-user', [CustomerController::class, 'store']);
Route::post('/create-film',[FilmController::class,'store']);
Route::post('/edit-film/{id}', [FilmController::class,'update']);
Route::post('/edit/resource/{id}', [FilmController::class,'edit']);
Route::post('/view/film/{id}', [FilmController::class,'show']);
