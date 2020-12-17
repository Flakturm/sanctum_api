<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    const MANAGE_PERMISSIONS = 'manage permissions';
    const ACCESS_DASHBOARD = 'access dashboard';
}
