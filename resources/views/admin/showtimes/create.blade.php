@extends('layouts.app')

@section('title', 'Add New Showtime - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Showtime</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.showtimes.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="movie_id" class="form-label">Movie</label>
                            <select name="movie_id" id="movie_id" class="form-select @error('movie_id') is-invalid @enderror" required>
                                <option value="">Select a movie</option>
                                @foreach($movies as $movie)
                                    <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                                        {{ $movie->title }} ({{ $movie->duration }} minutes)
                                    </option>
                                @endforeach
                            </select>
                            @error('movie_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="screen_id" class="form-label">Screen</label>
                            <select name="screen_id" id="screen_id" class="form-select @error('screen_id') is-invalid @enderror" required>
                                <option value="">Select a screen</option>
                                @foreach($screens as $screen)
                                    <option value="{{ $screen->id }}" {{ old('screen_id') == $screen->id ? 'selected' : '' }}>
                                        {{ $screen->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('screen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date') }}" 
                                   min="{{ date('Y-m-d') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="time" class="form-label">Time</label>
                            <input type="time" class="form-control @error('time') is-invalid @enderror" 
                                   id="time" name="time" value="{{ old('time') }}" required>
                            @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Create Showtime
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 