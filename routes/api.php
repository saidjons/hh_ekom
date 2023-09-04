<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
 
Route::post("login",[UserController::class,"login"]);
Route::post("register",[UserController::class,"register"]);

Route::get("search",[ProductController::class,"search"]);


Route::prefix("buyer")->middleware(["auth:sanctum"])->group(function(){
    Route::post("cart/add",[CartController::class,"store"]);
    Route::get("cart",[CartController::class,"show"]);
    Route::delete("cart/{id}",[CartController::class,"delete"]);


});

Route::prefix("admin")->middleware(["auth:sanctum","role:admin"])->group(function(){
    ###### user #######
    Route::get("user",[UserController::class,"index"]);
    
    Route::get("user/{id}",[UserController::class,"show"]);
    Route::put("user/{user}",[UserController::class,"update"]);

    Route::delete("user/{id}",[UserController::class,"delete"]);
    ###### product #######
    Route::get("product",[ProductController::class,"index"]);
    Route::get("product/{id}",[ProductController::class,"show"]);
    Route::post("product",[ProductController::class,"store"]);
    Route::put("product/{product}",[ProductController::class,"update"]);
    Route::delete("product/{id}",[ProductController::class,"delete"]);

    ###### category #######
    Route::get("category",[CategoryController::class,"index"]);
    Route::get("category",[CategoryController::class,"index"]);
    Route::get("category/{id}",[CategoryController::class,"show"]);

    Route::post("category",[CategoryController::class,"store"]);
    Route::put("category/{category}",[CategoryController::class,"update"]);
    
    Route::put("category/sort/{category}",[CategoryController::class,"sortSubs"]);

    Route::delete("category/{id}",[CategoryController::class,"delete"]);

    Route::post("category/sub/add/{category}",[CategoryController::class,"addSubToCat"]);
    // TODO:add subs to category
    

    
        ####### cart ##############
  
});

 