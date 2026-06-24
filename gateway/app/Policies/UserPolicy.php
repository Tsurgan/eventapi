<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    public function viewAll(User $authUser): bool
    {
        $isPermitted = false;

        if ($authUser->permissions()->where('name', 'read other user')->exists()) 
        {
            $isPermitted = true;
        }

        return $isPermitted;       
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, int $targetUserId): bool
    {
        $isPermitted = false;

        if (
            ($authUser->id === $targetUserId) 
            || ($authUser->permissions()->where('name', 'read other user')->exists())
        ) {
            $isPermitted = true;
        }

        return $isPermitted;       
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, int $targetUserId): bool
    {
        $isPermitted = false;

        if (
            ($authUser->id === $targetUserId) 
            || ($authUser->permissions()->where('name', 'update other user')->exists())
        ) {
            $isPermitted = true;
        }

        return $isPermitted; 
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, int $targetUserId): bool
    {
        $isPermitted = false;

        // first check for basic permission
        if (
            ($authUser->id === $targetUserId) 
            || ($authUser->permissions()->where('name', 'delete other user')->exists())
        ) {
            // second check for last admin
            $targetUser = User::findOrFail($targetUserId);
            if (
                (Permission::where('name', 'create permission_user')->users->count() == 1)
                && ($targetUser->permissions()->where('name', 'create permission_user')->exists())
            ) {
                $isPermitted = true;
            }    
        }    
        return $isPermitted;
    }




    /**
     * Determine whether the user can create models.
     */
    public function createPermissionUser(User $authUser): bool
    {
        $isPermitted = false;

        if ($authUser->permissions()->where('name', 'create permission_user')->exists()) {
            $isPermitted = true;
        }

        return $isPermitted; 
    }
    
    public function deletePermissionUser(User $authUser): bool
    {
        $isPermitted = false;

        if ($authUser->permissions()->where('name', 'delete permission_user')->exists()) {
            $isPermitted = true;
        }

        return $isPermitted; 
    }

    public function readPermissionUser(User $authUser): bool
    {
        $isPermitted = false;

        if ($authUser->permissions()->where('name', 'read permission_user')->exists()) {
            $isPermitted = true;
        }

        return $isPermitted; 
    }

    public function readPermission(User $authUser): bool
    {
        $isPermitted = false;

        if ($authUser->permissions()->where('name', 'read permission')->exists()) {
            $isPermitted = true;
        }

        return $isPermitted; 
    }

}
