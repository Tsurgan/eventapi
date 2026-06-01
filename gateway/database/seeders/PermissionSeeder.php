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
                ['name' => 'read other users'],
                ['name' => 'update other users'],
                ['name' => 'delete other users'],
                ['name' => 'create permission_set'],
                ['name' => 'read permission_set'],
                ['name' => 'update permission_set'],
                ['name' => 'delete permission_set'],
                ['name' => 'create permission_user_connection'],
                ['name' => 'read permission_user_connection'],
                ['name' => 'delete permission_user_connection'],
                ['name' => 'create permission_set_connection'],
                ['name' => 'read permission_set_connection'],
                ['name' => 'delete permission_set_connection'],  
            ]       
        );
        
    }
}
