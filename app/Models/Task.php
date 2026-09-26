<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Model: Task
|--------------------------------------------------------------------------
| A Model represents ONE ROW of the "tasks" table as a PHP object.
| Eloquent (Laravel's ORM / database toolkit) lets us write:
|
|     Task::all();              instead of  SELECT * FROM tasks
|     Task::create([...]);      instead of  INSERT INTO tasks ...
|     $task->update([...]);     instead of  UPDATE tasks SET ...
|     $task->delete();          instead of  DELETE FROM tasks ...
|
| Laravel automatically maps the model "Task" to the table "tasks"
| (plural, snake_case) -- that's why the class name matters.
|--------------------------------------------------------------------------
*/

class Task extends Model
{
    /**
     * The columns that are allowed to be "mass assigned" -- that is,
     * saved in one go through Task::create($data) or $task->update($data).
     *
     * This is a security measure: it stops someone from sneaking extra
     * fields into a form submission and overwriting columns you never
     * intended to expose.
     */
    protected $fillable = [
        'task_name',
        'description',
        'status',
        'due_date',
    ];
}
