<x-app-layout>
    <div class="min-h-screen p-8">

        {{-- Container --}}
        <div class="max-w-5xl mx-auto">

            {{-- Bovenste grid: profiel + badges --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Linkerkant: profielfoto + naam --}}
                <div class="flex flex-col items-center md:items-start">

                    <!-- Profielfoto -->
                    <div class="w-40 h-40 rounded-2xl overflow-hidden flex items-center justify-center bg-gray-200">
                        <img src="{{ $user->profile_photo_url ?? '/img/default-avatar.png' }}"
                             alt="Profielfoto"
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


                {{-- Badge sectie --}}
                <div class="col-span-2">

                    <h3 class="text-lg font-semibold mb-3">Mijn badges</h3>

                    <div class="flex gap-4 flex-wrap">
                        @foreach($badges as $badge)
                            <div class="w-20 h-20 rounded-full overflow-hidden border flex items-center justify-center">
                                <img src="{{ $badge->image_url }}"
                                     alt="{{ $badge->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>

                    <button class="mt-4 px-4 py-2 rounded-md border">
                        Alle badges
                    </button>
                </div>

            </div>


            {{-- Rank rechts onder --}}
            <div class="mt-16 flex justify-end">

                <div class="flex flex-col items-center">

                    {{-- Rank naam --}}
                    <h3 class="font-semibold mb-3">Rang: {{ $user->rank->name ?? 'Onbekend' }}</h3>

                    {{-- Rank afbeelding --}}
                    <div class="w-40 h-40 rounded-full overflow-hidden border flex items-center justify-center">
                        <img src="{{ $user->rank->image_url ?? '/img/default-rank.png' }}"
                             alt="Rank"
                             class="w-full h-full object-cover">
                    </div>

                    {{-- Level bar --}}
                    <div class="mt-4 w-40">
                        <div class="h-4 w-full rounded-full border overflow-hidden">
                            <div class="h-full" style="width: {{ $user->rank_progress ?? 0 }}%;"></div>
                        </div>
                        <p class="text-center text-sm mt-1">
                            {{ $user->rank_progress ?? 0 }}%
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
