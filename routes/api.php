<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Categoriescontroller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\OAuthController;



//Route Middleware
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route untuk Product
Route::post('/product',[ProductController::class,'store']);
Route::get('/product',[ProductController::class,'showAll']);
Route::put('/product/{id}',[ProductController::class,'update']);
Route::delete('/product/{id}',[ProductController::class,'delete']);


//Route untuk Categories
Route::post('/categories',[Categoriescontroller::class,'store']);
Route::get('/categories',[Categoriescontroller::class,'showAll']);
Route::put('/categories/{id}',[Categoriescontroller::class,'update']);
Route::delete('/categories/{id}',[Categoriescontroller::class,'delete']);

//Route untuk login
Route::post('login',[UserController::class,'login']);

//Route untuk register
Route::post("/register", [RegisterController::class, "store"]);

//Route Oauth
Route::group(['middleware' => ['web']], function () {
    Route::get('/oauth/register', [OAuthController::class, 'redirect']);
    Route::get('/auth/google/callback', [OAuthController::class, 'callback']);
});

//Route::get('/auth/google', [OAuthController::class, 'redirectToGoogle']);
//Route::get('/auth/google/callback', [OAuthController::class, 'handleGoogleCallback']);

//Route untuk middleware Category
Route::middleware(['category-auth'])->group(function(){
    Route::post('/categories',[Categoriescontroller::class,'store']);
    Route::get('/categories',[Categoriescontroller::class,'showAll']);
    Route::put('/categories/{id}',[Categoriescontroller::class,'update']);
    Route::delete('/categories/{id}',[Categoriescontroller::class,'delete']);
});

//Route untuk middleware Product
Route::middleware(['product-auth'])->group(function(){
    Route::post('/products',[ProductController::class,'store']);
    Route::get('/products',[ProductController::class,'showAll']);
    Route::put('/products/{id}',[ProductController::class,'update']);
    Route::delete('/products/{id}',[ProductController::class,'delete']);
});