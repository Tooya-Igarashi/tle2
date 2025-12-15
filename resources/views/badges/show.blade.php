<x-app-layout>
    <div class="relative bg-blue-400  rounded-2xl mt-0 shadow p-6 max-w-3xl mx-auto">
        <!-- Terug link linksboven -->
        <div class="absolute top-4 left-4">
            <a href="{{ route('badges.library') }}"
               class="px-3 py-1 bg-yellow-400 text-gray-950 font-bold rounded-lg hover:bg-gray-300 transition">
                ← Terug
            </a>
        </div>
        <!-- Container voor titel en badge met pijltjes -->
        <div class="flex flex-col items-center justify-center mt-6">
            <!-- Titel -->
            <h1 class="text-3xl font-bold mb-2">{{ $badge->name }}</h1>
            <!-- Owned status -->
            @if ($owned)
                <span class="px-4 py-2 bg-green-500 text-white rounded-full mb-4">
                    ✔ Je bezit deze badge
                </span>
            @else
                <span class="px-4 py-2 bg-red-500 text-white rounded-full mb-4">
                    ✘ Je bezit deze badge nog niet
                </span>
            @endif
            <!-- Badge + pijltjes -->
            <div class="flex items-center justify-center gap-6">
                <!-- Vorige badge -->
                <div class="w-32 flex justify-end">
                    @if($previousBadge)
                        <a href="{{ route('badges.show', $previousBadge->id) }}"
                           class="flex items-center gap-2 text-gray-950 hover:text-gray-700">
                            <span class="text-7xl font-bold">&#8249;</span>
                        </a>
                    @endif
                </div>
                <!-- Badge afbeelding -->
                <div class="relative w-48 h-48 rounded-full overflow-hidden flex-shrink-0">
                    <img src="{{ asset($badge->image) }}" alt="{{ $badge->name }}" class="w-full h-full object-cover">
                    @if (!$owned)
                        <div class="absolute inset-0 bg-black opacity-70 rounded-full"></div>
                    @endif
                </div>
                <!-- Volgende badge -->
                <div class="w-32 flex justify-start">
                    @if($nextBadge)
                        <a href="{{ route('badges.show', $nextBadge->id) }}"
                           class="flex items-center gap-2 text-gray-950 hover:text-gray-700">
                            <span class="text-7xl font-bold">&#8250;</span>
                        </a>
                    @endif
                </div>
            </div>
            @if ($owned && $owned->acquire)
                <p class="text-gray-950 mb-0">
                    🗓️ Badge behaald op: {{ $owned->acquire->format('d-m-Y') }}
                </p>
            @else
                <p class="text-gray-950 mb-0">🗓️ Nog niet behaald</p>
            @endif
            <p class="-mt-0 mb-2">Hoe heb je deze badge gehaald:</p>
            <!-- Beschrijving -->
            <p class="text-center max-w-xl mb-4 text-lg text-gray-950">
                {{ $badge->description }}
            </p>
            <!-- Challenge koppeling -->
            @if ($challenge)
                <a href="{{ route('challenges.show', $challenge->id) }}"
                   class="mt-2 inline-block px-4 py-2 bg-yellow-400 text-gray-950 font-bold rounded-lg hover:bg-gray-300">
                    Ga naar challenge →
                </a>
            @else
                <p class="text-gray-500">(Geen gekoppelde challenge)</p>
            @endif
        </div>
    </div>
</x-app-layout>
