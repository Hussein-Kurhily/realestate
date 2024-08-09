<?php

namespace App\Http;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\RentRealestateController;
use App\Http\Controllers\SaleRealestateController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



//                           Auth

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth/login');
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::delete('/auth/removeAccount', [AuthController::class, 'removeAccount']);
});
    



//                            orders 
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('/add-orders', [OrdersController::class, 'storeOrder']);
    Route::get('/sale-orders', [OrdersController::class, 'getSaleOrders']);
    Route::get('/rent-orders', [OrdersController::class, 'getRentOrders']);
    Route::delete('/destroy-orders', [OrdersController::class, 'destroy']);
    Route::get('/my-orders', [OrdersController::class, 'show']);
    });

//                   sale   realestate end points

Route::group(['middleware'=>'auth:sanctum'], function(){
    //Route::apiResource('sale-realestate', SaleRealestateController::class);
    Route::post('/sale-realestate/store', [SaleRealestateController::class, 'store']);
    Route::get('/sale-realestate/index', [SaleRealestateController::class, 'index']);
    Route::get('/sale-realestate/show-mine', [SaleRealestateController::class, 'show']);
    Route::get('/sale-realestate/show-by-countries', [SaleRealestateController::class, 'showRealEstateByCountry']);
    Route::delete('/sale-realestate/delete', [SaleRealestateController::class, 'destroy']);  
});


//                    rent  realestate end points

Route::group(['middleware'=>'auth:sanctum'], function(){

    Route::post('/rent-realestate/store', [RentRealestateController::class, 'store']);
    Route::get('/rent-realestate/index', [RentRealestateController::class, 'index']);
    Route::get('/rent-realestate/show-mine', [RentRealestateController::class, 'show']);
    Route::get('/rent-realestate/show-by-countries', [RentRealestateController::class, 'showRealEstateByCountry']);
    Route::delete('/rent-realestate/delete', [RentRealestateController::class, 'destroy']);  
});


//Route::get('/auth/forgetpassword', [AuthController::class, 'forgetpassword']);
//    //Route::apiResource('sale-realestate', SaleRealestateController::class);
?>