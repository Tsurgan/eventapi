<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert(
            [
                ['name' => 'create task status'],
                ['name' => 'read task status'],
                ['name' => 'update task status'],
                ['name' => 'delete task status'],
                ['name' => 'create task'],
                ['name' => 'read task'],
                ['name' => 'update task'],
                ['name' => 'delete task'],
                ['name' => 'delete task_history'],
                ['name' => 'create permission_user'],
                ['name' => 'read other permission_user'],
                ['name' => 'delete permission_user'],
                ['name' => 'create permission_role'],
                ['name' => 'read other permission_role'],
                ['name' => 'delete permission_role'],  
                ['name' => 'read permission'], 
            ]       
        );
    }
}
