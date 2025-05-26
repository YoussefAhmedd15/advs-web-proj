@extends('layouts.app')

@section('title', 'Screen Management - Cinema Management System')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Screen Management</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.screens.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Screen
            </a>
        </div>
    </div>

    <!-- Screens List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Capacity</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Showtimes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($screens as $screen)
                            <tr>
                                <td>{{ $screen->name }}</td>
                                <td>{{ $screen->capacity }} seats</td>
                                <td>{{ Str::limit($screen->description, 50) }}</td>
                                <td>
                                    <span class="badge bg-{{ $screen->is_active ? 'success' : 'danger' }}">
                                        {{ $screen->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $screen->showtimes_count }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.screens.edit', $screen) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.screens.destroy', $screen) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this screen?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No screens found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $screens->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endsection 