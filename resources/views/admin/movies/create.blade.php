@extends('layouts.app')

@section('title', 'Add Movie - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i> Back to Movies
                </a>
                <h2>Add New Movie</h2>
            </div>

            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Movie Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.movies.store') }}" method="POST" id="createMovieForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           name="title" 
                                           value="{{ old('title') }}" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Genre</label>
                                    <input type="text" 
                                           class="form-control @error('genre') is-invalid @enderror" 
                                           name="genre" 
                                           value="{{ old('genre') }}" 
                                           required>
                                    @error('genre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Duration (minutes)</label>
                                    <input type="number" 
                                           class="form-control @error('duration') is-invalid @enderror" 
                                           name="duration" 
                                           value="{{ old('duration') }}" 
                                           required>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Poster URL</label>
                                    <input type="url" 
                                           class="form-control @error('poster') is-invalid @enderror" 
                                           name="poster" 
                                           value="{{ old('poster') }}" 
                                           required>
                                    @error('poster')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Trailer URL</label>
                                    <input type="url" 
                                           class="form-control @error('trailer_url') is-invalid @enderror" 
                                           name="trailer_url" 
                                           value="{{ old('trailer_url') }}" 
                                           required>
                                    @error('trailer_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Rating (0-10)</label>
                                    <input type="number" 
                                           class="form-control @error('rating') is-invalid @enderror" 
                                           name="rating" 
                                           value="{{ old('rating') }}" 
                                           step="0.1" 
                                           min="0" 
                                           max="10">
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Synopsis</label>
                            <textarea class="form-control @error('synopsis') is-invalid @enderror" 
                                      name="synopsis" 
                                      rows="3" 
                                      required>{{ old('synopsis') }}</textarea>
                            @error('synopsis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" 
                                   class="form-check-input @error('is_active') is-invalid @enderror" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (available for scheduling)
                            </label>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Add Movie</button>
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

@section('scripts')
<script>
document.getElementById('createMovieForm').addEventListener('submit', function(e) {
    // Disable the submit button to prevent double submission
    document.getElementById('submitBtn').disabled = true;
});</script>
@endsection 