@extends('layouts.app')

@section('title', $movie['title'] . ' - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Movie Poster -->
        <div class="col-md-4">
            <img src="{{ $movie['poster'] }}" class="img-fluid rounded" alt="{{ $movie['title'] }}">
        </div>

        <!-- Movie Details -->
        <div class="col-md-8">
            <h1 class="mb-3">{{ $movie['title'] }}</h1>
            <div class="mb-4">
                <span class="badge bg-primary me-2">{{ $movie['genre'] }}</span>
                <span class="text-muted me-3">{{ $movie['duration'] }} min</span>
                <span class="text-warning">
                    <i class="fas fa-star"></i>
                    {{ number_format($movie['rating'], 1) }}
                </span>
            </div>

            <h5 class="mb-3">Synopsis</h5>
            <p class="mb-4">{{ $movie['synopsis'] }}</p>

            <h5 class="mb-3">Cast</h5>
            <p class="mb-4">{{ implode(', ', $movie['cast']) }}</p>

            <!-- Showtimes -->
            <h5 class="mb-3">Showtimes</h5>
            <div class="row g-3 mb-4">
                @foreach($movie['showtimes'] as $showtime)
                    <div class="col-auto">
                        <a href="{{ route('booking.create', ['movie' => $movie['id'], 'showtime' => $showtime['id']]) }}" 
                           class="btn btn-outline-primary">
                            {{ $showtime['time'] }}
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Trailer -->
            <h5 class="mb-3">Trailer</h5>
            <div class="ratio ratio-16x9 mb-4">
                <iframe src="{{ $movie['trailer_url'] }}" 
                        title="{{ $movie['title'] }} Trailer" 
                        allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endsection 