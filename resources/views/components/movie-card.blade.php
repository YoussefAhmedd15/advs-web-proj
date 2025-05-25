@props(['movie'])

<div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 hover:-translate-y-1">
    <div class="relative">
        <img src="{{ $movie->poster }}" 
             alt="{{ $movie->title }}" 
             class="w-full h-96 object-cover">
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
            <h3 class="text-xl font-bold text-white">{{ $movie->title }}</h3>
            <p class="text-sm text-gray-300">{{ $movie->genre }}</p>
        </div>
    </div>
    <div class="p-4">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm text-gray-400">{{ $movie->duration }} min</span>
            <span class="text-sm font-semibold text-yellow-500">★ {{ $movie->rating }}/10</span>
        </div>
        <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $movie->synopsis }}</p>
        <a href="{{ route('movies.show', $movie) }}" 
           class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
            View Details
        </a>
    </div>
</div> 