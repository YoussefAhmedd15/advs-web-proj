@extends('layouts.app')

@section('title', 'Movies - Cinema Management System')

@section('content')
<div class="container py-5">
    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <form action="{{ route('movies.index') }}" method="GET" class="d-flex gap-3">
                <div class="flex-grow-1">
                    <input type="text" 
                           name="query" 
                           class="form-control" 
                           placeholder="Search movies..." 
                           value="{{ request('query') }}">
                </div>
                <div class="col-md-3">
                    <select name="genre" 
                            class="form-select"
                            onchange="this.form.submit()">
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                {{ $genre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- Movies Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($movies as $movie)
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
                        <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No movies found matching your search criteria.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($movies->hasPages())
        <div class="mt-4">
            {{ $movies->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
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