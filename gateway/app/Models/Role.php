<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\RoleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Role",
    title: "Role",
    description: "Role model",
    required: ["id", "name"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "visitor"),
        new OA\Property(property: "is_default", type: "boolean", example: "false")
    ]
)]

#[ObservedBy([RoleObserver::class])]
class Role extends Model
{
    protected $observables = [
        'default_role_change',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'is_default',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public static function getDefaultRole() {
        return Role::where('is_default', 1)->first();
    }

    public function prepareForChangingDefaultRole()
    {
        $this->fireModelEvent('default_role_change');
    }
}
