@extends('layouts.app')

@section('title', 'Forgot Password - Cinema Management System')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h4>Forgot Password</h4>
                        <p class="text-muted">Enter your email to reset your password</p>
                    </div>

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Send Reset Link</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">
                            Remember your password? 
                            <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 