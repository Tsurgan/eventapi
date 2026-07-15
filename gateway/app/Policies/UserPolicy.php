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
            if (User::isLastPermissionUser($targetUserId)) {             
                return Response::denyWithStatus(403, 'Cannot delete last admin'); 
            }
            else {
                return Response::allow();
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
    
    public function deletePermissionUser(User $authUser, int $targetUserId, array $permissionIds): Response
    {    
        if ($authUser->permissions()->where('name', 'delete permission_user')->exists()) {
            $createPermissionUserId = Permission::where('name', 'create permission_user')->first()['id'];
            if (
                in_array($createPermissionUserId, $permissionIds)
                && User::isLastPermissionUser($targetUserId, $createPermissionUserId)
            ) {
                return Response::denyWithStatus(403, 'Cannot delete last create permission'); 
            }
            else {
                return Response::allow();
            }
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
