<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

class PermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionUser = [];
        $permissions = Permission::all()->toArray();
        foreach ($permissions as $permission) {
            $permissionUser[] = ['user_id' => 1, 'permission_id' => $permission['id']];
        }
        for ($i=1;$i<4;$i++) {
            $permissionUser[] = ['user_id' => 2, 'permission_id' => $permissions[$i]['id']];
        }
        $permissionUser[] = ['user_id' => 2, 'permission_id' => $permissions[13]['id']];

        DB::table('permission_user')->insert($permissionUser);
    }
}
