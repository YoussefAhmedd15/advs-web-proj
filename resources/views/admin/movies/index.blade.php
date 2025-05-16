@extends('layouts.app')

@section('title', 'Manage Movies - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        <h2>Manage Movies</h2>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Movies</h5>
            <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add Movie
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Poster</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movies as $movie)
                            <tr>
                                <td>
                                    <img src="{{ $movie['poster'] }}" 
                                         style="width: 50px; height: 75px; object-fit: cover;"
                                         alt="{{ $movie['title'] }}">
                                </td>
                                <td>{{ $movie['title'] }}</td>
                                <td>{{ $movie['genre'] }}</td>
                                <td>{{ $movie['duration'] }} min</td>
                                <td>
                                    <span class="badge bg-{{ $movie['status_color'] }}">
                                        {{ $movie['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.movies.edit', $movie['id']) }}" 
                                           class="btn btn-sm btn-outline-primary me-2">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.movies.destroy', $movie['id']) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this movie?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No movies found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endsection 