<?php

return [
    'user' => 'App\User',
    'roles_enum' => env('AUTHORIZATION_ROLES', 'App\Enum\Type\Role'),
    'manager_route' => 'api/v1/policies'
];
