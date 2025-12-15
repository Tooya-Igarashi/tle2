<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-black">
            @auth
                Welkom, {{ Auth::user()->name }}
            @else
                Welkom!
            @endauth
        </h2>
    </x-slot>

    <div class="bg-white pb-20">
        @if(session('status'))
            <div class="bg-white">
                <div class="py-10">
                    <div class="max-w-6xl mx-auto px-6">
                        <div class="bg-sky-300 shadow-md rounded-2xl p-8 text-black">
                            <div class="alert alert-info text-black p12 font-semibold">
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-white">
                <div class="py-10">
                    <div class="max-w-6xl mx-auto px-6">
                        <div class="bg-red-600 shadow-md rounded-2xl p-8 text-black">
                            <div class="alert alert-info text-black p12 font-semibold">
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(session('denied'))
            <div class="bg-white">
                <div class="py-10">
                    <div class="max-w-6xl mx-auto px-6">
                        <div class="bg-red-600 shadow-md rounded-2xl p-8 text-black">
                            <div class="alert alert-info text-black p12 font-semibold">
                                <div class="alert alert-danger">{{ session('denied') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if(session('status'))
                setTimeout(() => {
                    const duration = 5 * 1000; // 5 seconden
                    const animationEnd = Date.now() + duration;
                    const defaults = {
                        startVelocity: 40,
                        spread: 360,
                        ticks: 80,
                        zIndex: 9999
                    };
                    const interval = setInterval(function () {
                        const timeLeft = animationEnd - Date.now();
                        if (timeLeft <= 0) return clearInterval(interval);
                        // Meer particles
                        const particleCount = 250 * (timeLeft / duration);
                        confetti(Object.assign({}, defaults, {
                            particleCount,
                            origin: {x: Math.random(), y: Math.random() - 0.2},
                            colors: ['#fbbf24', '#f59e0b', '#84cc16', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899'] // veel kleuren
                        }));
                    }, 200); // elke 200ms een burst
                }, 300);
                @endif
            });
        </script>
        <div class="bg-white">

            {{-- Intro --}}
            <div class="py-10">
                <div class="max-w-6xl mx-auto px-6">
                    <div class="bg-sky-300 shadow-md rounded-2xl p-8 text-black">
                        <h1 class="font-bold text-2xl mb-3">Help jij de natuur?</h1>
                        <p class="leading-relaxed ">
                            Veel jongeren willen iets doen voor de natuur. Samen met Natuurmonumenten laten
                            we zien
                            hoe jij met kleine acties een groot verschil kunt maken. Of je nu afval opruimt,
                            bloemen
                            zaait
                            of meedoet aan een leuke natuuractie: iedereen kan een natuurbeschermer zijn!
                        </p>
                        <a href="https://www.natuurmonumenten.nl/natuurbeschermer/geef" target="_blank"
                           class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition mt-6">
                            Doneer Nu!
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Challenges --}}
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Challenges</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($challenges as $challenge)
                    <div
                        class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1
        {{ $challenge->completed ? 'border-8 border-pink-600' : 'border border-gray-200' }}">

                        @if($challenge->completed)
                            <div
                                class="absolute -top-5 -right-5 bg-green-500 text-white rounded-full w-14 h-14 flex items-center justify-center
                       shadow-lg z-20 border-4 border-white"
                                title="Challenge voltooid"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        @endif

                        <div class="p-6 space-y-4 flex flex-col justify-between h-full">

                            <img src="{{ asset('storage/' . $challenge->image_path) }}"
                                 alt="Challenge Image"
                                 class="w-full h-40 object-cover rounded-xl">

                            <h3 class="text-lg font-bold text-black">
                                {{ $challenge->title }}
                            </h3>
                            @php
                                $diffId = optional($challenge->difficulty)->id ?? 0;

                                $starMap = [
                                    1 => 1,
                                    2 => 2,
                                    3 => 3,
                                ];

                                $stars = $starMap[$diffId] ?? 0;

                                $labels = [
                                    1 => 'Easy',
                                    2 => 'Medium',
                                    3 => 'Hard',
                                ];

                                $difficultyLabel = $labels[$diffId] ?? 'Onbekend';
                            @endphp

                            <div class="flex items-center gap-1 mt-2">
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

                            <p class="text-gray-700 text-sm line-clamp-3 font-semibold">
                                {{ Str::limit($challenge->description, 140) }}
                            </p>

                            <div class="flex justify-end">
                                <a href="{{ route('challenges.show', $challenge) }}"
                                   class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                                    Challenge inzien
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
