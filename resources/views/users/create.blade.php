@extends('layouts.app')

@section('title', 'Create User')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('users.index') }}">All Users</a>
                    </li>
                    <li class="breadcrumb-item active">Create New User</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>Create New User
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Name <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input
                                type="email"
                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <input
                                type="password"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                id="password"
                                name="password"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                Confirm Password <span class="text-danger">*</span>
                            </label>
                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                            >
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-person-plus me-1"></i>Create User
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
