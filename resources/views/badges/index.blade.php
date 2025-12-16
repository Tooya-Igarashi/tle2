<x-app-layout>

    {{-- Header --}}
    <header role="banner">
        <x-slot name="header">
            Badges
        </x-slot>

        <x-slot name="headerDescription">
            Jouw collectie van behaalde en nog te behalen badges
        </x-slot>
    </header>

    {{-- Hoofdinhoud --}}
    <main id="main" role="main"
          class="relative max-w-5xl mx-auto mt-2 p-6 bg-blue-500 rounded-3xl shadow-lg">

        {{-- Navigatie --}}
        <nav aria-label="Terug navigatie" class="mb-2">
            <a href="{{ route('profile.show') }}"
               class="inline-flex items-center px-4 py-2 bg-yellow-400 text-black rounded-md hover:bg-gray-500 transition">
                Terug naar profiel
            </a>
        </nav>

        {{-- Behaalde badges --}}
        <section aria-labelledby="earned-badges-heading" class="mb-6">

            <h2 id="earned-badges-heading"
                class="text-2xl font-bold mt-2 mb-2 text-black">
                Jouw badges ({{ $earnedBadgesCount }} van {{ $totalbadges }})
            </h2>

            <div class="p-6 bg-gray-50 rounded-2xl shadow w-full h-[225px] overflow-auto">

                @if($earnedBadges->isEmpty())
                    <p class="text-black">
                        Je hebt nog geen badges verdiend.
                    </p>
                @else
                    <ul class="flex flex-wrap gap-4"
                        role="list"
                        aria-label="Behaalde badges">

                        @foreach($earnedBadges as $badge)
                            <li>
                                <a href="{{ route('badges.show', $badge->id) }}"
                                   aria-label="Bekijk badge {{ $badge->name }}">

                                    <div class="w-20 h-20 rounded-full overflow-hidden border">
                                        <img
                                            src="{{ asset($badge->image) }}"
                                            alt="Behaalde badge {{ $badge->name }}"
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                </a>
                            </li>
                        @endforeach

                    </ul>
                @endif
            </div>
        </section>

        {{-- Nog te behalen badges --}}
        <section aria-labelledby="todo-badges-heading">

            <h2 id="todo-badges-heading"
                class="text-2xl font-bold mt-2 mb-2 text-black">
                Nog te behalen badges ({{ $notyetachieved }} van {{ $totalbadges }})
            </h2>

            <div class="p-6 bg-gray-50 rounded-2xl shadow w-full h-[225px] overflow-auto">

                <ul class="flex flex-wrap gap-4"
                    role="list"
                    aria-label="Nog te behalen badges">

                    @foreach($todoBadges as $badge)
                        <li>
                            <a href="{{ route('badges.show', $badge->id) }}"
                               aria-label="Bekijk badge {{ $badge->name }} (nog niet behaald)">

                                <div class="w-20 h-20 rounded-full overflow-hidden relative">
                                    <img
                                        src="{{ asset($badge->image) }}"
                                        alt="Nog niet behaalde badge {{ $badge->name }}"
                                        class="w-full h-full object-cover"
                                    >
                                    <div class="absolute inset-0 bg-black opacity-80"
                                         aria-hidden="true"></div>
                                </div>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </section>

    </main>

</x-app-layout>
