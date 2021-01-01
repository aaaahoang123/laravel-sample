<?php

use HoangDo\Storage\FileStorageController;

Route::post('api/storage/upload', [FileStorageController::class, 'upload'])
    ->middleware(['api', 'auth']);
