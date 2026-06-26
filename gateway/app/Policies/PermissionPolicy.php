<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    public function viewAll(User $authUser): bool
    {
        $isPermitted = false;

        if ($authUser->permissions()->where('name', 'read permission')->exists()) {
            $isPermitted = true;
        }

        return $isPermitted; 
    }
}
