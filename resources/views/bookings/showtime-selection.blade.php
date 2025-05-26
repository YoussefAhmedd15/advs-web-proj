<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold">{{ $movie->title }}</h2>
                        <p class="text-gray-600">{{ $movie->synopsis }}</p>
                        <div class="mt-2">
                            <span class="text-sm text-gray-500">Genre: {{ $movie->genre }}</span>
                            <span class="text-sm text-gray-500 ml-4">Duration: {{ $movie->duration }} minutes</span>
                            <span class="text-sm text-gray-500 ml-4">Rating: {{ $movie->rating }}/10</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-4">Available Showtimes</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($showtimes as $showtime)
                            <div class="border rounded-lg p-4">
                                <div class="mb-2">
                                    <span class="font-semibold">Screen:</span> {{ $showtime->screen->name }}
                                </div>
                                <div class="mb-2">
                                    <span class="font-semibold">Time:</span> 
                                    {{ $showtime->date ?? 'N/A' }} at {{ $showtime->time ?? 'N/A' }}
                                </div>
                                <div class="mb-4">
                                    <span class="font-semibold">Base Price:</span> 
                                    ${{ number_format($showtime->price, 2) }}
                                </div>
                                <a href="{{ route('bookings.seats', $showtime) }}" 
                                   class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
                                    Select Seats
                                </a>
                            </div>
                        @endforeach
                    </div>

                    @if($showtimes->isEmpty())
                        <p class="text-gray-600">No showtimes available for this movie.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 