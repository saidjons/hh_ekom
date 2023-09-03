<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 

Route::prefix("admin")->group(function(){
    Route::get("product",[ProductController::class,"index"]);
    Route::get("product/{id}",[ProductController::class,"show"]);
    Route::post("product",[ProductController::class,"store"]);
    Route::put("product/{product}",[ProductController::class,"update"]);
    Route::delete("product/{id}",[ProductController::class,"delete"]);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
