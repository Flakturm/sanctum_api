<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    const ROLE_ROOT = 'root';
    const ROLE_ADMIN = 'admin';
    const ROLE_MEMBER = 'member';
}
