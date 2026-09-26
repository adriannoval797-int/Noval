@extends('layouts.app')

@section('content')

    <h3 class="mb-3">Add New Task</h3>

    <div class="card">
        <div class="card-body">
            {{-- action points to TaskController@store (POST /tasks) --}}
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf {{-- Laravel security token, required on every form --}}

                <div class="mb-3">
                    <label class="form-label">Task Name</label>
                    <input type="text" name="task_name" class="form-control"
                           value="{{ old('task_name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Pending" selected>Pending</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Task</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection

@extends('layouts.app')

@section('content')

    <h3 class="mb-3">Edit Task</h3>

    <div class="card">
        <div class="card-body">
            {{-- action points to TaskController@update (PUT /tasks/{task}) --}}
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT') {{-- Blade form-spoofing: HTML forms only support GET/POST, so
                                     Laravel "spoofs" PUT via this hidden field --}}

                <div class="mb-3">
                    <label class="form-label">Task Name</label>
                    <input type="text" name="task_name" class="form-control"
                           value="{{ old('task_name', $task->task_name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control"
                               value="{{ old('due_date', $task->due_date) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Task</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection

@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">My Tasks</h3>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Add Task</a>
    </div>

    <div class="card">
        <div class="card-body">

            @if ($tasks->isEmpty())
                {{-- No tasks yet --}}
                <p class="text-muted text-center my-4">No tasks yet. Click "Add Task" to create your first one!</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task Name</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Loop through every task passed from TaskController@index --}}
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $task->task_name }}</td>
                                    <td>{{ Str::limit($task->description, 40) ?: '—' }}</td>
                                    <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : '—' }}</td>
                                    <td>
                                        <span class="badge badge-status {{ $task->status === 'Pending' ? 'status-pending' : 'status-completed' }}">
                                            {{ $task->status }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        {{-- Toggle status button --}}
                                        <form action="{{ route('tasks.updateStatus', $task) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                Mark as {{ $task->status === 'Pending' ? 'Completed' : 'Pending' }}
                                            </button>
                                        </form>

                                        {{-- Edit button --}}
                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                                        {{-- Delete button (with confirmation) --}}
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Delete this task? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>

@endsection

