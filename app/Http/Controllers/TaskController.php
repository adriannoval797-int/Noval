<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Controller: TaskController
|--------------------------------------------------------------------------
| The Controller sits between Routes, the Model, and the Blade views.
| A route points to a method here; the method talks to the Model
| (database) and then hands data to a Blade view to display.
|
| Method names below (index, create, store, edit, update, destroy)
| match what Route::resource() expects automatically -- that's what
| connects each URL to the right method without us writing it out.
|--------------------------------------------------------------------------
*/

class TaskController extends Controller
{
    /**
     * VIEW TASKS
     * GET /tasks
     * Show a list of all tasks, newest first.
     */
    public function index()
    {
        $tasks = Task::latest()->get(); // latest() orders by created_at, newest first

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the "Add Task" form.
     * GET /tasks/create
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * ADD TASK
     * POST /tasks
     * Validate the submitted form, then save a new task to the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_name'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:Pending,Completed',
            'due_date'    => 'nullable|date',
        ]);

        Task::create($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task added successfully!');
    }

    /**
     * Show the "Edit Task" form, pre-filled with existing data.
     * GET /tasks/{task}/edit
     *
     * Laravel automatically fetches the matching Task by its id because
     * of "route model binding" -- the {task} placeholder in the route.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * EDIT TASK
     * PUT/PATCH /tasks/{task}
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_name'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:Pending,Completed',
            'due_date'    => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    /**
     * UPDATE STATUS (quick toggle)
     * PATCH /tasks/{task}/status
     * Flips a task between Pending and Completed with one click, so the
     * user doesn't have to open the full edit form just for that.
     */
    public function updateStatus(Task $task)
    {
        $task->status = $task->status === 'Pending' ? 'Completed' : 'Pending';
        $task->save();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task status updated!');
    }

    /**
     * DELETE TASK
     * DELETE /tasks/{task}
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }
}

