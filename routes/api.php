<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});
Route::get('products', [ProductController::class, 'index']);
Route::apiResource('products', ProductController::class)->middleware(['auth:sanctum' ])->except('index');
Route::apiResource('orders', OrderController::class)->middleware(['auth:sanctum' ]);
Route::apiResource('payments', PaymentController::class)->middleware(['auth:sanctum' ]);
