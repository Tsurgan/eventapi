<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redis;

use Grpc\ChannelCredentials;
use GRPC\User\UserServiceClient;
use GRPC\User\CreateUserRequest;
use GRPC\TaskStatus\ListTaskStatusesRequest;
use App\Services\GRPCClient;
use Illuminate\Support\Facades\Log;

use App\Helpers\GRPCMessageHelper;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: "/api/task-statuses",
        summary: "Get list of task statuses",
        description: "Returns a paginated list of all task statuses",
        tags: ["Task Status"],
        parameters: [
            new OA\Parameter(
                name: "page",
                description: "Page number",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 1)
            ),
            new OA\Parameter(
                name: "per_page",
                description: "Items per page",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 1, maximum: 100)
            )
        ],
        security: [["passport" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/TaskStatus")
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
        // Проверка на пустое или null значение
        //if (empty($name)) {
        //    return response()->json(['error' => 'Name cannot be empty'], 400);
        //}

        $request = new ListTaskStatusesRequest();
        
        $pageSize = request()->query('per_page', 15);
        $pageToken = request()->query('page', 1);

        $request->setPageSize($pageSize);
        $request->setPageToken($pageToken);

        $sender = new GRPCMessageHelper;
        $reply = $sender->sendMessage($request,'ListTaskStatuses');

        return $reply;

        /*$id = Redis::connection()->xadd('orders-stream',  [
            'user_id' => Auth::user()->id,
            'resource' => 'taskStatus',
            'request' => 'index',
        ],'*');

        if ($id) {
            return response()->json([
                'success' => true,
                'statusCode' => 202,
                'message' => 'Task Status has been queued for listing successfully.',
                'data' => $id,
            ], 202);
        } else {
            return response()->json([
                'success' => false,
                'statusCode' => 503,
                'message' => 'Service Unavailable',
            ], 503);
        }*/
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: "/api/task-statuses",
        tags: ["Task Status"],
        security: [["passport" => []]],
        summary: "Create task status",
        description: "Creates a task status",
        requestBody: new OA\RequestBody(
            required: true,
            description: "Task Status",
            content: new OA\JsonContent(
                required: ["name"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "New task status"),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Task status created successfully",
    )]
    #[OA\Response(
        response:422,
        description: "Invalid request",
    )]
    public function store(Request $request)
    {
        /*$validated = $request->validate([
            'name' => ['required', 'unique:task-statuses'],
        ]);
        Gate::authorize('create', TaskStatus::class);

        $taskStatus = TaskStatus::create($validated);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'Task Status has been created successfully.',
            'data' => $taskStatus,
        ], 201);*/
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: "/api/task-statuses/{id}",
        summary: "Get task status by ID",
        description: "Returns a single task status",
        tags: ["Task Status"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Task status ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            ),           
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful operation",
                content: new OA\JsonContent(ref: "#/components/schemas/TaskStatus")
            ),
            new OA\Response(
                response: 404,
                description: "Task status not found"
            ),
            new OA\Response(
                response: 422,
                description: "Incorrect data"
            ), 
        ]
    )]
    public function show(int $id)
    {
        /*Gate::authorize('view', [TaskStatus::class, $id]);

        return TaskStatus::findOrFail($id);*/
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Put(
        path: "/api/task-statuses/{id}",
        summary: "Update an existing task status",
        description: "Updates task status data",
        tags: ["Task Status"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Task Status ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref:"#/components/schemas/UpdateTaskStatusRequest")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Task Status updated successfully",
                content: new OA\JsonContent(ref: "#/components/schemas/TaskStatus")
            ),
            new OA\Response(
                response: 404,
                description: "Task Status not found"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function update(Request $request, int $id)
    {
        /*$taskStatus = TaskStatus::findOrFail($id);

        $data = $request->validated();

        $taskStatus->update($data);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Task Status has been updated successfully.',
            'data' => $taskStatus,
        ], 200);*/
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: "/api/task-statuses/{id}",
        summary: "Delete a task status",
        description: "Deletes a task status by ID",
        tags: ["Task Status"],
        security: [["passport" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Task Status ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: "Task Status deleted successfully"
            ),
            new OA\Response(
                response: 404,
                description: "Task Status not found"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function destroy(int $id)
    {
       /* Gate::authorize('delete', [TaskStatus::class, $id]);

        $taskStatus = TaskStatus::findOrFail($id);
        if ($taskStatus->users()->exists()) {
            return response()->json([
                'success' => true,
                'statusCode' => 409,
                'message' => 'Tasks with this status still exist.',
            ], 409);
        } else {
            $taskStatus->delete();
            return response()->json(null, 204);
        }*/
    }
}
