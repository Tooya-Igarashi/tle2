<x-app-layout>
    <main class="min-h-screen py-8 px-4">
        <div class="max-w-3xl mx-auto">

            <div class="rounded-2xl shadow-md p-6 md:p-8 bg-green-200">

                <div class="flex flex-col md:flex-row gap-6">

                    <div class="flex-shrink-0 md:w-1/3">
                        <img src="{{ $challenge->image_url }}"
                             alt="Challenge Image"
                             class="rounded-xl shadow-md w-full h-auto">
                    </div>

                    <div class="flex-1">

                        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                            {{ $challenge->title }}
                        </h1>

                        <div class="flex items-center mb-3">
                            @php
                                $stars = $difficulty === 'Easy' ? -3 : ($difficulty === 'Medium' ? -2  : -1);
                            @endphp

                            @for($i = 3; $i <= 3; $i++)
                                <span class="text-xl text-yellow-400 {{ $i <= $stars }}">★</span>
                            @endfor
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

                <div class="mt-8 text-center">
                    <a href=""
                       class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                        Lever nu in
                    </a>
                </div>

            </div>

        </div>
    </main>
</x-app-layout>
