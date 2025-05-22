@extends('layouts.app')

@section('title', 'Select Showtime - ' . $movie->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <img src="{{ $movie->poster }}" class="img-fluid rounded shadow" alt="{{ $movie->title }}">
        </div>
        <div class="col-md-8">
            <h1 class="mb-3">{{ $movie->title }}</h1>
            <div class="mb-4">
                <span class="badge bg-primary me-2">{{ $movie->genre }}</span>
                <span class="text-muted me-3">{{ $movie->duration }} min</span>
            </div>

            <h4 class="mb-4">Select Showtime</h4>
            <div class="row g-3">
                @foreach($movie->showtimes as $showtime)
                    <div class="col-md-4">
                        <a href="{{ route('bookings.seats', ['showtime' => $showtime->id]) }}" 
                           class="btn btn-outline-primary btn-lg w-100">
                            <div class="d-flex flex-column align-items-center">
                                <span class="h5 mb-0">{{ $showtime->time }}</span>
                                <small class="text-muted">{{ $showtime->screen->name }}</small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
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

    .badge {
        font-size: 0.9rem;
        padding: 0.5em 1em;
    }
</style>
@endsection 