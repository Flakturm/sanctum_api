<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Role extends \Spatie\Permission\Models\Role
{
    const ROLE_ROOT = 'root';
    const ROLE_ADMIN = 'Admin';
    const ROLE_MEMBER = 'Member';
    const ROLE_VENDOR = 'Vendor';

    public $guard_name = 'web';

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
