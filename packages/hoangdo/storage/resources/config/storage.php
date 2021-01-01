<?php

use HoangDo\Storage\CommonStorageFolder;

return [
    'mimes' => env('STORAGE_MIMES', 'png,jpg,jpeg,gif'),
    'path' => env('STORAGE_PATH', 'upload/images/'),
    'daily_folder' => env('STORAGE_DAILY_FOLDER', CommonStorageFolder::PRODUCTS),
    'folder_enum' => env('STORAGE_FOLDER_ENUM')
];
