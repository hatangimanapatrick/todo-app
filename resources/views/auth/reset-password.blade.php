@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="mb-4 text-center">
            <h3 class="mb-3">Reset Password</h3>
            <p class="text-muted">Create a new password for your account</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email', $request->email) }}" required autocomplete="email" readonly>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
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
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required
                    autocomplete="new-password">
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit" class="btn btn-auth">
                    <i class="fas fa-key"></i> Reset Password
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
