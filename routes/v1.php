<?php

use App\Http\Controllers\Auth\UserInfoController;
use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\ProductController;
use App\Http\Controllers\V1\TagController;

Route::group(['prefix' => 'user-info'], function () {
    Route::get('', [UserInfoController::class, 'userData']);
});

Route::group(['prefix' => 'categories'], function () {
    $controller = CategoryController::class;
    Route::post('', [$controller, 'create']);
    Route::get('', [$controller, 'list']);
    Route::get('{url}', [$controller, 'single']);
    Route::put('{url}', [$controller, 'edit']);
    Route::delete('{url}', [$controller, 'delete']);
});

Route::group(['prefix' => 'products'], function () {
    $controller = ProductController::class;
    Route::post('', [$controller, 'create'])->middleware('transaction');
    Route::get('', [$controller, 'list'])->middleware('transaction');
    Route::get('{slug}', [$controller, 'single']);
    Route::put('{slug}', [$controller, 'edit']);
    Route::delete('{slug}', [$controller, 'delete']);
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('', [TagController::class, 'list']);
});
