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
    public function viewAny(User $authUser): Response
    {
        if ($authUser->permissions()->where('name', 'read other role')->exists()) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        }   
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, int $roleId): Response
    {
        if (
            ($authUser->role->id == $roleId) 
            || ($authUser->permissions()->where('name', 'read other role')->exists())
        ) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        } 
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authUser): Response
    {
        if ($authUser->permissions()->where('name', 'create role')->exists()) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser): Response
    {
        if ($authUser->permissions()->where('name', 'update role')->exists()) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        } 
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser): Response
    {
        if ($authUser->permissions()->where('name', 'delete role')->exists()) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        }
    }

    public function createPermissionRole(User $authUser): Response
    {
        if ($authUser->permissions()->where('name', 'create permission_role')->exists()) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        }
    }
    
    public function deletePermissionRole(User $authUser): Response
    {
        if ($authUser->permissions()->where('name', 'delete permission_role')->exists()) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        }
    }

    public function readPermissionRole(User $authUser, int $roleId): Response
    {
        if (
            ($authUser->role->id == $roleId) 
            || ($authUser->permissions()->where('name', 'read other permission_role')->exists())
        ) {
           return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        }
    }
}
