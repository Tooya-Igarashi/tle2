<x-app-layout>

    {{-- Hoofdinhoud --}}
    <main id="main" role="main" class="bg-white pb-20">

        <section class="bg-blue-400 border rounded-2xl shadow p-6 max-w-7xl mx-auto"
                 aria-labelledby="profile-heading">

            <h1 id="profile-heading" class="sr-only">
                Profielpagina
            </h1>

            {{-- Grid: profiel / badges / rang --}}
            <div class="flex flex-col md:grid md:grid-cols-3 gap-8">

                {{-- Profielinformatie --}}
                <section class="flex flex-col items-center text-center w-full px-4 md:px-0"
                         aria-labelledby="user-profile-heading">

                    <h2 id="user-profile-heading"
                        class="text-3xl font-semibold mb-1">
                        Profiel
                    </h2>

                    <p class="mt-4 text-2xl font-bold">
                        {{ $user->name }}
                    </p>

                    <p class="mt-1 text-sm">
                        <span class="font-semibold">
                            Gidsen afgerond:
                        </span>
                        {{ $owned }}
                    </p>

                    @if($user->rank == 3)
                        <a href="{{ route('user.create') }}"
                           class="mt-2 inline-block px-4 py-2 bg-yellow-400 text-black rounded-md hover:bg-green-700">
                            Maak je eigen gids
                        </a>
                    @endif
                </section>

                {{-- Badges + rang --}}
                <section class="col-span-2 flex flex-col md:flex-row gap-6">

                    {{-- Badges --}}
                    <section class="flex flex-col items-center gap-4"
                             aria-labelledby="badges-heading">

                        <h2 id="badges-heading"
                            class="text-3xl font-semibold mb-2">
                            Mijn badges
                        </h2>

                        @if($badges->isEmpty())
                            <p class="text-center text-black text-lg font-medium mt-4">
                                Je hebt nog geen badges verdiend
                            </p>
                        @else
                            <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-2 gap-4 justify-items-center"
                                role="list"
                                aria-label="Verdiende badges">

                                @foreach($badges as $badge)
                                    <li class="flex flex-col items-center">

                                        <div
                                            class="w-28 h-28 rounded-full overflow-hidden flex items-center justify-center">
                                            <img
                                                src="{{ $badge->image }}"
                                                alt="Badge {{ $badge->name }}"
                                                class="w-full h-full object-cover"
                                            >
                                        </div>

                                        <p class="mt-2 text-sm font-medium text-center">
                                            {{ $badge->name }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <a href="{{ route('badges.library') }}"
                           class="px-4 py-2 rounded-md text-center bg-yellow-500 hover:bg-green-700">
                            Alle badges bekijken
                        </a>
                    </section>

                    {{-- Rang en voortgang --}}
                    <section class="flex flex-col items-center w-full md:w-1/2 md:ml-40"
                             aria-labelledby="rank-heading">

                        <h2 id="rank-heading"
                            class="text-3xl font-semibold mb-3">
                            Rang: {{ $rankName }}
                        </h2>

                        <div class="w-80 h-80 rounded-full overflow-hidden flex items-center justify-center">
                            <img
                                src="{{ $rankImage }}"
                                alt="Afbeelding van rang {{ $rankName }}"
                                class="w-full h-full object-cover"
                            >
                        </div>

                        {{-- Voortgang --}}
                        <div class="mt-4 w-full"
                             role="progressbar"
                             aria-valuenow="{{ $owned }}"
                             aria-valuemin="0"
                             aria-valuemax="{{ $owned + $required }}"
                             aria-label="Voortgang naar volgende rang">

                            <div class="h-4 w-full rounded-full border border-black overflow-hidden">
                                <div class="h-full bg-green-800"
                                     style="width: {{ $progress }}%;"></div>
                            </div>

                            <p class="text-center text-sm mt-1">
                                {{ $owned }} van {{ $owned + $required }} badges —
                                nog {{ $required ?? 0 }} te gaan voor de volgende rang
                            </p>
                        </div>
                    </section>
                </section>
            </div>
        </section>
    </main>
</x-app-layout>
