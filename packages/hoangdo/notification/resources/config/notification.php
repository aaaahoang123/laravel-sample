<?php

return [
    'limit_each_user' => env('NOTIFICATION_LIMIT_TOKEN', 5),
    'limit_each_push' => env('NOTIFICATION_LIMIT_PUSH', 100),
    'token_header' => env('NOTIFICATION_TOKEN_HEADER', 'apptoken'),
    'os_header' => env('NOTIFICATION_OS_HEADER', 'os'),
    'user' => 'App\Models\User',
    'for_all_notification_id' => env('NOTIFICATION_FOR_ALL_ID', -1),
    'fcm_authorization' => env('NOTIFICATION_FCM_AUTHORIZATION', ''),
];
