<?php

use App\Http\Controllers\Auth\UserInfoController;
use App\Http\Controllers\V1\ArticleController;
use App\Http\Controllers\V1\BannerController;
use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\ContactMessageController;
use App\Http\Controllers\V1\CustomerController;
use App\Http\Controllers\V1\DashboardController;
use App\Http\Controllers\V1\ProductController;
use App\Http\Controllers\V1\SystemConfigController;
use App\Http\Controllers\V1\TagController;
use App\Http\Controllers\V1\UserController;

Route::group(['prefix' => 'user-info'], function () {
    Route::get('', [UserInfoController::class, 'userData']);
});

Route::group(['prefix' => 'categories'], function () {
    $controller = CategoryController::class;
    Route::post('', [$controller, 'create'])->middleware('transaction');
    Route::get('', [$controller, 'list']);
    Route::get('{url}', [$controller, 'single']);
    Route::put('{url}', [$controller, 'edit'])->middleware('transaction');
    Route::delete('{url}', [$controller, 'delete']);
});

Route::group(['prefix' => 'products'], function () {
    $controller = ProductController::class;
    Route::post('', [$controller, 'create'])->middleware('transaction');
    Route::get('', [$controller, 'list']);
    Route::get('{slug}', [$controller, 'single']);
    Route::put('{slug}', [$controller, 'edit']);
    Route::delete('{slug}', [$controller, 'delete']);
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('', [TagController::class, 'list']);
});

Route::group(['prefix' => 'articles'], function () {
    $controller = ArticleController::class;
    Route::post('', [$controller, 'create'])->middleware('transaction');
    Route::get('', [$controller, 'list']);
    Route::get('{slug}', [$controller, 'single']);
    Route::put('{slug}', [$controller, 'edit']);
    Route::delete('{slug}', [$controller, 'delete']);
});

Route::group(['prefix' => 'banners'], function () {
    $controller = BannerController::class;
    Route::post('', [$controller, 'create']);
    Route::get('', [$controller, 'list']);
    Route::get('{slug}', [$controller, 'single']);
    Route::put('{slug}', [$controller, 'edit']);
    Route::delete('{slug}', [$controller, 'delete']);
});

Route::group(['prefix' => 'contact-messages'], function () {
    Route::get('', [ ContactMessageController::class, 'list' ]);
    Route::patch('{id}/read', [ ContactMessageController::class, 'markAsRead' ]);
    Route::patch('{id}/resolve', [ ContactMessageController::class, 'markAsResolved' ]);
    Route::delete('{id}', [ ContactMessageController::class, 'markAsDeleted' ]);
});

Route::apiResource('customers', CustomerController::class);
Route::apiResource('users', UserController::class);
Route::group(['prefix' => 'system-configs'], function () {
    Route::get('', [SystemConfigController::class, 'list']);
    Route::put('{id}', [SystemConfigController::class, 'editOrCreate']);
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('products', [DashboardController::class, 'productCounts']);
    Route::get('customers', [ DashboardController::class, 'customerCounts' ]);
    Route::get('messages', [ DashboardController::class, 'contactMessagesCount' ]);
});
