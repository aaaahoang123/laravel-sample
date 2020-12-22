<?php

use App\Http\Controllers\Auth\UserInfoController;
use App\Http\Controllers\V1\CategoryController;

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
