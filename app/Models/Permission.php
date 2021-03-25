<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Permission extends \Spatie\Permission\Models\Permission
{
    const BROWSE_DASHBOARD = 'browse dashboard';
    const ACCESS_USER_PERMISSIONS = 'access users.permissions';
    const ACCESS_USER_ADMIN = 'access users.admin';
    const ACCESS_USER_MEMBERS = 'access users.members';
    const ACCESS_USER_VENDORS = 'access users.vendors';

    public static function permissionList(array $exclusives = []): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $permissions = Arr::where($constants, function ($value, $key) use ($exclusives) {
                return !in_array($value, $exclusives) && Str::startsWith($key, 'ACCESS_');
            });

            return array_values($permissions);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }
}
