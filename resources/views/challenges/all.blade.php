<x-app-layout>

    {{-- Header --}}
    <header role="banner">
        <x-slot name="header">
            @auth
                Welkom, {{ Auth::user()->name }}
            @else
                Welkom!
            @endauth
        </x-slot>
    </header>

    {{-- Hoofdinhoud --}}
    <main role="main" id="main" class="bg-white pb-20">

        {{-- Logo --}}
        <section aria-labelledby="logo-heading" class="py-10">
            <h2 id="logo-heading" class="sr-only">Bever logo</h2>
            <div class="max-w-6xl mx-auto px-6 flex justify-center">
                <img
                    src="{{ asset('images/BeverLogo.png') }}"
                    alt="Bever logo"
                    class="w-52 h-auto drop-shadow-lg"
                >
            </div>
        </section>

        {{-- Filteren en zoeken --}}
        <section aria-labelledby="filter-heading" class="max-w-6xl mx-auto px-6 mb-6">
            <h2 id="filter-heading" class="sr-only">
                Filteren en zoeken van uitdagingen
            </h2>

            <div class="flex justify-between items-center flex-wrap gap-6">

                {{-- Filter --}}
                <form method="GET"
                      action="{{ route('challenges.all') }}"
                      class="flex gap-4 items-center">

                    <label for="difficulty" class="sr-only">
                        Filter op moeilijkheidsgraad
                    </label>

                    <select id="difficulty"
                            name="difficulty"
                            class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold rounded px-6 py-3">
                        <option value="">Alle niveaus</option>
                        @foreach($difficulties as $difficulty)
                            <option value="{{ $difficulty->id }}"
                                {{ request('difficulty') == $difficulty->id ? 'selected' : '' }}>
                                {{ $difficulty->difficulty }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded">
                        Filter toepassen
                    </button>

                    <a href="{{ route('challenges.all') }}"
                       class="bg-gray-700 text-white px-4 py-2 rounded">
                        Filters wissen
                    </a>
                </form>

                {{-- Zoeken --}}
                <form method="GET"
                      action="{{ route('challenges.all') }}"
                      class="flex gap-4 items-center">

                    <label for="search" class="sr-only">
                        Zoek een uitdaging
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Zoek een uitdaging..."
                        class="border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:ring-green-600 focus:border-green-600"
                    >

                    <button type="submit"
                            class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                        Zoeken
                    </button>
                </form>

            </div>
        </section>

        {{-- Uitdagingen --}}
        <section aria-labelledby="challenges-heading" class="max-w-6xl mx-auto px-6">
            <h2 id="challenges-heading" class="text-xl font-bold mb-4 text-gray-800">
                Uitdagingen
            </h2>

            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" role="list">

                @forelse($challenges as $challenge)
                    @php
                        $diffId = optional($challenge->difficulty)->id ?? 0;

                        $labels = [
                            1 => 'Makkelijk',
                            2 => 'Gemiddeld',
                            3 => 'Moeilijk',
                        ];

                        $stars = $diffId;
                        $difficultyLabel = $labels[$diffId] ?? 'Onbekend';
                    @endphp

                    <li>
                        <article
                            class="relative rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1
                            {{ $challenge->completed ? 'bg-white border-8 border-pink-600' : 'bg-white border border-gray-200' }}"
                            aria-labelledby="challenge-{{ $challenge->id }}-title">

                            @if($challenge->completed)
                                <span
                                    class="absolute -top-4 -right-4 bg-green-500 text-white rounded-full
               w-14 h-14 flex items-center justify-center
               shadow-lg border-4 border-white text-xl"
                                    aria-label="Deze uitdaging is voltooid">
        ✔
    </span>
                            @endif


                            <div class="p-6 space-y-4 flex flex-col h-full">

                                <img
                                    src="{{ asset('storage/' . $challenge->image_path) }}"
                                    alt="Afbeelding bij de uitdaging {{ $challenge->title }}"
                                    class="w-full h-40 object-cover rounded-xl"
                                >

                                <h3 id="challenge-{{ $challenge->id }}-title"
                                    class="text-lg font-bold text-black">
                                    {{ $challenge->title }}
                                </h3>

                                {{-- Moeilijkheidsgraad --}}
                                <div class="flex items-center gap-1"
                                     aria-label="Moeilijkheidsgraad: {{ $difficultyLabel }}, {{ $stars }} van de 3 sterren">

                                    @for ($i = 1; $i <= 3; $i++)
                                        <span
                                            class="text-xl {{ $i <= $stars ? 'text-yellow-400' : 'text-gray-300' }}"
                                            aria-hidden="true">
                                            ★
                                        </span>
                                    @endfor

                                    <span class="ml-2 text-sm text-gray-700 font-bold">
                                        {{ $difficultyLabel }}
                                    </span>
                                </div>

                                <p class="text-gray-700 text-sm font-semibold">
                                    {{ Str::limit($challenge->description, 140) }}
                                </p>

                                <div class="mt-auto flex justify-end">
                                    <a href="{{ route('challenges.show', $challenge) }}"
                                       class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                                        Uitdaging bekijken
                                    </a>
                                </div>

                            </div>
                        </article>
                    </li>
                @empty
                    <li class="col-span-full text-center py-10">
                        Er zijn nog geen uitdagingen beschikbaar.
                    </li>
                @endforelse

            </ul>
        </section>

    </main>
</x-app-layout>
