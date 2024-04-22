<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('categorys')->group(function () {
    Route::get('/', [CategoryController::class, "index"]);
    Route::post('/', [CategoryController::class, "store"]);
    Route::get('/{id}', [CategoryController::class, "show"]);
    Route::put('/{id}', [CategoryController::class, "update"]);
    Route::delete('/{id}', [CategoryController::class, "destroy"]);
});
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, "index"]);
    Route::post('/', [ProductController::class, "store"]);
    Route::get('/{id}', [ProductController::class, "show"]);
    Route::put('/{id}', [ProductController::class, "update"]);
    Route::delete('/{id}', [ProductController::class, "destroy"]);
});

Route::get('/images/products/{imageName}',[ImageController::class,"getImage"]);