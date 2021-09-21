<?php

use App\Http\Controllers\Auth\CustomerAuthController;
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
Route::post('/edit/user/{id}', [CustomerController::class, 'update']);
Route::get('/edit/data/{id}', [CustomerController::class, 'edit']);
Route::post('/create-film',[FilmController::class,'store']);
Route::post('/edit-film/{id}', [FilmController::class,'update']);
Route::post('/edit/resource/{id}', [FilmController::class,'edit']);
Route::post('/view/film/{id}', [FilmController::class,'show']);

Route::get('/customer/{age}',[CustomerController::class,'getCustomerByAge']);

Route::post('/login',[CustomerAuthController::class,'login']);
Route::group(['prefix'=>'user','middleware'=>['assign.guard:customers', 'jwt.auth']], function (){
    Route::post('/logout',[CustomerAuthController::class,'logout']);
});
