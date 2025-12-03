<x-app-layout>
    <div class="relative max-w-5xl mx-auto mt-2 p-6 bg-blue-500 rounded-3xl shadow-lg">
        <!-- Terug knop -->
        <div class="max-w-5xl mx-auto mt-0 mb-2 flex justify-start">
            <a href="{{ route('profile.show') }}"
               class="inline-flex items-center px-4 py-2 bg-yellow-400 text-black rounded-md hover:bg-gray-500 transition">
                Terug
            </a>
        </div>

        <!-- Eerste container: Jouw badges -->
        <h2 class="text-2xl font-bold mt-2 mb-0 text-black">Jouw badges ({{ $earnedBadgesCount}}
            van {{ $totalebadges }})
        </h2>
        <div class="p-6 bg-gray-50 rounded-2xl shadow w-full h-[225px] overflow-auto">
            <div class="flex flex-wrap gap-4 justify-start items-start h-full -mt-2">
                @forelse($BadgeUser as $badge)
                    <div class="w-20 h-20 rounded-full overflow-hidden border flex items-center justify-center">
                        <img src="{{ $badge->image }}" alt="{{ $badge->name }}"
                             class="w-full h-full object-cover hover:opacity-70">

                    </div>
                @empty
                    <p class="text-gray-300">Je hebt nog geen badges.</p>
                @endforelse
            </div>
        </div>

        <!-- Tweede container: Nog te behalen badges -->
        <h2 class="text-2xl font-bold mt-2 mb-0 text-black">
            Nog te behalen badges ({{ $nogNietGehaald }} van {{ $totalebadges }})</h2>
        <div class="p-6 bg-gray-50 rounded-2xl shadow w-full h-[225px] overflow-auto">
            <div class="flex flex-wrap gap-4 justify-start items-start h-full -mt-2">
                @foreach($badges as $badge)
                    <div
                        class="w-20 h-20 rounded-full overflow-hidden border relative flex items-center justify-center">
                        <img src="{{ $badge->image }}" alt="{{ $badge->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black opacity-80 hover:opacity-70 transition"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
