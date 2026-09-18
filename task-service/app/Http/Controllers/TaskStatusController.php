<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskStatusController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAll', TaskStatus::class);
        return TaskStatus::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:task-statuses'],
        ]);
        Gate::authorize('create', TaskStatus::class);

        $taskStatus = TaskStatus::create($validated);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'Task Status has been created successfully.',
            'data' => $taskStatus,
        ], 201);
    }

    public function show(int $id)
    {
        Gate::authorize('view', [TaskStatus::class, $id]);

        return TaskStatus::findOrFail($id);
    }

    public function update(Request $request, int $id)
    {
        $taskStatus = TaskStatus::findOrFail($id);

        $data = $request->validated();

        $taskStatus->update($data);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Task Status has been updated successfully.',
            'data' => $taskStatus,
        ], 200);
    }

    public function destroy(int $id)
    {
        Gate::authorize('delete', [TaskStatus::class, $id]);

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
        }
    }
}
