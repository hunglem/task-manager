@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">
                <i class="bi bi-list-task text-primary me-2"></i>All Tasks
            </h1>
            {{-- $tasks->total() returns the total count across ALL pages --}}
            <small class="text-muted">{{ $tasks->total() }} task(s) total</small>
        </div>
        {{-- Link to the "create task" form using its named route --}}
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Add New Task
        </a>
    </div>

    @if ($tasks->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3 text-muted">No tasks yet!</h4>
            <p class="text-muted">Click "Add New Task" to get started.</p>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary mt-2">
                Create Your First Task
            </a>
        </div>

    @else
        <div class="row g-3">
            @foreach ($tasks as $task)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 {{ $task->is_completed ? 'border-success' : '' }}">
                        <div class="card-body">
                            <span class="badge priority-{{ $task->priority }} mb-2">
                                {{ ucfirst($task->priority) }} Priority
                            </span>

                            <h5 class="card-title {{ $task->is_completed ? 'task-completed' : '' }}">
                                {{ $task->title }}
                            </h5>

                            @if ($task->description)
                                {{-- Str::limit() truncates text to 80 characters --}}
                                <p class="card-text text-muted small">
                                    {{ \Illuminate\Support\Str::limit($task->description, 80) }}
                                </p>
                            @endif

                            <div class="mt-2">
                                @if ($task->is_completed)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Completed
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-clock me-1"></i>Pending
                                    </span>
                                @endif
                            </div>

                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $task->created_at->diffForHumans() }}
                            </small>
                        </div>

                        <div class="card-footer bg-transparent d-flex gap-2">

                            <a href="{{ route('tasks.show', $task) }}"
                               class="btn btn-sm btn-outline-primary flex-fill">
                                <i class="bi bi-eye"></i> View
                            </a>

                            <a href="{{ route('tasks.edit', $task) }}"
                               class="btn btn-sm btn-outline-secondary flex-fill">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('tasks.destroy', $task) }}"
                                  method="POST"
                                  class="flex-fill"
                                  onsubmit="return confirm('Delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $tasks->links() }}
        </div>

    @endif {{-- end of @if ($tasks->isEmpty()) --}}

@endsection
