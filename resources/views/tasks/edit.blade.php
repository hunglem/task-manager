@extends('layouts.app')
@section('title', 'Edit Task')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('tasks.index') }}">My Tasks</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>
                    </li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>Edit Task
                    </h4>
                </div>
                <div class="card-body p-4">

                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf

                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">
                                Task Title <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                id="title"
                                name="title"
                                value="{{ old('title') ?? $task->title }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">
                                Description <span class="text-muted">(optional)</span>
                            </label>
                            <textarea
                                class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                id="description"
                                name="description"
                                rows="3"
                            >{{ old('description') ?? $task->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="priority" class="form-label fw-semibold">Priority</label>
                            <select
                                class="form-select {{ $errors->has('priority') ? 'is-invalid' : '' }}"
                                id="priority"
                                name="priority"
                            >
                                @php $currentPriority = old('priority') ?? $task->priority; @endphp
                                <option value="low"    {{ $currentPriority == 'low'    ? 'selected' : '' }}>🟢 Low</option>
                                <option value="medium" {{ $currentPriority == 'medium' ? 'selected' : '' }}>🟠 Medium</option>
                                <option value="high"   {{ $currentPriority == 'high'   ? 'selected' : '' }}>🔴 High</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if (auth()->user()->isSuperUser())
                            <div class="mb-3">
                                <label for="user_id" class="form-label fw-semibold">Assign To</label>
                                <select
                                    class="form-select {{ $errors->has('user_id') ? 'is-invalid' : '' }}"
                                    id="user_id"
                                    name="user_id"
                                    required
                                >
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected((int) old('user_id', $task->user_id) === $user->id)>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-4">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    id="is_completed"
                                    name="is_completed"
                                    value="1"
                                    {{-- Check the box if: (after validation fail use old value)
                                         OR use the actual DB value ($task->is_completed) --}}
                                    {{ (old('is_completed', $task->is_completed)) ? 'checked' : '' }}
                                >
                                <label class="form-check-label fw-semibold" for="is_completed">
                                    Mark as Completed
                                </label>
                                <div class="form-text">
                                    Check this box if the task has been finished.
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning flex-fill">
                                <i class="bi bi-save me-1"></i>Save Changes
                            </button>
                            <a href="{{ route('tasks.show', $task) }}"
                               class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>

                <div class="card-footer text-muted small">
                    <i class="bi bi-clock me-1"></i>
                    Created {{ $task->created_at->format('M d, Y \a\t h:i A') }}
                    &nbsp;|&nbsp;
                    Last updated {{ $task->updated_at->diffForHumans() }}
                </div>
            </div>

        </div>
    </div>

@endsection
