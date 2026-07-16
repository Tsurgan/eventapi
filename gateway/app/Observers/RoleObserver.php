<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
    /**
     * Handle the Role "updated" event.
     */
    public function default_role_change(): void
    {
        $defaultRole = Role::getDefaultRole();
        $defaultRole->is_default = false;
        $defaultRole->save();
    }
}
