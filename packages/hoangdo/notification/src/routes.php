<?php

use HoangDo\Authorization\Enum\BaseRole;
use HoangDo\Authorization\Helper\RoleUtils;
use HoangDo\Notification\Controller\AdminController;
use HoangDo\Notification\Controller\ApiController;

Route::group(['prefix' => 'api/v1/notifications', 'middleware' => ['api', 'auth:jwt']], function () {
    Route::get('', [ApiController::class, 'list']);
    Route::patch('{id}', [ApiController::class, 'read']);
    Route::post('', [AdminController::class, 'create'])
        ->middleware(RoleUtils::hasAny(BaseRole::CAN_MANAGE_NOTIFICATIONS));
});
