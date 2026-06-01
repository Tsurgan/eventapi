<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Permission",
    title: "Permission",
    description: "Permission model",
    required: ["id", "name"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "read other users")
    ]
)]

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
