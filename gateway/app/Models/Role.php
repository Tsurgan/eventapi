<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Role",
    title: "Role",
    description: "Role model",
    required: ["id", "name"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "visitor")
    ]
)]

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

}
