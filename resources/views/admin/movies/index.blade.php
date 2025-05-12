@extends('layouts.app')

@section('title', 'Manage Movies - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Manage Movies</h5>
            <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Movie
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
                                           class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.movies.destroy', $movie['id']) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this movie?')">
                                                Delete
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