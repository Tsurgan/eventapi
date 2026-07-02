<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionRole = [];
        $permissions = Permission::all()->toArray();

        foreach ($permissions as $permission) {
            $permissionRole[] = ['role_id' => 1, 'permission_id' => $permission['id']];
        }
        for ($i=1;$i<4;$i++) {
            $permissionRole[] = ['role_id' => 2, 'permission_id' => $permissions[$i]['id']];
        }
        $permissionRole[] = ['role_id' => 2, 'permission_id' => $permissions[13]['id']];

        DB::table('permission_role')->insert($permissionRole);
    }
}
