<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "User",
    title: "User",
    description: "User model",
    required: ["id", "name", "password"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "John Doe"),
        new OA\Property(property: "email", type: "string", format: "email", example: "john@example.com"),
        new OA\Property(property: "phone", type: "string", pattern:"^\+[1-9]\d{1,14}$", example: "89999999999"),
        new OA\Property(property: "password", type: "string", format: "password", example: "12345"),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2024-01-01T00:00:00Z"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2024-01-01T00:00:00Z")
    ]
)]

class User extends Authenticatable implements OAuthenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }    

    public function assignRolePermissions(int $roleId)
    {
        DB::transaction(function () use ($roleId) {
            // Delete existing user permissions
            DB::table('permission_user')->where('user_id', $this->id)->delete();
            $rolePermissions = DB::table('permission_role')->where('role_id', $roleId)->get();

            $newUserPermissions = [];
            // get new role permissions and replace role_id with new user_id
            foreach ($rolePermissions as $permission) {
                unset($permission->role_id);
                unset($permission->id);
                $permission->user_id = $this->id;
                $permission->created_at = now();

                $newUserPermissions[] = (array)$permission;
            }
            DB::table('permission_user')->insert($newUserPermissions);
        });
    }

    /*
    * Check whether given user is only remaining one with a given permission. 
    * Default permission is "create permission_user".
    */
    public static function isLastPermissionUser(int $targetUserId, int $permissionId = -1) {
        if ($permissionId == -1) {
            $permissionId = DB::table('permissions')
                ->where('name', 'create permission_user')
                ->first('id')->id;
        }
        $targetUserHasPermission = DB::table('permission_user')
            ->where('permission_id', $permissionId)
            ->where('user_id', $targetUserId)
            ->exists();

        if ($targetUserHasPermission) {
            $twoOrLessUsersHavePermission = DB::table('permission_user')
                ->where('permission_id', $permissionId)
                ->limit(2)
                ->count();

            if ($twoOrLessUsersHavePermission < 2) {
                return true;
            }
        }
        
        return false;
    }
}
