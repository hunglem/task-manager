<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Task Manager') — Laravel Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .priority-high   { background-color: #dc3545; color: white; }
        .priority-medium { background-color: #fd7e14; color: white; }
        .priority-low    { background-color: #198754; color: white; }
        .task-completed { opacity: 0.6; text-decoration: line-through; }
        .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">
                <i class="bi bi-check2-square me-2"></i>Task Manager
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-white" href="{{ route('tasks.index') }}">
                    <i class="bi bi-list-task me-1"></i>All Tasks
                </a>
                <a class="nav-link text-white" href="{{ route('tasks.create') }}">
                    <i class="bi bi-plus-circle me-1"></i>New Task
                </a>
            </div>
        </div>
    </nav>

    <main class="container mb-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <strong><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following:</strong>
                <ul class="mt-2 mb-0">
                    {{-- Loop through each error message and display it --}}
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')

    </main>

    <footer class="text-center text-muted py-4 border-top mt-auto">
        <small>
            Laravel 10.x Demo App
        </small>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
