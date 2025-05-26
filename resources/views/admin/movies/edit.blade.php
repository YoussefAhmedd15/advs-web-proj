@extends('layouts.app')

@section('title', 'Edit Movie - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Movie</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.movies.update', $movie) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $movie->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <input type="text" class="form-control @error('genre') is-invalid @enderror" 
                                   id="genre" name="genre" value="{{ old('genre', $movie->genre) }}" required>
                            @error('genre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration (minutes)</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" name="duration" value="{{ old('duration', $movie->duration) }}" 
                                   min="1" required>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="synopsis" class="form-label">Synopsis</label>
                            <textarea class="form-control @error('synopsis') is-invalid @enderror" 
                                      id="synopsis" name="synopsis" rows="4" required>{{ old('synopsis', $movie->synopsis) }}</textarea>
                            @error('synopsis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="poster" class="form-label">Poster URL</label>
                            <input type="url" class="form-control @error('poster') is-invalid @enderror" 
                                   id="poster" name="poster" value="{{ old('poster', $movie->poster) }}" required>
                            @error('poster')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="trailer_url" class="form-label">Trailer URL</label>
                            <input type="url" class="form-control @error('trailer_url') is-invalid @enderror" 
                                   id="trailer_url" name="trailer_url" value="{{ old('trailer_url', $movie->trailer_url) }}" required>
                            <div class="form-text">Enter a YouTube video URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)</div>
                            @error('trailer_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating (0-10)</label>
                            <input type="number" class="form-control @error('rating') is-invalid @enderror" 
                                   id="rating" name="rating" value="{{ old('rating', $movie->rating) }}" 
                                   min="0" max="10" step="0.1" required>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" 
                                       id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $movie->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Update Movie
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endsection 