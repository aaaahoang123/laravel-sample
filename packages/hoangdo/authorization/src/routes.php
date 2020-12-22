<?php

use HoangDo\Authorization\Controller\PolicyManageController;
use HoangDo\Authorization\Enum\BaseRole;
use HoangDo\Authorization\Helper\RoleUtils;

Route::group([
    'prefix' => config('authorization.manager_route'),
    'middleware' => [
        'api',
        'auth:jwt',
        RoleUtils::hasAny(BaseRole::CAN_MANAGE_POLICIES)
    ],
], function () {
    Route::post('join', [PolicyManageController::class, 'userJoinPolicy']);
    Route::put('out', [PolicyManageController::class, 'userOutPolicy']);
    Route::post('', [PolicyManageController::class, 'createPolicy']);
    Route::get('', [PolicyManageController::class, 'listPolicies']);
    Route::get('{id}', [PolicyManageController::class, 'singlePolicy']);
    Route::put('{id}', [PolicyManageController::class, 'editPolicy']);
    Route::delete('{id}', [PolicyManageController::class, 'deletePolicy']);
});
