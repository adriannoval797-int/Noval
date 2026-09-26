# Personal Task Manager (Laravel)

Project Code: WST21-PM-2026-SF
Student Name: [Your Full Name]
Course & Year: [Your Course & Year]
Database Used: MySQL

Features:
- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status

## What This App Does

A simple personal task manager built with Laravel, following the
**Routes → Controller → Model → Database → Blade** flow.

- `routes/web.php` — defines the URLs and which controller method handles each one.
- `app/Http/Controllers/TaskController.php` — the logic (fetch, save, update, delete).
- `app/Models/Task.php` — the Eloquent model representing a row in the `tasks` table.
- `database/migrations/..._create_tasks_table.php` — defines the `tasks` table structure.
- `resources/views/tasks/*.blade.php` — the HTML pages the user sees.

No frontend build tools are needed — styling comes from Bootstrap loaded via CDN in
`resources/views/layouts/app.blade.php`, so you don't need Node/npm to run this project.

## How to Set Up This Project Locally

1. **Clone the repository and install PHP dependencies:**
   ```bash
   git clone <your-repo-url> task-manager
   cd task-manager
   composer install
   ```

2. **Create your `.env` file** from the example, then generate an app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure your database** in `.env` (defaults shown are for MySQL):
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task_manager
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Create the `task_manager` database in MySQL first (e.g. via phpMyAdmin or the
   `mysql` CLI) — Laravel creates the *tables*, but not the database itself.

4. **Run the migration** to create the `tasks` table:
   ```bash
   php artisan migrate
   ```
   Optional — add one sample task to start with instead of an empty list:
   ```bash
   php artisan db:seed
   ```

5. **Start the development server:**
   ```bash
   php artisan serve
   ```
   Visit `http://127.0.0.1:8000` in your browser — it will redirect to `/tasks`.

## Database Structure

| Field       | Type                                 | Purpose                |
|-------------|---------------------------------------|--------------------------|
| id          | bigint, auto-increment, primary key    | Task ID                  |
| task_name   | string                                 | Name of the task         |
| description | text, nullable                          | Task details             |
| status      | enum('Pending','Completed')            | Pending / Completed      |
| due_date    | date, nullable                          | Task deadline            |
| created_at / updated_at | timestamps                | Automatically managed    |

## Routes Overview

| Method | URI                   | Controller Method | Purpose                        |
|--------|------------------------|---------------------|-----------------------------------|
| GET    | /tasks                 | index                | View all tasks                    |
| GET    | /tasks/create           | create               | Show "Add Task" form              |
| POST   | /tasks                  | store                | Save a new task                    |
| GET    | /tasks/{task}/edit      | edit                 | Show "Edit Task" form              |
| PUT    | /tasks/{task}           | update               | Save edits to a task                |
| DELETE | /tasks/{task}           | destroy              | Delete a task                        |
| PATCH  | /tasks/{task}/status    | updateStatus         | Quick toggle Pending/Completed       |

## Notes / Things I Learned

- `Route::resource()` generates most CRUD routes automatically instead of writing
  each one by hand — `->except(['show'])` is used here to skip the single-task
  "show" route, since this app doesn't have a detail page for one task.
- Laravel's `@csrf` and `@method('PUT')` / `@method('DELETE')` directives are
  needed because plain HTML forms only support GET and POST.
- `$fillable` on the Model is a safeguard against mass-assignment vulnerabilities
  — only the listed fields can be saved via `Task::create()`.
- Form Request validation (`$request->validate([...])`) stops bad data before it
  ever reaches the database.

## Screenshots

_(Add screenshots of your running app here before submitting — task list,
add form, edit form, etc.)_

