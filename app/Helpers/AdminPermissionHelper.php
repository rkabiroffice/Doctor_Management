<?php

namespace App\Helpers;

class AdminPermissionHelper
{
    public static function can(string $permission): bool
    {
        $permissions = session('admin_permissions', []);

        if (! is_array($permissions)) {
            return false;
        }

        return in_array($permission, $permissions, true) || in_array('manage_roles', $permissions, true);
    }
}
