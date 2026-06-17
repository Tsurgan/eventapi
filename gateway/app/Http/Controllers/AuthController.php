<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: "/api/register",
        tags: ["Auth"],
        summary: "Register",
        description: "Registers an user",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref:"#/components/schemas/RegisterRequest")
        )
    )]
    #[OA\Response(
        response: 201,
        description: "User created successfully",
    )]
    #[OA\Response(
        response:422,
        description: "Invalid request",
    )]
    public function register(Request $request): JsonResponse
    {
        $registerClass = new RegisterRequest();
        $validator = Validator::make($request->all(), $registerClass->rules());
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 422,
                'errors'=> $validator->errors()
            ], 422);
        }

        $userData = $validator->validated();
        $userData['email_verified_at'] = now();
        $user = User::create($userData);

        $response = Http::asForm()->post(config('oauth2_host').'oauth/token', [
            'grant_type' => 'password',
            'client_id' => config('passport_password_client_id'),
            'client_secret' => config('passport_password_secret'),
            'username' => $userData['email'],
            'password' => $userData['password'],
            'scope' => '*',
        ]);
        $user['token'] = $response->json();

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'User has been registered successfully.',
            'data' => $user,
        ], 201);
    }

    #[OA\Post(
        path: "/api/login",
        tags: ["Auth"],
        summary: "Login",
        description: "Logs in an user",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref:"#/components/schemas/LoginRequest")
        )
    )]
    #[OA\Response(
        response: 201,
        description: "User logged in successfully",
    )]
    #[OA\Response(
        response:401,
        description: "Unauthorized.",
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $response = Http::post(config('oauth2_host').'/oauth/token', [
                'grant_type' => 'password',
                'client_id' => config('passport_password_client_id'),
                'client_secret' => config('passport_password_secret'),
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ]);

            $user['token'] = $response->json();

            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'User has been logged successfully.',
                'data' => $user,
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'statusCode' => 401,
                'message' => 'Unauthorized.',
                'errors' => 'Unauthorized',
            ], 401);
        }

    }

    /**
     * refresh token
     *
     * @return void
     */
    public function refreshToken(RefreshTokenRequest $request): JsonResponse
    {
        $response = Http::asForm()->post(config('oauth2_host') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => config('passport_password_client_id'),
            'client_secret' => config('passport_password_secret'),
            'scope' => '',
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Refreshed token.',
            'data' => $response->json(),
        ], 200);
    }

    #[OA\Post(
        path: "/api/logout",
        tags: ["Auth"],
        security: [["passport" => []]],
        parameters: [
            /*new OA\Parameter(
                name: "Bearer",
                in: "header",
                required: false,
                schema: new OA\Schema(type: "string", default: "token")
            ),*/
                new OA\Parameter(
                name: "accept",
                in: "header",
                required: false,
                schema: new OA\Schema(type: "string", default: "application/json")
            )],
        summary: "Logout",
        description: "Logs out an user",
    )]
    #[OA\Response(
        response: 204,
        description: "User logged out successfully",
    )]
    #[OA\Response(
        response:404,
        description: "Invalid request",
    )]
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'statusCode' => 204,
            'message' => 'Logged out successfully.',
        ], 204);
    }
}
