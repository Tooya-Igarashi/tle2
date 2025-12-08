<x-app-layout>
    <div class="bg-blue-400 border rounded-2xl mt-0 shadow p-6 max-w-7xl mx-auto">

        {{-- Bovenste grid: profiel + badges + rank --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Linkerkant: profielfoto + naam --}}
            {{-- Linkerkant: profielfoto + naam --}}
            <div class="flex flex-col items-center md:items-center">
                <!-- Titel boven avatar, gecentreerd boven de avatar -->
                <h3 class="text-xl font-semibold mb-2 text-center w-full">Profiel</h3>
                <!-- Username -->
                <h2 class="mt-4 text-2xl font-bold">
                    {{ $user->name }}
                </h2>

                <!-- Guides gedaan -->
                <p class="mt-1 text-sm">
                    <span class="font-semibold">Guides gedaan:</span>
                    {{ $earnedBadgesCount }}
                </p>
            </div>
            {{-- Badge + Rank sectie --}}
            <div class="col-span-2 flex gap-6">

                {{-- Badges kolom --}}
                <div class="flex flex-col items-center gap-4">
                    <!-- Titel boven de badges -->
                    <h3 class="text-xl font-semibold mb-2">Mijn badges</h3>

                    <!-- Grid met badges 2x2 -->
                    <div class="grid grid-cols-2 gap-4 justify-items-center">
                        @forelse($badges as $badge)
                            <div class="flex flex-col items-center">
                                <div class="w-28 h-28 rounded-full overflow-hidden flex items-center justify-center">
                                    <img src="{{ $badge->image }}"
                                         alt="{{ $badge->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                                <p class="mt-2 text-sm font-medium text-center">{{ $badge->name }}</p>
                            </div>
                        @empty
                            <p class="text-black">Je hebt nog geen badges</p>
                        @endforelse
                    </div>


                    <!-- Knop onder de badges -->
                    <a href="{{ route('badges.library') }}"
                       class="mt-4 px-4 py-2 rounded-md text-center bg-green-700">
                        Alle badges
                    </a>
                </div>

                {{-- Rank kolom --}}
                <div class="flex flex-col items-center gap-0 w-1/2 flex-shrink-0 ml-12">
                    <h3 class="text-xl font-semibold mb-3">Rang: {{ $user->rankname }}</h3>

                    <div class="w-80 h-80 rounded-full overflow-hidden flex items-center justify-center">
                        <img src="{{ $user->rankimage }}" alt="Rank" class="w-full h-full object-cover">
                    </div>

                    <div class="mt-4 w-full">
                        <div class="h-4 w-full rounded-full border border-black overflow-hidden">
                            <div class="h-full bg-blue-500" style="width: {{ $earnedBadgesCount*5 }}%;"></div>
                        </div>
                        <p class="text-center text-sm mt-1">{{ $earnedBadgesCount*5 }}%</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
