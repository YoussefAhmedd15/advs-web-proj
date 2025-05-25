<x-app-layout>
    <div class="py-6 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Section -->
            <div class="mb-8">
                <form action="{{ route('movies.index') }}" method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               name="query" 
                               class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               placeholder="Search movies..." 
                               value="{{ request('query') }}">
                    </div>
                    <div class="w-48">
                        <select name="genre" 
                                class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                onchange="this.form.submit()">
                            <option value="">All Genres</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                    {{ $genre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        Search
                    </button>
                </form>
            </div>

            <!-- Movies Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($movies as $movie)
                    <x-movie-card :movie="$movie" />
                @empty
                    <div class="col-span-full">
                        <div class="bg-blue-900/20 text-blue-200 p-4 rounded-lg">
                            <p>No movies found matching your search criteria.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($movies->hasPages())
                <div class="mt-6">
                    {{ $movies->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

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