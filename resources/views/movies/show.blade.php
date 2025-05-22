@extends('layouts.app')

@section('title', $movie->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Movie Poster -->
        <div class="col-md-4">
            <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" class="img-fluid rounded shadow">
            @auth
                <div class="mt-4">
                    <a href="#showtimes" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-ticket-alt me-2"></i>
                        Book Now
                    </a>
                </div>
            @else
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Login to Book
                    </a>
                </div>
            @endauth
        </div>

        <!-- Movie Details -->
        <div class="col-md-8">
            <h1 class="mb-3">{{ $movie->title }}</h1>
            <div class="mb-4">
                <span class="badge bg-primary me-2">{{ $movie->genre }}</span>
                <span class="badge bg-secondary me-2">{{ $movie->duration }} minutes</span>
                <span class="badge bg-warning">
                    <i class="fas fa-star"></i> {{ number_format($movie->rating, 1) }}
                </span>
            </div>

            <h5 class="mb-3">Synopsis</h5>
            <p class="mb-4">{{ $movie->synopsis }}</p>

            <!-- Showtimes Section -->
            <div id="showtimes">
                <h5 class="mb-3">Available Showtimes</h5>
                @if($movie->showtimes->count() > 0)
                    <div class="row">
                        @foreach($movie->showtimes as $showtime)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $showtime->date->format('M d, Y') }}</h6>
                                        <p class="card-text">
                                            <i class="fas fa-clock me-2"></i>{{ $showtime->time }}
                                        </p>
                                        <p class="card-text">
                                            <i class="fas fa-film me-2"></i>Screen: {{ $showtime->screen->name }}
                                        </p>
                                        <p class="card-text">
                                            <i class="fas fa-tag me-2"></i>Price: ${{ number_format($showtime->price, 2) }}
                                        </p>
                                        @auth
                                            <a href="{{ route('bookings.seats', ['showtime' => $showtime->id]) }}" 
                                               class="btn btn-primary w-100">
                                                <i class="fas fa-chair me-2"></i>Select Seats
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-sign-in-alt me-2"></i>Login to Book
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No showtimes available at the moment.
                    </div>
                @endif
            </div>

            <!-- Trailer Section -->
            <h5 class="mt-4 mb-3">Trailer</h5>
            <div class="ratio ratio-16x9">
                <iframe src="{{ $movie->trailer_url }}" title="{{ $movie->title }} Trailer" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
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
        .btn-outline-primary {
            color: #e50914;
            border-color: #e50914;
            transition: all 0.3s ease;
        }
        .btn-outline-primary:hover {
            background-color: #e50914;
            border-color: #e50914;
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