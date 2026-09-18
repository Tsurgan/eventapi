<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create([
            'name' => 'test task 1',
            'description' => 'doing task 1',
            'location_id' => 1,
            'task_status_id' => 1,
            'start_time' => '2024-01-01T00:00:00Z',
            'end_time' => '2024-01-01T00:00:00Z',
        ]);

        Task::create([
            'name' => 'test task 2',
            'description' => 'doing task 2',
            'location_id' => 3,
            'task_status_id' => 2,
            'start_time' => '2024-01-01T00:00:00Z',
            'end_time' => '2024-01-01T00:00:00Z',
        ]);
    }
}
