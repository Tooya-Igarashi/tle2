<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @auth
                Welkom, {{ Auth::user()->name }}
            @else
                Welkom!
            @endauth
        </h2>
    </x-slot>

    <div class="bg-white">

        {{-- Intro --}}
        <div class="py-10">
            <div class="max-w-6xl mx-auto px-6">
                <div class="bg-sky-300 shadow-md rounded-2xl p-8 text-black">
                    <h1 class="font-bold text-2xl mb-3">Help jij de natuur?</h1>
                    <p class="leading-relaxed">
                        Veel jongeren willen iets doen voor de natuur. Samen met Natuurmonumenten laten we zien
                        hoe jij met kleine acties een groot verschil kunt maken. Of je nu afval opruimt, bloemen zaait
                        of meedoet aan een leuke natuuractie: iedereen kan een natuurbeschermer zijn!
                    </p>
                </div>
            </div>
        </div>

        {{-- Zoekbalk --}}
        <div class="max-w-6xl mx-auto px-6 mb-6">
            <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-3">
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Zoek een challenge..."
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:ring-green-600 focus:border-green-600"
                >
                <button
                    type="submit"
                    class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition"
                >
                    Zoeken
                </button>
            </form>
        </div>

        {{-- Challenges --}}
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Challenges</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse($challenges as $challenge)
                    <div
                        class="bg-green-700 border border-gray-200 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="p-6 space-y-4 flex flex-col justify-between h-full">


                            <img src="{{ $challenge->image_path }}" alt="Voorbeeld foto">

                            <h3 class="text-lg font-bold text-black">
                                {{ $challenge->title }}
                            </h3>

                            {{--                            Sterretjes --}}
                            @php
                                $difficultyValue = optional($challenge->difficulty)->difficulty ?? 0;
                            @endphp
                            {{--sterren --}}
                            @php
                                // Moeilijkheidsgraad ID ophalen (1, 2 of 3)
                                $diffId = optional($challenge->difficulty)->id ?? 0;

                                // Mapping van Moeilijkheidsgraad systeem:
                                $starMap = [
                                    1 => 1,
                                    2 => 2,
                                    3 => 3,
                                ];

                                // Hoeveel sterren moet het tonen
                                $stars = $starMap[$diffId] ?? 0;

                                // Labels voor tekst
                                $labels = [
                                    1 => 'Easy',
                                    2 => 'Medium',
                                    3 => 'Hard',
                                ];

                                $difficultyLabel = $labels[$diffId] ?? 'Onbekend';
                            @endphp

                            <div class="flex items-center gap-1 mt-2">
                                {{-- Sterren tekenen --}}
                                @for ($i = 1; $i <= 3; $i++)
                                    <span class="text-xl {{ $i <= $stars ? 'text-yellow-400' : 'text-gray-300' }}">
            ★
        </span>
                                @endfor

                                {{-- Label --}}
                                <span class="ml-2 text-sm text-gray-700 font-bold">
        {{ $difficultyLabel }}
    </span>
                            </div>

                            {{--                            Beschrijving--}}
                            <p class="text-gray-700 text-sm line-clamp-3 font font-semibold">
                                {{ Str::limit($challenge->description, 140) }}
                            </p>

                            <div class="flex justify-end">
                                <a href="{{route('challenges.show', $challenge)}}"
                                   class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                                    Meer >
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 col-span-full text-center py-10">
                        Er zijn nog geen challenges beschikbaar.
                    </p>
                @endforelse

                <div class="mt-8 col-span-full flex justify-center">
                    <a href="{{ route('challenges.all') }}"
                       class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                        Bekijk alle challenges
                    </a>
                </div>


            </div>
        </div>

    </div>

</x-app-layout>
