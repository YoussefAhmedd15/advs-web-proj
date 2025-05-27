@extends('layouts.app')

@section('title', 'Movies - Cinema Management System')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="display-4 mb-3">Now Showing</h1>
            <p class="lead text-muted">Discover our latest movies and book your tickets online.</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('movies.index') }}" method="GET" class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="query" 
                                       class="form-control border-start-0" 
                                       placeholder="Search movies by title..." 
                                       value="{{ request('query') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Movies Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        @forelse($movies as $movie)
            <div class="col">
                <div class="card h-100 movie-card">
                    <div class="position-relative">
                        <img src="{{ $movie->poster }}" 
                             class="card-img-top" 
                             alt="{{ $movie->title }}"
                             style="height: 400px; object-fit: cover;">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star me-1"></i>
                                {{ number_format($movie->rating, 1) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-2">{{ $movie->title }}</h5>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-primary me-2">{{ $movie->genre }}</span>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                {{ $movie->duration }} min
                            </small>
                        </div>
                        <p class="card-text text-muted small mb-3">
                            {{ Str::limit($movie->description ?? '', 100) }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 pb-3">
                        <a href="{{ route('movies.show', $movie->id) }}" 
                           class="btn btn-primary w-100">
                            <i class="fas fa-ticket-alt me-2"></i>Book Now
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info shadow-sm">
                    <i class="fas fa-info-circle me-2"></i>
                    No movies found matching your search criteria.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($movies->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $movies->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
.movie-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.movie-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.movie-card .card-img-top {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}

.movie-card .card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-color);
}

.movie-card .badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.movie-card .btn-primary {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.input-group-text {
    border-right: none;
}

.form-control:focus {
    box-shadow: none;
    border-color: var(--accent-color);
}

.form-select:focus {
    box-shadow: none;
    border-color: var(--accent-color);
}

.pagination {
    margin-bottom: 0;
}

.page-link {
    color: var(--accent-color);
    border: none;
    padding: 0.75rem 1rem;
    margin: 0 0.25rem;
    border-radius: 0.5rem;
}

.page-link:hover {
    color: var(--highlight-color);
    background-color: var(--gray-100);
}

.page-item.active .page-link {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
}
</style>
@endsection 