<x-app-layout>

    {{-- Header --}}
    <header role="banner">
        <x-slot name="header">
            Badge
        </x-slot>
    </header>

    {{-- Hoofdinhoud --}}
    <main id="main" role="main"
          class="relative bg-blue-400 rounded-2xl shadow p-6 max-w-3xl mx-auto">

        {{-- Terug navigatie --}}
            <a href="{{ route('badges.library') }}"
               class="px-3 py-1 bg-yellow-400 text-gray-950 font-bold rounded-lg hover:bg-gray-300 transition">
                ← Terug naar badges
            </a>

        <section class="flex flex-col items-center justify-center mt-6"
                 aria-labelledby="badge-title">

            {{-- Titel --}}
            <h2 id="badge-title"
                class="text-3xl font-bold mb-2">
                {{ $badge->name }}
            </h2>

            {{-- Status --}}
            @if ($owned)
                <p class="px-4 py-2 bg-green-500 text-white rounded-full mb-4"
                   role="status">
                    ✔ Je bezit deze badge
                </p>
            @else
                <p class="px-4 py-2 bg-red-500 text-white rounded-full mb-4"
                   role="status">
                    ✘ Je bezit deze badge nog niet
                </p>
            @endif

            {{-- Badge navigatie --}}
            <section class="flex items-center justify-center gap-6"
                     aria-label="Badge navigatie">

                {{-- Vorige badge --}}
                <div class="w-32 flex justify-end">
                    @if($previousBadge)
                        <a href="{{ route('badges.show', $previousBadge->id) }}"
                           class="text-7xl font-bold text-gray-950 hover:text-gray-700"
                           aria-label="Ga naar vorige badge: {{ $previousBadge->name }}">
                            ‹
                        </a>
                    @endif
                </div>

                {{-- Badge afbeelding --}}
                <div class="relative w-48 h-48 rounded-full overflow-hidden">
                    <img
                        src="{{ asset($badge->image) }}"
                        alt="Badge {{ $badge->name }}"
                        class="w-full h-full object-cover"
                    >

                    @if (!$owned)
                        <div class="absolute inset-0 bg-black opacity-70"
                             aria-hidden="true"></div>
                    @endif
                </div>

                {{-- Volgende badge --}}
                <div class="w-32 flex justify-start">
                    @if($nextBadge)
                        <a href="{{ route('badges.show', $nextBadge->id) }}"
                           class="text-7xl font-bold text-gray-950 hover:text-gray-700"
                           aria-label="Ga naar volgende badge: {{ $nextBadge->name }}">
                            ›
                        </a>
                    @endif
                </div>

            </section>

            {{-- Beschrijving --}}
            <p class="mt-4 text-center max-w-xl text-lg text-gray-950">
                {{ $badge->description }}
            </p>

            {{-- Challenge koppeling --}}
            @if ($challenges->count() > 0)
                <a href="{{ route('challenges.show', $challenges->first()->id) }}"
                   class="mt-4 inline-block px-4 py-2 bg-yellow-400 text-gray-950 font-bold rounded-lg hover:bg-gray-300">
                    Ga naar uitdaging
                </a>
            @else
                <p class="text-gray-600 mt-4">
                    Er is geen uitdaging gekoppeld aan deze badge.
                </p>
            @endif

        </section>

    </main>

</x-app-layout>
