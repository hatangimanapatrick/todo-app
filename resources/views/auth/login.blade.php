@extends('layouts.guest')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4 text-center">
                <h3 class="mb-3">Welcome Back</h3>
                <p class="text-muted">Sign in to manage your todos</p>
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
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
                    name="password" required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit" class="btn btn-auth">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </div>

            <!-- Links -->
            <div class="text-center">
                @if (Route::has('password.request'))
                    <a class="mb-2 auth-link d-block" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
                <p class="mb-0">
                    Don't have an account?
                    <a class="auth-link" href="{{ route('register') }}">
                        Sign up here
                    </a>
                </p>
            </div>
        </form>
    </div>
@endsection
