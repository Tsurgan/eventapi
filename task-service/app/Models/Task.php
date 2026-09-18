<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;
use Illuminate\Database\Eloquent\Casts\Attribute;

#[OA\Schema(
    schema: "Task",
    title: "Task",
    description: "Task model",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "default task"),
        new OA\Property(property: "description", type: "string", example: "default description"),
        new OA\Property(property: "location_id", type: "integer", example: 1),
        new OA\Property(property: "status_id", type: "integer", example: 1),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2024-01-01T00:00:00Z"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2024-01-01T00:00:00Z"),
        new OA\Property(property: "start_time", type: "string", format: "date-time", example: "2024-01-01T00:00:00Z"),
        new OA\Property(property: "end_time", type: "string", format: "date-time", example: "2024-01-01T00:00:00Z"),
    ]
)]
class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'location_id',
        'status_id',
        'start_time',
        'end_time',
    ];

    public function task_status()
    {
        return $this->belongsTo(TaskStatus::class);
    }
}
