@extends('layouts.app')
@section('title', 'Create Task')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            {{-- Breadcrumb navigation --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('tasks.index') }}">My Tasks</a>
                    </li>
                    <li class="breadcrumb-item active">Create New Task</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>Create New Task
                    </h4>
                </div>
                <div class="card-body p-4">

                    {{-- ==========================================
                         THE FORM

                         action="{{ route('tasks.store') }}"
                           → Sets the form POST destination to /tasks
                             which maps to TaskController@store()

                         method="POST"
                           → Tells the browser to send an HTTP POST request

                         @csrf — MANDATORY for all POST forms in Laravel!
                           Inserts a hidden input: <input name="_token" value="...">
                           Laravel verifies this token to protect against
                           Cross-Site Request Forgery (CSRF) attacks.
                           If you forget @csrf, you get a 419 error.
                    ========================================== --}}
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf

                        {{-- TITLE FIELD --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">
                                Task Title <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                id="title"
                                name="title"
                                placeholder="bug"
                                value="{{ old('title') }}"
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
                                placeholder="Add more details about this task..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="priority" class="form-label fw-semibold">
                                Priority <span class="text-danger">*</span>
                            </label>
                            <select
                                class="form-select {{ $errors->has('priority') ? 'is-invalid' : '' }}"
                                id="priority"
                                name="priority"
                                required
                            >
                                <option value="">— Select priority —</option>
                                <option value="low"    {{ old('priority') == 'low'    ? 'selected' : '' }}>🟢 Low</option>
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>🟠 Medium</option>
                                <option value="high"   {{ old('priority') == 'high'   ? 'selected' : '' }}>🔴 High</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-plus-circle me-1"></i>Create Task
                            </button>
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <div class="alert alert-info mt-4">
                <h6 class="alert-heading"><i class="bi bi-lightbulb me-2"></i>What happens when you submit?</h6>
                <ol class="mb-0 small">
                    <li>Browser sends a <strong>POST</strong> request to <code>/tasks</code></li>
                    <li>Laravel checks the <strong>CSRF token</strong> for security</li>
                    <li><strong>TaskController@store()</strong> is called</li>
                    <li><strong>Validation</strong> rules are checked</li>
                    <li>On success: <strong>Task::create()</strong> inserts a new DB row</li>
                    <li>User is <strong>redirected</strong> to the task list with a success message</li>
                </ol>
            </div>

        </div>
    </div>

@endsection
