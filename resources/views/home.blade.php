@extends('layouts.app')

@section('title', 'Home - Cinema Management System')

@section('content')
<div class="container-fluid p-0">
    <!-- Featured Movie Section -->
    @if($featuredMovie)
    <div class="featured-movie position-relative">
        <div class="featured-overlay"></div>
        <div class="container position-relative py-5" style="z-index:2;">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-4 d-flex justify-content-center mb-4 mb-md-0">
                    <img src="{{ $featuredMovie->poster }}" 
                         alt="{{ $featuredMovie->title }}" 
                         class="featured-poster shadow-lg rounded" 
                         style="max-width: 350px; width: 100%; height: 520px; object-fit: cover; object-position: center; background: #222;">
                </div>
                <div class="col-md-8 text-center text-md-start text-white">
                    <h1 class="display-4 fw-bold mb-3">{{ $featuredMovie->title }}</h1>
                    <p class="lead mb-4">{{ $featuredMovie->synopsis }}</p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 mb-4">
                        <span class="badge bg-primary">{{ $featuredMovie->genre }}</span>
                        <span class="text-white">{{ $featuredMovie->duration }} min</span>
                        <span class="text-warning">
                            <i class="fas fa-star"></i>
                            {{ number_format($featuredMovie->rating, 1) }}
                        </span>
                    </div>
                    <a href="{{ route('movies.show', $featuredMovie) }}" class="btn btn-primary btn-lg">Book Now</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Upcoming Movies Section -->
    <div class="container py-5">
        <h2 class="mb-4">Now Showing</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($upcomingMovies as $movie)
                <div class="col">
                    <div class="card h-100 movie-card">
                        <img src="{{ $movie->poster }}" 
                             class="card-img-top" 
                             alt="{{ $movie->title }}"
                             style="height: 400px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                            <p class="card-text">
                                <span class="badge bg-primary">{{ $movie->genre }}</span>
                                <span class="text-muted">{{ $movie->duration }} min</span>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-warning">
                                    <i class="fas fa-star"></i>
                                    {{ number_format($movie->rating, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('movies.show', $movie) }}" class="btn btn-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.featured-movie {
    position: relative;
    overflow: hidden;
    min-height: 600px;
    background: #111;
}

.featured-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.8));
    z-index: 1;
}

.featured-poster {
    box-shadow: 0 8px 32px rgba(0,0,0,0.25);
    border-radius: 1rem;
    background: #222;
}

.featured-content {
    z-index: 2;
    width: 80%;
    max-width: 800px;
}

@media (max-width: 767.98px) {
    .featured-poster {
        height: 350px !important;
        max-width: 90vw;
    }
}

.movie-card {
    transition: transform 0.2s;
}

.movie-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.movie-card .card-img-top {
    border-top-left-radius: calc(0.25rem - 1px);
    border-top-right-radius: calc(0.25rem - 1px);
}
</style>
@endsection 