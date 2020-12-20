<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    const BROWSE_DASHBOARD = 'browse dashboard';
    const ACCESS_USER_PERMISSIONS = 'access users.permissions';
    const ACCESS_USER_ADMIN = 'access users.admin';
    const ACCESS_USER_MEMBERS = 'access users.members';
    const ACCESS_USER_VENDORS = 'access users.vendors';
}
