<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    public function viewAll(User $authUser): Response
    {
        if ($authUser->permissions()->where('name', 'read permission')->exists()) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        }
    }
}
