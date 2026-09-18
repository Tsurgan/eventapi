<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Task history",
    title: "Task history",
    description: "Task history model",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "task_id", type: "integer", example: 1),
        new OA\Property(property: "user_id", type: "integer", example: 1),
        new OA\Property(
            property: "changes", 
            type: "object", 
            properties: [
                new OA\Property(property: "2", type: "string", example: "changed name"),
                new OA\Property(property: "3", type: "string", example: "changed description"),
            ],
        ),
    ]
)]
class TaskHistory extends Model
{
    protected $casts = [
        'changes' => 'array', 
    ];
}
