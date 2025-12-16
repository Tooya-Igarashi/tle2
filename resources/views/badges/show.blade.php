<x-app-layout>
    <div class="relative bg-blue-400 rounded-2xl shadow p-6 max-w-3xl mx-auto">

        <!-- Terug -->
        <div class="absolute top-4 left-4">
            <a href="{{ route('badges.library') }}"
               class="px-3 py-1 bg-yellow-400 text-gray-950 font-bold rounded-lg hover:bg-gray-300 transition">
                ← Terug
            </a>
        </div>

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

            <!-- Badge + navigatie -->
            <div class="flex items-center justify-center gap-6">

                <!-- Vorige -->
                <div class="w-32 flex justify-end">
                    @if($previousBadge)
                        <a href="{{ route('badges.show', $previousBadge->id) }}"
                           class="text-7xl font-bold text-gray-950 hover:text-gray-700">
                            &#8249;
                        </a>
                    @endif
                </div>

                <!-- Badge -->
                <div class="relative w-48 h-48 rounded-full overflow-hidden">
                    <img src="{{ asset($badge->image) }}"
                         alt="{{ $badge->name }}"
                         class="w-full h-full object-cover">

                    @if (!$owned)
                        <div class="absolute inset-0 bg-black opacity-70"></div>
                    @endif
                </div>

                <!-- Volgende -->
                <div class="w-32 flex justify-start">
                    @if($nextBadge)
                        <a href="{{ route('badges.show', $nextBadge->id) }}"
                           class="text-7xl font-bold text-gray-950 hover:text-gray-700">
                            &#8250;
                        </a>
                    @endif
                </div>

            </div>

            <!-- Beschrijving -->
            <p class="mt-4 text-center max-w-xl text-lg text-gray-950">
                {{ $badge->description }}
            </p>

            <!-- Challenge link -->
            @if ($challenges->count() > 0)
                <a href="{{ route('challenges.show', $challenges->first()->id) }}"
                   class="mt-4 inline-block px-4 py-2 bg-yellow-400 text-gray-950 font-bold rounded-lg hover:bg-gray-300">
                    Ga naar challenge →
                </a>
            @else
                <p class="text-gray-500 mt-4">(Geen gekoppelde challenge)</p>
            @endif

        </div>
    </div>
</x-app-layout>
