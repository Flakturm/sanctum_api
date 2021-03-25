<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Role extends \Spatie\Permission\Models\Role
{
    const ROLE_ROOT = 'Root';
    const ROLE_ADMIN = 'Admin';
    const ROLE_MEMBER = 'Member';
    const ROLE_VENDOR = 'Vendor';

    public $guard_name = 'web';

    public static function roleList(): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $roles = Arr::where($constants, function ($value, $key) {
                return Str::startsWith($key, 'ROLE_');
            });

            return array_values($roles);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }

    protected static function booted()
    {
        static::addGlobalScope('default', function (Builder $builder) {
            $builder->whereNotIn('name', [
                self::ROLE_ROOT,

                // website roles
                self::ROLE_MEMBER,
                self::ROLE_VENDOR
            ]);
        });
    }
}
