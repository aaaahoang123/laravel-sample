<?php

use App\Http\Controllers\V1\ArticleController;
use App\Http\Controllers\V1\BannerController;
use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\ContactMessageController;
use App\Http\Controllers\V1\ProductController;
use App\Http\Controllers\V1\SystemConfigController;
use App\Http\Controllers\V1\TagController;

Route::group(['prefix' => 'categories'], function () {
    $controller = CategoryController::class;
    Route::get('', [$controller, 'list']);
    Route::get('{url}', [$controller, 'single']);
});

Route::group(['prefix' => 'products'], function () {
    $controller = ProductController::class;
    Route::get('', [$controller, 'list']);
    Route::get('{slug}', [$controller, 'single']);
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('', [TagController::class, 'list']);
});

Route::group(['prefix' => 'articles'], function () {
    $controller = ArticleController::class;
    Route::get('', [$controller, 'list']);
    Route::get('{slug}', [$controller, 'single']);
});

Route::group(['prefix' => 'banners'], function () {
    $controller = BannerController::class;
    Route::get('', [$controller, 'list']);
    Route::get('{slug}', [$controller, 'single']);
});

Route::group(['prefix' => 'contact-messages'], function () {
    Route::post('', [ ContactMessageController::class, 'create' ]);
});

Route::group(['prefix' => 'system-configs'], function () {
    Route::get('', [SystemConfigController::class, 'list']);
});
