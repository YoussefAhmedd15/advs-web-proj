@extends('layouts.app')

@section('title', 'Login - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Sign in to your account</h2>
                    <p class="text-center text-muted mb-4">
                        Or
                        <a href="{{ route('register') }}" class="text-decoration-none">
                            create a new account
                        </a>
                    </p>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input id="email" name="email" type="email" required 
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter your email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" name="password" type="password" required
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input id="remember_me" name="remember" type="checkbox"
                                    class="form-check-input">
                                <label for="remember_me" class="form-check-label">
                                    Remember me
                                </label>
                            </div>

                           
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Sign in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.card {
    border: none;
    border-radius: 10px;
}
.btn-primary {
    transition: all 0.3s ease;
}
.btn-primary:hover {
    transform: translateY(-2px);
}
</style>
@endsection 