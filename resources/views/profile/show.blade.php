<x-app-layout>
    <div class="bg-gray-700 border rounded-2xl shadow p-5">

        {{-- Bovenste grid: profiel + badges + rank --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Linkerkant: profielfoto + naam --}}
            <div class="flex flex-col items-center md:items-start">

                <!-- Profielfoto -->
                <div class="w-80 h-80 rounded-2xl overflow-hidden flex items-center justify-center bg-gray-200">
                    <img src="{{ $user->profile_photo_url ?? '/img/default-avatar.png' }}"
                         alt="Profielavatar"
                         class="w-full h-full object-cover">
                </div>

                <!-- Username -->
                <h2 class="mt-4 text-2xl font-bold">
                    {{ $user->name }}
                </h2>

                <!-- Guides gedaan -->
                <p class="mt-1 text-sm">
                    <span class="font-semibold">Guides gedaan:</span>
                    {{ $user->guides_count ?? 0 }}
                </p>
            </div>

            {{-- Badge + Rank sectie --}}
            <div class="col-span-2">
                <h3 class="text-lg font-semibold mb-3">Mijn badges</h3>
                {{-- Flex container voor badges en rank naast elkaar --}}
                <div class="flex gap-6">

                    {{-- Badges kolom --}}
                    <div class="flex flex-col gap-2">
                        @forelse($badges as $badge)
                            <div class="w-28 h-28 rounded-full overflow-hidden border flex items-center justify-center">
                                <img src="{{ $badge->image }}"
                                     alt="{{ $badge->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @empty
                            <p class="text-gray-500">Je hebt nog geen badges</p>
                        @endforelse

                        <button class="mt-4 px-2 py-2 rounded-md border">
                            Alle badges
                        </button>
                    </div>

                    {{-- Rank kolom --}}
                    <div class="flex flex-col items-center gap-0 w-1/2 flex-shrink-0 ml-44">
                        <h3 class="font-semibold mb-3">Rang: {{ $user->rankname }}</h3>

                        <div class="w-80 h-80 rounded-full overflow-hidden border flex items-center justify-center">
                            <img src="{{ $user->rankimage }}" alt="Rank" class="w-full h-full object-cover">
                        </div>

                        <div class="mt-4 w-full">
                            <div class="h-4 w-full rounded-full border overflow-hidden">
                                <div class="h-full bg-blue-500" style="width: {{ $user->rank_progress ?? 0 }}%;"></div>
                            </div>
                            <p class="text-center text-sm mt-1">{{ $user->rank }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
