<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

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
            )
        ]
    )]
    public function show(int $id)
    {
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
        $validated = $request->validate([
            'name' => ['required', 'unique:roles'],
        ]);

        $role = Role::findOrFail($id);
        $role->update($validated);

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
            )
        ]
    )]   
    public function destroy(int $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(null, 204);
    }
}
