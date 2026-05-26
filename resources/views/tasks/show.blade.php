@extends('layouts.app')
@section('title', $task->title)
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('tasks.index') }}">My Tasks</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $task->title }}</li>
                </ol>
            </nav>
            <nav class="mb-4">
                
            </nav>
                

            <div class="card">
                <div class="card-header {{ $task->is_completed ? 'bg-success' : 'bg-primary' }} text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-{{ $task->is_completed ? 'check-circle' : 'circle' }} me-2"></i>
                        Task Details
                    </h4>
                    <span class="badge bg-light text-dark">
                        {{ $task->is_completed ? 'Completed' : 'Pending' }}
                    </span>
                </div>

                <div class="card-body p-4">

                    <h2 class="mb-3 {{ $task->is_completed ? 'text-muted text-decoration-line-through' : '' }}">

                    </h2>

                    <div class="mb-3">
                        <span class="badge priority-{{ $task->priority }} fs-6">
                            <i class="bi bi-flag me-1"></i>
                            {{ ucfirst($task->priority) }} Priority
                        </span>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small fw-bold mb-2">
                            Description
                        </h6>
                        @if ($task->description)
                            <p class="text-dark">{!! nl2br(e($task->description)) !!}</p>
                        @else
                            <p class="text-muted fst-italic">No description provided.</p>
                        @endif
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="bg-light rounded p-3 text-center">
                                <small class="text-muted d-block">Created</small>
                                <strong>{{ $task->created_at->format('M d, Y') }}</strong>
                                <small class="d-block text-muted">{{ $task->created_at->format('h:i A') }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded p-3 text-center">
                                <small class="text-muted d-block">Last Updated</small>
                                <strong>{{ $task->updated_at->diffForHumans() }}</strong>
                                <small class="d-block text-muted">{{ $task->updated_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('tasks.edit', $task) }}"
                           class="btn btn-warning flex-fill">
                            <i class="bi bi-pencil me-1"></i>Edit Task
                        </a>

                        <form action="{{ route('tasks.destroy', $task) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this task? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>

                        <a href="{{ route('tasks.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Back
                        </a>

                    </div>
                </div>

                

            </div>

        </div>
    </div>
@endsection
