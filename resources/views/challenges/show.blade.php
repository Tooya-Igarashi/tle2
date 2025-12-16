<x-app-layout>
    <x-slot name="header">
        {{$challenge->title}}
    </x-slot>
    <main class="bg-white py-8 px-4 pb-20">
        <div class="max-w-3xl mx-auto">

            <div class="rounded-2xl shadow-md p-6 md:p-8 bg-green-200">

                <div class="flex flex-col md:flex-row gap-6">

{{--                    <div class="flex-shrink-0 md:w-1/3">--}}
{{--                        <img src="{{ asset($challenge->image_path) }}"--}}
{{--                             alt="Challenge Image"--}}
{{--                             class="rounded-xl shadow-md w-full h-auto">--}}
{{--                    </div>--}}

                    <img src="{{ asset('storage/' . $challenge->image_path) }}"
                         alt="Challenge Image"
                          class="w-44 h-auto object-cover rounded-xl">

                    <div class="flex-1">

                        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                            {{ $challenge->title }}
                        </h1>

                        <div class="flex items-center mb-3" aria-label="difficulty {{$challenge->difficulty->difficulty}}">
{{--                            @php--}}
{{--                                $stars = $difficulty === 'Easy' ? -3 : ($difficulty === 'Medium' ? -2  : -1);--}}
{{--                            @endphp--}}

{{--                            @for($i = 3; $i <= 3; $i++)--}}
{{--                                <span class="text-xl text-yellow-400 {{ $i <= $stars }}">★</span>--}}
{{--                            @endfor--}}

                            {{-- Sterretjes --}}
                            @php
                                // Moeilijkheidsgraad ID ophalen (1, 2 of 3)
                                $diffId = optional($challenge->difficulty)->id ?? 0;

                                // Mapping van Moeilijkheidsgraad systeem:
                                $starMap = [
                                    1 => 1,
                                    2 => 2,
                                    3 => 3,
                                ];

                                // Hoeveel sterren moet het tonen
                                $stars = $starMap[$diffId] ?? 0;

                                // Labels voor tekst
                                $labels = [
                                    1 => 'Easy',
                                    2 => 'Medium',
                                    3 => 'Hard',
                                ];

                                $difficultyLabel = $labels[$diffId] ?? 'Onbekend';
                            @endphp

                            <div class="flex items-center gap-1 mt-2">
                                {{-- Sterren tekenen --}}
                                @for ($i = 1; $i <= 3; $i++)
                                    <span
                                        class="text-xl {{ $i <= $stars ? 'text-yellow-400' : 'text-gray-300' }}" aria-hidden="true">
                                        ★
                                    </span>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $challenge->description }}
                        </p>

                        <p class="mt-3 font-semibold text-gray-900">
                            Duur: <span class="font-normal">{{ $challenge->duration }}</span>
                        </p>

                    </div>
                </div>

            </div>
            <div class="rounded-2xl shadow-md p-6 md:p-8 bg-blue-200">

                @if($challenge->steps->isNotEmpty())
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Stappen</h2>

                    <ul class="space-y-3">
                        @foreach($challenge->steps as $step)
                            <li class="flex gap-3 items-start">
                                <input type="checkbox"
                                       class="mt-1 w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">

                                <label class="leading-relaxed cursor-pointer">
                                    <span class="font-semibold text-gray-900">
                                        {{ $step->step_number }}.
                                    </span>
                                    {!! nl2br(e($step->step_description)) !!}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @php
                    $user = auth()->user();
                    $hasBadge = false;

                    if ($user && isset($challenge) && $challenge->badge_id) {

                        $hasBadge = $user->badges->contains('id', $challenge->badge_id);
                    }
                @endphp

                @auth

                    @if($hasBadge)
                        <div class="flex items-center gap-4">
                            <img src="{{ asset($challenge->badge->image) }}" class="w-20 h-20 ">
                            <div>
                                <p class="font-semibold">Je hebt deze badge al verdiend!</p>
                                <p>{{ $challenge->badge->name }}</p>
                            </div>
                            <div class="pt-3">
                                <a href="{{ route('dashboard') }}"
                                   class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">Ga
                                    terug</a>
                            </div>

                        </div>
                    @else
                        <div class="mt-8 text-center">
                            <a href="{{ route('upload.show', $challenge) }}"
                               class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                                Lever nu in
                            </a>
                        </div>
                    @endif
                @endauth


            </div>

        </div>
    </main>
</x-app-layout>
