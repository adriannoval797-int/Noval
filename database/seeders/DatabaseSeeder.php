<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds. Optional -- only used if you run
     * "php artisan migrate --seed" and want some sample tasks to
     * start with instead of an empty list.
     */
    public function run(): void
    {
        Task::create([
            'task_name'   => 'Finish Laravel mini project',
            'description' => 'Build the Personal Task Manager and push it to GitHub.',
            'status'      => 'Pending',
            'due_date'    => now()->addDays(3)->toDateString(),
        ]);
    }
}
