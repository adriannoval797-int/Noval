<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Routes are the "front door" of the app. They map a URL + HTTP verb
| to a Controller method. Route::resource() is a shortcut that creates
| a full set of CRUD routes in one line:
|
|   GET    /tasks              -> index    (View Tasks)
|   GET    /tasks/create        -> create   (show Add Task form)
|   POST   /tasks               -> store    (Add Task)
|   GET    /tasks/{task}/edit   -> edit     (show Edit Task form)
|   PUT    /tasks/{task}        -> update   (Edit Task)
|   DELETE /tasks/{task}        -> destroy  (Delete Task)
|
| Route::resource() also creates a "show" route (GET /tasks/{task}) by
| default. This app doesn't have a single-task detail page or a show()
| method in the controller, so ->except(['show']) leaves that route out
| -- otherwise visiting it would throw an error.
|--------------------------------------------------------------------------
*/

// Redirect the homepage straight to the task list.
Route::redirect('/', '/tasks');

// All CRUD routes for tasks, except "show" (not used in this app).
Route::resource('tasks', TaskController::class)->except(['show']);

// Extra custom route (not part of the resource set) for the
// one-click "toggle status" button on the task list.
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
    ->name('tasks.updateStatus');
