<x-app-layout>


    {{-- Header --}}
    <header role="banner">
        <x-slot name="header">
            Homepagina
        </x-slot>
    </header>

    {{-- Hoofdinhoud --}}
    <main id="main-content" class="bg-white pb-20">

        {{-- Statusmeldingen --}}
        @if( session('status') )
            <section aria-live="polite" class="py-10">
                <div class="max-w-6xl mx-auto px-6">
                    <div class="bg-sky-300 shadow-md rounded-2xl p-8 text-black">
                        <p class="font-semibold">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            </section>
        @endif

        @if(session('error') || session('denied'))
            <section aria-live="assertive" class="py-10">
                <div class="max-w-6xl mx-auto px-6">
                    <div class="bg-red-600 shadow-md rounded-2xl p-8 text-white">
                        <p class="font-semibold">
                            {{ session('error') ?? session('denied') }}
                        </p>
                    </div>
                </div>
            </section>
        @endif

        {{-- Confetti (met reduced motion check) --}}
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                @if(session('status'))
                if (!prefersReducedMotion) {
                    setTimeout(() => {
                        const duration = 5000;
                        const animationEnd = Date.now() + duration;
                        const interval = setInterval(() => {
                            if (Date.now() > animationEnd) return clearInterval(interval);
                            confetti({particleCount: 100, spread: 360});
                        }, 300);
                    }, 300);
                }
                @endif
            });
        </script>

        {{-- Intro --}}
        <section aria-labelledby="intro-heading" class="py-10">
            <div class="max-w-6xl mx-auto px-6">
                <div class="bg-sky-300 shadow-md rounded-2xl p-8 text-black">
                    <h2 id="intro-heading" class="font-bold text-2xl mb-3">
                        Help jij de natuur?
                    </h2>

                    <p>
                        Veel jongeren willen iets doen voor de natuur. Samen met
                        <strong>Natuurmonumenten</strong> laten we zien hoe jij met kleine acties
                        een groot verschil kunt maken.
                    </p>

                    <a href="https://www.natuurmonumenten.nl/natuurbeschermer/geef"
                       target="_blank"
                       rel="noopener"
                       class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition mt-6">
                        Doneer nu
                    </a>
                </div>
            </div>
        </section>

        {{-- Challenges --}}
        <section aria-labelledby="challenges-heading" class="max-w-6xl mx-auto px-6">
            <h2 id="challenges-heading" class="text-xl font-bold mb-4 text-gray-800">
                Challenges
            </h2>

            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" role="list">
                @forelse($challenges as $challenge)
                    @php $diffId = optional($challenge->difficulty)->id ?? 0; $starMap = [ 1 => 1, 2 => 2, 3 => 3, ]; $stars = $starMap[$diffId] ?? 0; $labels = [ 1 => 'Easy', 2 => 'Medium', 3 => 'Hard', ]; $difficultyLabel = $labels[$diffId] ?? 'Onbekend'; @endphp
                    <li>
                        <article
                            class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition
                            {{ $challenge->completed ? 'border-8 border-pink-600' : 'border border-gray-200' }}"
                            aria-labelledby="challenge-{{ $challenge->id }}-title">

                            @if($challenge->completed)
                                <span
                                    class="absolute -top-5 -right-5 bg-green-500 text-white rounded-full w-14 h-14
                                    flex items-center justify-center shadow-lg border-4 border-white"
                                    aria-label="Challenge voltooid">
                                    ✔
                                </span>
                            @endif

                            <div class="p-6 space-y-4 flex flex-col h-full">

                                <img
                                    src="{{ asset('storage/' . $challenge->image_path) }}"
                                    alt="Afbeelding bij challenge {{ $challenge->title }}"
                                    class="w-full h-40 object-cover rounded-xl"
                                >

                                <h3 id="challenge-{{ $challenge->id }}-title"
                                    class="text-lg font-bold text-black">
                                    {{ $challenge->title }}
                                </h3>

                                <p class="text-sm font-bold">
                                    Moeilijkheid: {{ $difficultyLabel }}
                                </p>

                                <p class="text-gray-700 text-sm font-semibold">
                                    {{ Str::limit($challenge->description, 140) }}
                                </p>

                                <div class="mt-auto flex justify-end">
                                    <a href="{{ route('challenges.show', $challenge) }}"
                                       class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                                        Challenge inzien
                                    </a>
                                </div>
                            </div>
                        </article>
                    </li>
                @empty
                    <li class="col-span-full text-center py-10">
                        Er zijn nog geen challenges beschikbaar.
                    </li>
                @endforelse
            </ul>

            <nav class="mt-8 flex justify-center" aria-label="Alle challenges">
                <a href="{{ route('challenges.all') }}"
                   class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                    Bekijk alle challenges
                </a>
            </nav>
        </section>

    </main>

</x-app-layout>
