<?php

namespace App\Policies;

use App\Models\TaskStatus;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

class TaskStatusPolicy
{
    public function viewAll(int $userId): Response
    {
        $permissionId = DB::table('permissions')
            ->where('name', 'read task status')
            ->value('id');
        if (
            DB::table('permission_user')
                ->where('user_id', $userId)
                ->where('permission_id', $permissionId)
                ->exists()
        ) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound();
        }      
    }

    public function create(int $userId): Response
    {
        $permissionId = DB::table('permissions')
            ->where('name', 'create task status')
            ->value('id');
        if (
            DB::table('permission_user')
                ->where('user_id', $userId)
                ->where('permission_id', $permissionId)
                ->exists()
        ) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound();
        }      
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(int $userId): Response
    {
        $permissionId = DB::table('permissions')
            ->where('name', 'update task status')
            ->value('id');
        if (
            DB::table('permission_user')
                ->where('user_id', $userId)
                ->where('permission_id', $permissionId)
                ->exists()
        ) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        } 
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(int $userId): Response
    {
        $permissionId = DB::table('permissions')
            ->where('name', 'delete task status')
            ->value('id');
        if (
            DB::table('permission_user')
                ->where('user_id', $userId)
                ->where('permission_id', $permissionId)
                ->exists()
        ) {
            return Response::allow();
        } else {
            return Response::denyAsNotFound(); 
        } 
    }
}