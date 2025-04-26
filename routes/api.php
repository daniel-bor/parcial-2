<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para Productos API
Route::apiResource('products', ProductController::class);

// Rutas para Pedidos API
Route::apiResource('orders', OrderController::class);
