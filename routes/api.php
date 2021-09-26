<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\v1\AdminController;
use App\Http\Controllers\v1\CartController;
use App\Http\Controllers\v1\CreditCardController;
use App\Http\Controllers\v1\CustomerController;
use App\Http\Controllers\v1\FilmController;
use App\Http\Controllers\v1\OrdersController;
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
//Route::get('/verifycard/{id}',[CreditCardController::class,'verifyIfUserHasCard']);
Route::post('/create/admin',[AdminController::class,'store']);

Route::post('/admin/login',[AdminAuthController::class,'login']);
Route::group(['prefix'=>'admin'],function(){
    Route::post('/create-film',[FilmController::class,'store']);
    Route::post('/edit-film/{id}', [FilmController::class,'update']);
    Route::get('/film/edit/{id}', [FilmController::class,'edit']);
    Route::post('/film/{id}', [FilmController::class,'show']);
    Route::get('/films', [FilmController::class,'index']);
    Route::get('/view/film/{genre}', [FilmController::class,'getFilmByGenre']);
    Route::get('/product/{char}', [FilmController::class,'getProductByChar']);

    Route::get('/customer/{age}',[CustomerController::class,'getCustomerByAge']);
    Route::get('/customers',[CustomerController::class,'index'])

    Route::get('/purchase/{id}',[CustomerController::class,'customerTotalPurchase']);
    Route::get('/sales/{month}',[CustomerController::class,'monthlySales']);

    Route::post('/logout',[AdminAuthController::class,'logout']);

});

Route::post('/create-user', [CustomerController::class, 'store']);
Route::post('/login',[CustomerAuthController::class,'login']);
Route::group(['prefix'=>'user','middleware'=>['assign.guard:customers', 'jwt.auth']], function (){
    Route::get('/edit/data/{id}', [CustomerController::class, 'show']); // This returns the data to be edited
    Route::post('/payment',[CustomerController::class,'makePayment']);
    Route::post('/edit/{id}', [CustomerController::class, 'update']); //This edits the user with the particular id

    Route::post('/create/card',[CreditCardController::class,'store']);
    Route::get('/show/card/{id}',[CreditCardController::class,'show']); //Show the credit card details to be updated
    Route::post('/update/card/{id}',[CreditCardController::class,'update']);
    Route::get('/verifycard/{id}',[CreditCardController::class,'verifyIfUserHasCard']);

    //Cart endpoints
    Route::post('/create/cart',[CartController::class,'store']);
    Route::get('/all-cart/{id}', [CartController::class,'cartTotal']);
    Route::get('/show/cart/{id}',[CartController::class,'show']); //Show the content of the cart
//    Route::delete('/cart/delete',[CartController::class,'clearCart']);

    //Orders endpoints
    Route::post('/order', [OrdersController::class,'store']);
    Route::post('/logout',[CustomerAuthController::class,'logout']);
});
Route::post('/cart/delete',[CartController::class,'clearCart']);
