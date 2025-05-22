@extends('layouts.app')

@section('title', 'Select Movie - Cinema Management System')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Select a Movie</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($movies as $movie)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $movie->poster }}" class="card-img-top" alt="{{ $movie->title }}" style="height: 400px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->title }}</h5>
                        <div class="mb-2">
                            <span class="badge bg-primary me-2">{{ $movie->genre }}</span>
                            <span class="text-muted">{{ $movie->duration }} min</span>
                        </div>
                        <p class="card-text text-truncate">{{ $movie->synopsis }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('bookings.showtimes', ['movie' => $movie->id]) }}" 
                           class="btn btn-primary w-100">
                            <i class="fas fa-ticket-alt me-2"></i>
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .btn-primary {
        background-color: #e50914;
        border-color: #e50914;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #b2070f;
        border-color: #b2070f;
        transform: translateY(-2px);
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.5em 0.8em;
    }
</style>
@endsection 