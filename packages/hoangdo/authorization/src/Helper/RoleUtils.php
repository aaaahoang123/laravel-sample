<?php


namespace HoangDo\Authorization\Helper;


class RoleUtils
{
    const HAS_ALL_ROLES_ALIAS = 'has_all_roles';
    const HAS_ANY_ROLES_ALIAS = 'has_any_roles';

    public static function hasAny(...$roles): string {
        return self::HAS_ANY_ROLES_ALIAS . ':' . implode(',', $roles);
    }

    public static function hasAll(...$roles): string {
        return self::HAS_ALL_ROLES_ALIAS . ':' . implode(',', $roles);
    }
}
