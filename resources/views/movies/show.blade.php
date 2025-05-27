@extends('layouts.app')

@section('title', $movie->title . ' - Cinema Management System')

@section('content')
<!-- Hero Section with Movie Poster -->
<div class="position-relative">
    <!-- Backdrop Image -->
    <div class="position-absolute w-100 h-100" style="z-index: 0;">
        <img src="{{ $movie->poster }}" 
             alt="{{ $movie->title }} backdrop" 
             class="w-100 h-100" style="object-fit: cover; filter: blur(5px); opacity: 0.3;">
    </div>

    <!-- Movie Details Hero -->
    <div class="position-relative" style="z-index: 1;">
        <div class="container py-5">
            <div class="row">
                <!-- Movie Poster -->
                <div class="col-md-4">
                    <div class="rounded overflow-hidden shadow">
                        <img src="{{ $movie->poster }}" 
                             alt="{{ $movie->title }}" 
                             class="w-100">
                    </div>
                </div>

                <!-- Movie Info -->
                <div class="col-md-8 text-white">
                    <h1 class="display-4 fw-bold mb-4">{{ $movie->title }}</h1>
                    
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <span class="badge bg-primary">{{ $movie->genre }}</span>
                        <span class="text-white">
                            <i class="fas fa-clock me-1"></i>
                            {{ $movie->duration }} minutes
                        </span>
                        <span class="text-warning">
                            <i class="fas fa-star me-1"></i>
                            {{ number_format($movie->rating, 1) }}/10
                        </span>
                    </div>

                    <div class="mb-4">
                        <h2 class="h3 mb-3">Synopsis</h2>
                        <p class="lead">{{ $movie->synopsis }}</p>
                    </div>

                    <div class="d-flex gap-3">
                        <a href="{{ route('movies.index') }}" 
                           class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Movies
                        </a>
                        @php
                            $firstShowtime = $movie->showtimes->first();
                        @endphp
                        @if($firstShowtime)
                            <a href="{{ route('bookings.create', $firstShowtime) }}" class="btn btn-primary">
                                <i class="fas fa-ticket-alt me-2"></i>
                                Book Tickets
                            </a>
                        @else
                            <button class="btn btn-primary" disabled>
                                <i class="fas fa-ticket-alt me-2"></i>
                                Book Tickets
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Trailer Section -->
@if($movie->trailer_url)
<div class="bg-dark py-5">
    <div class="container">
        <h2 class="text-white mb-4">Watch Trailer</h2>
        <div class="ratio ratio-16x9">
            <iframe 
                src="{{ $movie->trailer_url }}" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
        </div>
    </div>
</div>
@endif

<!-- Showtimes Section -->
<div class="bg-light py-5">
    <div class="container">
        <h2 class="mb-4">Available Showtimes</h2>
        
        @if($movie->showtimes && $movie->showtimes->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($movie->showtimes as $showtime)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h3 class="h5 mb-1">{{ $showtime->date ?? 'N/A' }}</h3>
                                        <p class="text-muted mb-0">{{ $showtime->time ?? 'N/A' }}</p>
                                    </div>
                                    <div class="text-end">
                                        <p class="text-muted mb-0">Screen</p>
                                        <p class="h5 mb-0">{{ $showtime->screen->name }}</p>
                                    </div>
                                </div>
                                @auth
                                    <a href="{{ route('bookings.create', $showtime) }}" class="btn btn-primary w-100">
                                        Book Tickets
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                        Login to Book
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                <p class="mb-0">No showtimes available for this movie at the moment.</p>
                <p class="mb-0">Please check back later for updated schedules.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
.btn-primary {
    transition: all 0.3s ease;
}
.btn-primary:hover {
    transform: translateY(-2px);
}
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection 