<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert(
            [
                ['name' => 'admin', 'is_default' => false],
                ['name' => 'org', 'is_default' => false],
                ['name' => 'volunteer', 'is_default' => false],
                ['name' => 'visitor','is_default' => true],
            ]       
        );
    }
}
