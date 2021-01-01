<?php

return [
    'user' => 'App\User',
    'roles_enum' => env('AUTHORIZATION_ROLES', 'HoangDo\Authorization\Enum\BaseRole'),
    'manager_route' => 'api/v1/policies'
];
