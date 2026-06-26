<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $authUser): bool
    {
        $isPermitted = false;

        if ($authUser->permissions()->where('name', 'read other role')->exists()) 
        {
            $isPermitted = true;
        }

        return $isPermitted;   
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, int $roleId): bool
    {
        $isPermitted = false;

        if (
            ($authUser->role->id == $roleId) 
            || ($authUser->permissions()->where('name', 'read other role')->exists())
        ) {
            $isPermitted = true;
        }

        return $isPermitted;   
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authUser): bool
    {
        $isPermitted = false;

        if ($authUser->permissions()->where('name', 'create role')->exists()) {
            $isPermitted = true;
        }

        return $isPermitted;   
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser): bool
    {
       $isPermitted = false;

        if ($authUser->permissions()->where('name', 'update role')->exists()) {
            $isPermitted = true;
        }

        return $isPermitted; 
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser): bool
    {
       $isPermitted = false;

        if ($authUser->permissions()->where('name', 'delete role')->exists()) {
            $isPermitted = true;
        }

        return $isPermitted; 
    }

    public function createPermissionRole(User $authUser): bool
    {
        $isPermitted = false;

        if ($authUser->permissions()->where('name', 'create permission_role')->exists()) {
            $isPermitted = true;
        }

        return $isPermitted; 
    }
    
    public function deletePermissionRole(User $authUser): bool
    {
        $isPermitted = false;

        if ($authUser->permissions()->where('name', 'delete permission_role')->exists()) {
            $isPermitted = true;
        }

        return $isPermitted; 
    }

    public function readPermissionRole(User $authUser): bool
    {
        $isPermitted = false;

        if ($authUser->permissions()->where('name', 'read permission_role')->exists()) {
            $isPermitted = true;
        }

        return $isPermitted; 
    }
}
