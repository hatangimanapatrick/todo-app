@extends('layouts.guest')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4 text-center">
                <h3 class="mb-3">Create Account</h3>
                <p class="text-muted">Join TodoMaster and start managing your tasks</p>
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required
                    autocomplete="new-password">
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit" class="btn btn-auth">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </div>

            <!-- Links -->
            <div class="text-center">
                <p class="mb-0">
                    Already have an account?
                    <a class="auth-link" href="{{ route('login') }}">
                        Sign in here
                    </a>
                </p>
            </div>
        </form>
    </div>
@endsection
