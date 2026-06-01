<?php

namespace App\Http\Controllers;
use App\Models\User;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;

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
        return User::all();
    }

    #[OA\Get(
        path: "/api/users/{id}",
        summary: "Get user by ID",
        description: "Returns a single user",
        tags: ["Users"],
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
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(ref: "#/components/schemas/User")
            ),
            new OA\Response(
                response: 404,
                description: "User not found"
            )
        ]
    )]
    public function show(int $id) {
        return User::findOrFail($id);
    }

    #[OA\Put(
        path: "/api/users/{id}",
        summary: "Update an existing user",
        description: "Updates user data",
        tags: ["Users"],
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
            $validator = Validator::make($request->all(), $updateClass->rules());
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'statusCode' => 422,
                    'errors'=> $validator->errors()
                ], 422);
            }

            $userData = $validator->validated();
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
            )
        ]
    )]    
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        // If there's one admin user, and we're trying to disable that user
        /*if (Role::findByName('admin', 'web')->users->count() == 1 && true === $userToDestroy->hasRole('admin')) {
            return response()->json([
                'message' => 'The given data was invalid.',
                "errors"  => [
                    "roles" => ["As the only admin, you may not disable your account."]
                ],
            ], 409);
        }*/

        /*$userToDestroy->save();
        $userToDestroy->token() ? $userToDestroy->token->revoke() : null;*/

        //check for user being last admin
        //log out user
        //delete user
        return response()->json(null, 204);
    }
}
