<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
});
*/

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/products', [ProductController::class, 'index']);
    });

   
   
});



/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/