<x-app-layout>
    <x-slot name="header">
        Profiel pagina
    </x-slot>
    <div class="bg-white pb-20">
        <div class="bg-blue-400 border rounded-2xl mt-0 shadow p-6 max-w-7xl mx-auto">
            {{-- Bovenste grid: profiel + badges + rank --}}
            <div class="flex flex-col md:grid md:grid-cols-3 gap-8">


                {{-- Linkerkant: profielfoto + naam --}}
                <div class="flex flex-col items-center text-center w-full px-4 md:px-0">
                    <h2 class="mt-4 text-2xl font-bold">{{ $user->name }}</h2>
                    <p class="mt-1 text-sm">
                        <span class="font-semibold">Guides gedaan:</span>
                        {{ $owned }}
                    </p>
                    @if($user->rank == 3)
                        <a href="{{ route('user.create') }}"
                           class="mt-2 inline-block px-4 py-2 bg-yellow-400 text-black rounded-md hover:bg-green-700">
                            Maak je eigen guide
                        </a>
                    @endif
                </div>

                {{-- Badge + Rank sectie --}}
                <div class="col-span-2 flex flex-col md:flex-row gap-6">

                    {{-- Badges kolom --}}
                    <div class="flex flex-col items-center gap-4">
                        <h3 class="text-3xl font-semibold mb-2">Mijn badges</h3>

                        @if($badges->isEmpty())
                            <div class="flex flex-col items-center justify-center gap-4 w-full mt-4">
                                <p class="text-center text-black text-lg font-medium">Je hebt nog geen badges</p>
                            </div>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-2 gap-4 justify-items-center">

                                @foreach($badges as $badge)
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-28 h-28 rounded-full overflow-hidden flex items-center justify-center">
                                            <img src="{{ $badge->image }}" alt="{{ $badge->name }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <p class="mt-2 text-sm font-medium text-center">{{ $badge->name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <a href="{{ route('badges.library') }}"
                           class="px-4 py-2 rounded-md text-center bg-yellow-500 hover:bg-green-700">
                            Alle badges
                        </a>
                    </div>

                    {{-- Rank kolom --}}
                    <div class="flex flex-col items-center gap-0 w-full md:w-1/2 flex-shrink-0 md:ml-40">

                        {{-- Rank afbeelding en naam --}}
                        <h3 class="text-3xl font-semibold mb-3">Rang: {{ $rankName }}</h3>

                        <div class="w-80 h-80 rounded-full overflow-hidden flex items-center justify-center">
                            <img src="{{ $rankImage }}" alt="Rank" class="w-full h-full object-cover">
                        </div>

                        {{-- Progressiebalk --}}
                        <div class="mt-4 w-full">
                            <div class="h-4 w-full rounded-full border border-black overflow-hidden">
                                <div class="h-full bg-green-800" style="width: {{ $progress }}%;"></div>
                            </div>
                            <p class="text-center text-sm mt-1">{{ $owned }} / {{ $owned + $required }} badges
                                ({{ $required ??0 }} te gaan voor volgende rank)</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
