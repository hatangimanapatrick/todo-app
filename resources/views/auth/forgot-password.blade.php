@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="mb-4 text-center">
            <h3 class="mb-3">Forgot Password</h3>
            <p class="text-muted">Enter your email to receive a password reset link</p>
        </div>

        @if (session('status'))
            <div class="mb-4 alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit" class="btn btn-auth">
                    <i class="fas fa-paper-plane"></i> Send Reset Link
                </button>
            </div>

            <!-- Links -->
            <div class="text-center">
                <a class="auth-link" href="{{ route('login') }}">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </a>
            </div>
        </form>
    </div>
@endsection
