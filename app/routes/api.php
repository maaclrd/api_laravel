<?php

use App\Http\Controllers\Api\ProductController;

Route::get('products/list', [ProductController::class, 'list']);
Route::apiResource('products', ProductController::class);
Route::patch('products/{id}/restore', [ProductController::class, 'restore']); 