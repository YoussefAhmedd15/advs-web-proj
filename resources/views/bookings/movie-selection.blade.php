<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Select a Movie</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($movies as $movie)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                @if($movie->poster_url)
                                    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-full h-64 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="text-xl font-semibold mb-2">{{ $movie->title }}</h3>
                                    <p class="text-gray-600 mb-2">{{ Str::limit($movie->description, 100) }}</p>
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-sm text-gray-500">{{ $movie->duration_minutes }} minutes</span>
                                        <span class="text-sm text-gray-500">{{ $movie->genre }}</span>
                                    </div>
                                    <a href="{{ route('bookings.showtimes', $movie) }}" 
                                       class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
                                        Select Showtime
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 