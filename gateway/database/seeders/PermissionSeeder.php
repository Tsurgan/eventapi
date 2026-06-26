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
                ['name' => 'read other user'],
                ['name' => 'update other user'],
                ['name' => 'delete other user'],
                ['name' => 'create role'],
                ['name' => 'read other role'],
                ['name' => 'update role'],
                ['name' => 'delete role'],
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
