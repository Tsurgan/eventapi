<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionAssignRequest;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    #[OA\Get(
        path: "/api/users",
        summary: "Get list of users",
        description: "Returns a paginated list of all users",
        tags: ["Users"],
        security: [["passport" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/User")
                )
            ),
            new OA\Response(
                response: 404,
                description: "Not Found"
            )
        ]
    )]
    public function index() 
    {
        Gate::authorize('viewAll', User::class);

        return User::all();
    }

    #[OA\Get(
        path: "/api/users/{id}",
        summary: "Get user by ID",
        description: "Returns a single user",
        tags: ["Users"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "User ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            ),           
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(ref: "#/components/schemas/User")
            ),
            new OA\Response(
                response: 404,
                description: "User not found"
            ),
            new OA\Response(
                response: 422,
                description: "Incorrect data"
            ),            
        ]
    )]
    public function show(int $id) 
    {
        Gate::authorize('view', [User::class, $id]);

        return User::findOrFail($id);
    }

    #[OA\Put(
        path: "/api/users/{id}",
        summary: "Update an existing user",
        description: "Updates user data",
        tags: ["Users"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "User ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref:"#/components/schemas/UpdateUserRequest")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "User updated successfully",
                content: new OA\JsonContent(ref: "#/components/schemas/User")
            ),
            new OA\Response(
                response: 404,
                description: "User not found"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function update(UpdateUserRequest $request, int $id) 
    {
        $user = User::findOrFail($id);

        $userData = $request->validated();
        if (isset($userData['password'])) {
            $userData['email_verified_at'] = now();
        }
        if (isset($userData['role_id'])) {
            //compare target user's perms with new role's perms
            //check for create|delete permission_user
            $role = Role::findOrFail($userData['role_id']);

            $userPermissions = $user->permissions();
            $rolePermissions = $role->permissions();

            //if there are permissions in role not present in user, ask for create
            if (!empty(array_diff($rolePermissions, $userPermissions))) {
                Gate::authorize('createPermissionUser', [User::class, $id]);
            }
            // if there are permissions in user not present in role, ask for delete
            if (!empty(array_diff($userPermissions, $rolePermissions))) {
                Gate::authorize('deletePermissionUser', [User::class, $id]);   
            }

            //replace user permissions with role permissions if both checks are passed or bypassed
            $user->assignRolePermissions($userData['role_id']);

        }
        
        $user->update($userData);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'User has been updated successfully.',
            'data' =>$request,
        ], 200);
    }

    #[OA\Delete(
        path: "/api/users/{id}",
        summary: "Delete a user",
        description: "Deletes a user by ID",
        tags: ["Users"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "User ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: "User deleted successfully"
            ),
            new OA\Response(
                response: 404,
                description: "User not found"
            ),
            new OA\Response(
                response: 409,
                description: "Cannot delete last admin."
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]    
    public function destroy(int $id)
    {
        Gate::authorize('delete', [User::class, $id]);        

        $user = User::findOrFail($id);

        $user->delete();
        $user->tokens()->delete();
        return response()->json(null, 204);
    }

    #[OA\Post(
        path: "/api/users/{id}/permissions",
        summary: "Add permissions to an existing user",
        description: "Adds permissions to user",
        tags: ["Users"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "User ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref:"#/components/schemas/PermissionAssignRequest")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "User permissions updated successfully",
            ),
            new OA\Response(
                response: 404,
                description: "User not found"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function addPermissions(PermissionAssignRequest $request, int $id) 
    {
        Gate::authorize('createPermissionUser', [User::class, $id]); 

        $permissionsData = $request->validated();
        $user = User::findOrFail($id);
        $user->permissions()->syncWithoutDetaching($permissionsData);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'Permissions have been added successfully.',
            'data' => ['id' => $id, 'permission_ids' => $permissionsData],
        ], 201);
    }    

    #[OA\Post(
        path: "/api/users/{id}/permission-deletions",
        summary: "Delete permissions from an existing user",
        description: "Removes permissions from user",
        tags: ["Users"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "User ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref:"#/components/schemas/PermissionAssignRequest")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "User permissions removed successfully",
            ),
            new OA\Response(
                response: 404,
                description: "User not found"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function removePermissions(PermissionAssignRequest $request, int $id) 
    {
        Gate::authorize('deletePermissionUser', [User::class, $id]); 
        $permissionsData = $request->validated();
        $user = User::findOrFail($id);
        $user->permissions()->detach($permissionsData);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'Permissions have been removed successfully.',
            'data' => ['id' => $id, 'permission_ids' => $permissionsData],
        ], 201);
    }
    
    #[OA\Get(
        path: "/api/users/{id}/permissions",
        summary: "Get user's permissions",
        description: "Returns array of user's permissions",
        tags: ["Users"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "User ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            ),          
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Permission")
                )
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),
            new OA\Response(
                response: 422,
                description: "Incorrect data"
            ),
        ]
    )]
    public function getPermissions(int $id) 
    {
        Gate::authorize('readPermissionUser', [User::class, $id]);

        $permissions = User::findOrFail($id)->permissions;
        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'data' => ['permissions' => $permissions],
        ], 200);
    } 
}
