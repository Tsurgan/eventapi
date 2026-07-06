<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAll(User $authUser): Response
    {
        if ($authUser->permissions()->where('name', 'read other user')->exists()) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound();
        }      
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, int $targetUserId): Response
    {
        if (
            ($authUser->id === $targetUserId) 
            || ($authUser->permissions()->where('name', 'read other user')->exists())
        ) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        }       
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, int $targetUserId): Response
    {
        if (
            ($authUser->id === $targetUserId) 
            || ($authUser->permissions()->where('name', 'update other user')->exists())
        ) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        } 
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, int $targetUserId): Response
    {
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
                return Response::allow();
            } else {
                return Response::deny('Cannot delete last admin', 403); 
            }
        } else {
            return Response::denyAsNotFound(); 
        }
    }

    public function createPermissionUser(User $authUser): Response
    {
        if ($authUser->permissions()->where('name', 'create permission_user')->exists()) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        } 
    }
    
    public function deletePermissionUser(User $authUser): Response
    {
        if ($authUser->permissions()->where('name', 'delete permission_user')->exists()) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        } 
    }

    public function readPermissionUser(User $authUser, int $targetUserId): Response
    {
        if (
            ($authUser->id === $targetUserId) 
            || ($authUser->permissions()->where('name', 'read other permission_user')->exists())
        ) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        } 
    }
}
