<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskHistory;

class TaskHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaskHistory::create([
            'task_id' => 1,
            'user_id' => 1,
            'changes' => [2 => 'changed name', 3 => 'changed description'],
        ]);
        TaskHistory::create([
            'task_id' => 1,
            'user_id' => 2,
            'changes' => [2 => 'changed name1'],
        ]);
    }
}
