@extends('layouts.app')

@section('title', 'All Users')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">
                <i class="bi bi-people text-primary me-2"></i>Users
            </h1>
            <small class="text-muted">{{ $users->total() }} user(s) total</small>
            <form action="{{ route('users.index') }}" method="GET" class="d-flex gap-2 mt-2">
                <input
                    type="search"
                    name="search"
                    id="user-search"
                    class="form-control form-control-sm"
                    placeholder="Search users..."
                    value="{{ $search }}"
                >
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>
                @if ($search)
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
                        Clear
                    </a>
                @endif
            </form>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i>Add New User
        </a>
    </div>

    @if ($users->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-person-x text-muted" style="font-size: 4rem;"></i>
            @if ($search)
                <h4 class="mt-3 text-muted">No users found for "{{ $search }}".</h4>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary mt-2">
                    Clear Search
                </a>
            @else
                <h4 class="mt-3 text-muted">No users yet!</h4>
                <p class="text-muted">Click "Add New User" to get started.</p>
                <a href="{{ route('users.create') }}" class="btn btn-primary mt-2">
                    Create Your First User
                </a>
            @endif
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form
                                            action="{{ route('users.destroy', $user) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this user?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    @endif

@endsection
