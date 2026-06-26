<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\PermissionAssignRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: "/api/roles",
        summary: "Get list of roles",
        description: "Returns a paginated list of all roles",
        tags: ["Roles"],
        security: [["passport" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Role")
                )
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            )
        ]
    )]
    public function index()
    {
        Gate::authorize('viewAll');
        return Role::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: "/api/roles",
        tags: ["Roles"],
        security: [["passport" => []]],
        summary: "Create role",
        description: "Creates a role",
        requestBody: new OA\RequestBody(
            required: true,
            description: "Role",
            content: new OA\JsonContent(
                required: ["name"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "New role"),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Role created successfully",
    )]
    #[OA\Response(
        response:422,
        description: "Invalid request",
    )]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:roles'],
        ]);

        Gate::authorize('create');

        $role = Role::create($validated);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'Role has been updated successfully.',
            'data' => $role,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: "/api/roles/{id}",
        summary: "Get role by ID",
        description: "Returns a single role",
        tags: ["Roles"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Role ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            ),           
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(ref: "#/components/schemas/Role")
            ),
            new OA\Response(
                response: 404,
                description: "Role not found"
            ),
            new OA\Response(
                response: 422,
                description: "Incorrect data"
            ), 
        ]
    )]
    public function show(int $id)
    {
        $validator = Validator::make(['id' => $id], ['id' => ['required', 'integer']]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 422,
                'errors'=> $validator->errors()
            ], 422);
        }

        Gate::authorize('view', $id);

        return Role::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Put(
        path: "/api/roles/{id}",
        summary: "Update an existing role",
        description: "Updates role data",
        tags: ["Roles"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Role ID",
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
                description: "Role updated successfully",
                content: new OA\JsonContent(ref: "#/components/schemas/Role")
            ),
            new OA\Response(
                response: 404,
                description: "Role not found"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function update(Request $request, int $id)
    {
        $validator = Validator::make([
            'name' => $request->input('name'), 
            'id' => $id
        ],[
            'name' => ['required', 'unique:roles,name,'.$id],
            'id' => ['required', 'integer']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 422,
                'errors'=> $validator->errors()
            ], 422);
        }

        Gate::authorize('update');

        $role = Role::findOrFail($id);
        $role->update($request);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'Role has been updated successfully.',
            'data' => $role,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: "/api/roles/{id}",
        summary: "Delete a role",
        description: "Deletes a role by ID",
        tags: ["Roles"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Role ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: "Role deleted successfully"
            ),
            new OA\Response(
                response: 404,
                description: "Role not found"
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

        Gate::authorize('delete');

        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(null, 204);
    }

    #[OA\Post(
        path: "/api/roles/{id}/permissions",
        summary: "Add permissions to an existing role",
        description: "Adds permissions to role",
        tags: ["Roles"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Role ID",
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
                description: "Role permissions updated successfully",
            ),
            new OA\Response(
                response: 404,
                description: "Role not found"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function addPermissions(Request $request, int $id) 
    {
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

        Gate::authorize('createPermissionRole', $id);

        $permissionsData = $validator->validated()['permission_ids'];
        $role = Role::findOrFail($id);
        $role->permissions()->syncWithoutDetaching($permissionsData);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'Permissions have been added successfully.',
            'data' => ['id' => $id, 'permission_ids' => $permissionsData],
        ], 201);
    }    

    #[OA\Post(
        path: "/api/roles/{id}/permission-deletions",
        summary: "Delete permissions from an existing role",
        description: "Removes permissions from role",
        tags: ["Roles"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Role ID",
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
                description: "Role permissions removed successfully",
            ),
            new OA\Response(
                response: 404,
                description: "Role not found"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function removePermissions(Request $request, int $id) 
    {
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

        Gate::authorize('deletePermissionRole', $id);

        $permissionsData = $validator->validated()['permission_ids'];
        $role = Role::findOrFail($id);
        $role->permissions()->detach($permissionsData);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'Permissions have been removed successfully.',
            'data' => ['id' => $id, 'permission_ids' => $permissionsData],
        ], 201);
    }
    
    #[OA\Get(
        path: "/api/roles/{id}/permissions",
        summary: "Get role's permissions",
        description: "Returns array of role's permissions",
        tags: ["Roles"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Role ID",
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
        $validator = Validator::make(['id' => $id], ['id' => ['required', 'integer']]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 422,
                'errors'=> $validator->errors()
            ], 422);
        }

        Gate::authorize('readPermissionRole', $id);

        $permissions = Role::findOrFail($id)->permissions;
        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'data' => ['permissions' => $permissions],
        ], 200);
    } 
}
