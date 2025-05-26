@extends('layouts.app')

@section('title', 'Showtime Management - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Showtime Management</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Showtime
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.showtimes.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="movie_id" class="form-label">Movie</label>
                    <select name="movie_id" id="movie_id" class="form-select">
                        <option value="">All Movies</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ request('movie_id') == $movie->id ? 'selected' : '' }}>
                                {{ $movie->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="screen_id" class="form-label">Screen</label>
                    <select name="screen_id" id="screen_id" class="form-select">
                        <option value="">All Screens</option>
                        @foreach($screens as $screen)
                            <option value="{{ $screen->id }}" {{ request('screen_id') == $screen->id ? 'selected' : '' }}>
                                {{ $screen->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" 
                           value="{{ request('date_from') }}">
                </div>

                <div class="col-md-2">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" 
                           value="{{ request('date_to') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Showtimes List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Movie</th>
                            <th>Screen</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Duration</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($showtimes as $showtime)
                            <tr>
                                <td>{{ $showtime->movie->title }}</td>
                                <td>{{ $showtime->screen->name }}</td>
                                <td>{{ $showtime->date ?? 'N/A' }}</td>
                                <td>{{ $showtime->time ?? 'N/A' }}</td>
                                <td>{{ $showtime->movie->duration }} minutes</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.showtimes.edit', $showtime) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.showtimes.destroy', $showtime) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this showtime?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No showtimes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $showtimes->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        /* Custom Pagination Styles */
        .pagination {
            margin: 0;
            padding: 0;
        }
        
        .pagination .page-item {
            margin: 0 2px;
        }
        
        .pagination .page-link {
            color: #0d6efd;
            border: 1px solid #dee2e6;
            padding: 8px 16px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .pagination .page-link:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
            color: #0a58ca;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .pagination .page-link {
                padding: 6px 12px;
                font-size: 0.9rem;
            }
        }
    </style>
@endsection 