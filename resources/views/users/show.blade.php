@extends('layouts.app')

@section('title', $user->name)

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('users.index') }}">All Users</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>User Details
                    </h4>
                    <span class="badge bg-light text-dark">ID #{{ $user->id }}</span>
                </div>

                <div class="card-body p-4">
                    <h2 class="mb-3">{{ $user->name }}</h2>

                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small fw-bold mb-2">Email</h6>
                        <p class="mb-0">
                            <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning flex-fill">
                            <i class="bi bi-pencil me-1"></i>Edit User
                        </a>

                        <form
                            action="{{ route('users.destroy', $user) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this user? This cannot be undone.')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>

                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>

                
            </div>
        </div>
    </div>

@endsection
