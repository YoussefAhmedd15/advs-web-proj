<x-app-layout>
    <!-- Hero Section with Movie Poster -->
    <div class="relative">
        <!-- Backdrop Image -->
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full">
                <img src="{{ $movie->poster }}" 
                     alt="{{ $movie->title }} backdrop" 
                     class="w-full h-full object-cover filter blur-sm opacity-30">
            </div>
        </div>

        <!-- Movie Details Hero -->
        <div class="relative z-10 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Movie Poster -->
                    <div class="w-full md:w-1/3">
                        <div class="rounded-lg overflow-hidden shadow-2xl">
                            <img src="{{ $movie->poster }}" 
                                 alt="{{ $movie->title }}" 
                                 class="w-full h-auto">
                        </div>
                    </div>

                    <!-- Movie Info -->
                    <div class="w-full md:w-2/3">
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $movie->title }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-4 text-lg text-gray-300 mb-6">
                            <span class="px-3 py-1 bg-gray-800 rounded-full">{{ $movie->genre }}</span>
                            <span class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $movie->duration }} minutes
                            </span>
                            <span class="flex items-center text-yellow-500">
                                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                {{ $movie->rating }}/10
                            </span>
                        </div>

                        <div class="prose prose-lg prose-invert max-w-none mb-8">
                            <h2 class="text-2xl font-semibold mb-4">Synopsis</h2>
                            <p class="text-gray-300 leading-relaxed">{{ $movie->synopsis }}</p>
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('movies.index') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Movies
                            </a>
                            <button class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                                Book Tickets
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trailer Section -->
    @if($movie->trailer_url)
    <div class="bg-gray-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-white mb-8">Watch Trailer</h2>
            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-2xl">
                <iframe 
                    src="{{ $movie->trailer_url }}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen
                    class="w-full h-full">
                </iframe>
            </div>
        </div>
    </div>
    @endif

    <!-- Showtimes Section -->
    <div class="bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-white mb-8">Available Showtimes</h2>
            
            @if($movie->showtimes && $movie->showtimes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($movie->showtimes as $showtime)
                        <div class="bg-gray-900 rounded-lg p-6 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-semibold text-white">{{ $showtime->start_time->format('l, M j') }}</h3>
                                    <p class="text-gray-400">{{ $showtime->start_time->format('g:i A') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-400">Screen</p>
                                    <p class="text-lg font-semibold text-white">{{ $showtime->screen->name }}</p>
                                </div>
                            </div>
                            <a href="{{ route('bookings.seats', $showtime) }}" 
                               class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-200">
                                Select Seats
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-900/50 rounded-lg p-8 text-center">
                    <p class="text-gray-400 text-lg">No showtimes available for this movie at the moment.</p>
                    <p class="text-gray-500 mt-2">Please check back later for updated schedules.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .btn-primary {
            background-color: #e50914;
            border-color: #e50914;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #b2070f;
            border-color: #b2070f;
            transform: translateY(-2px);
        }
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
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endsection 