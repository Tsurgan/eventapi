<?php

namespace App\Http\Controllers;
use App\Models\Permission;
use OpenApi\Attributes as OA;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: "/api/permissions",
        summary: "Get list of permissions",
        description: "Returns a paginated list of all permissions",
        tags: ["Permissions"],
        security: [["passport" => []]],
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
            )
        ]
    )]
    public function index()
    {
        return Permission::all();
    }
}
