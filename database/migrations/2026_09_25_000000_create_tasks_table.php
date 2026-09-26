<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Migration: create_tasks_table
|--------------------------------------------------------------------------
| A migration is a version-controlled instruction for building a database
| table with PHP code, instead of clicking around in phpMyAdmin. Laravel
| runs this file for you when you type:
|
|     php artisan migrate
|--------------------------------------------------------------------------
*/

return new class extends Migration
{
    /**
     * Run the migration (builds the table).
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();                              // auto-increment primary key: id
            $table->string('task_name');                // name of the task (required)
            $table->text('description')->nullable();    // details (optional)
            $table->enum('status', ['Pending', 'Completed'])->default('Pending');
            $table->date('due_date')->nullable();        // deadline (optional)
            $table->timestamps();                        // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migration (drops the table).
     * Runs when you type: php artisan migrate:rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
