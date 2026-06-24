<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionAssignRequest;
use App\Models\User;
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
                response: 401,
                description: "Unauthenticated"
            )
        ]
    )]
    public function index() {
        Gate::authorize('viewAll');

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
    public function show(int $id) {
        $validator = Validator::make(['id' => $id], ['id' => ['required', 'integer']]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 422,
                'errors'=> $validator->errors()
            ], 422);
        }

        Gate::authorize('view', $id);

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
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Jane Doe"),
                    new OA\Property(property: "email", type: "string", format: "email", example: "jane@example.com")
                ]
            )
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
    public function update(Request $request, int $id) {
            $updateClass = new UpdateUserRequest();
            $validator = Validator::make(['request' => $request->all(), 'id' => $id], $updateClass->rules());
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'statusCode' => 422,
                    'errors'=> $validator->errors()
                ], 422);
            }

            Gate::authorize('update', $id);

            $userData = $validator->validated()['request'];
            $userData['email_verified_at'] = now();
            $user = User::findOrFail($id);
            $user->update($userData);

            return response()->json([
                'success' => true,
                'statusCode' => 201,
                'message' => 'User has been updated successfully.',
                'data' => $user,
            ], 201);
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
        $validator = Validator::make(['id' => $id], ['id' => ['required', 'integer']]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 422,
                'errors'=> $validator->errors()
            ], 422);
        }

        Gate::authorize('delete', $id);        

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
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "permission_ids", 
                        type: "array",
                        items: new OA\Items(type: "integer"),
                        example: "[2]",
                    ),
                ]
            )
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
    public function addPermissions(Request $request, int $id) {
        $permAssignClass = new PermissionAssignRequest();  
        $validator = Validator::make([
            'id' => $id,
            'permission_ids' => $request->input('permission_ids')
        ], $permAssignClass->rules());
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 422,
                'errors'=> $validator->errors()
            ], 422);
        }

        Gate::authorize('createPermissionUser', $id);

        $permissionsData = $validator->validated()['permission_ids'];
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
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "permission_ids", 
                        type: "array",
                        items: new OA\Items(type: "integer"),
                        example: "[2]",
                    ),
                ]
            )
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
    public function removePermissions(Request $request, int $id) {
        $permDetachClass = new PermissionAssignRequest();  
        $validator = Validator::make([
            'id' => $id,
            'permission_ids' => $request->input('permission_ids')
        ], $permDetachClass->rules());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 422,
                'errors'=> $validator->errors()
            ], 422);
        }

        Gate::authorize('deletePermissionUser', $id);

        $permissionsData = $validator->validated()['permission_ids'];
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
    public function getPermissions(int $id) {
        $validator = Validator::make(['id' => $id], ['id' => ['required', 'integer']]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 422,
                'errors'=> $validator->errors()
            ], 422);
        }

        Gate::authorize('readPermissionUser', $id);

        $permissions = User::findOrFail($id)->permissions;
        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'data' => ['permissions' => $permissions],
        ], 200);
    } 
}
