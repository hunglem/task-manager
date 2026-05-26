@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                required
                                autofocus
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </button>
                            <a href="{{ route('users.create') }}" class="btn btn-outline-secondary">
                                Register
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
