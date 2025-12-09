<x-app-layout>
    <div class="bg-white">
        <div class="bg-blue-400 border rounded-2xl mt-0 shadow p-6 max-w-7xl mx-auto">
            {{-- Bovenste grid: profiel + badges + rank --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Linkerkant: profielfoto + naam --}}
                <div class="flex flex-col items-center md:items-center">
                    <h3 class="text-3xl font-semibold mb-1">Profiel</h3>

                    <h2 class="mt-4 text-2xl font-bold">{{ $user->name }}</h2>

                    <p class="mt-1 text-sm">
                        <span class="font-semibold">Guides gedaan:</span>
                        {{ $earnedBadgesCount }}
                    </p>
                </div>

                {{-- Badge + Rank sectie --}}
                <div class="col-span-2 flex gap-6">

                    {{-- Badges kolom --}}
                    <div class="flex flex-col items-center gap-4">
                        <h3 class="text-3xl font-semibold mb-2">Mijn badges</h3>

                        @if($badges->isEmpty())
                            <div class="flex flex-col items-center justify-center gap-4 w-full mt-4">
                                <p class="text-center text-black text-lg font-medium">Je hebt nog geen badges</p>
                            </div>
                        @else
                            <div class="grid grid-cols-2 gap-4 justify-items-center">
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

                        <a href="{{ route('badges.library') }}" class="px-4 py-2 rounded-md text-center bg-yellow-500">
                            Alle badges
                        </a>
                    </div>

                    {{-- Rank kolom --}}
                    <div class="flex flex-col items-center gap-0 w-1/2 flex-shrink-0 ml-40">
                        {{-- Rank afbeelding en naam --}}
                        @php
                            if($earnedBadgesCount >= 12) {
                                $rankImage = '/images/badges/uil.png';
                                $rankName = 'Expert';
                                $rankProgress = 100;
                            } elseif($earnedBadgesCount >= 8) {
                                $rankImage = '/images/badges/vos.png';
                                $rankName = 'Gevorderd';
                                $rankProgress = (($earnedBadgesCount - 8) / 4) * 100;
                            } elseif($earnedBadgesCount >= 4) {
                                $rankImage = '/images/badges/bloem.png';
                                $rankName = 'Beginner';
                                $rankProgress = (($earnedBadgesCount - 4) / 4) * 100;
                            } else {
                                $rankImage = '/images/bever.png';
                                $rankName = 'Nog geen rank';
                                $rankProgress = ($earnedBadgesCount / 4) * 100;
                            }
                            $rankProgress = min($rankProgress, 100);
                        @endphp

                        <h3 class="text-3xl font-semibold mb-3">Rang: {{ $rankName }}</h3>

                        <div class="w-80 h-80 rounded-full overflow-hidden flex items-center justify-center">
                            <img src="{{ $rankImage }}" alt="Rank" class="w-full h-full object-cover">
                        </div>

                        {{-- Progressiebalk --}}
                        <div class="mt-4 w-full">
                            <div class="h-4 w-full rounded-full border border-black overflow-hidden">
                                <div class="h-full bg-blue-500" style="width: {{ $rankProgress }}%;"></div>
                            </div>
                            <p class="text-center text-sm mt-1">{{ round($rankProgress) }}%</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
