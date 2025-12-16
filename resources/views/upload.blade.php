<x-app-layout>

    {{-- Header --}}
    <header role="banner">
        <x-slot name="header">
            Upload jouw uitdaging
        </x-slot>
    </header>

    {{-- Hoofdinhoud --}}
    <main id="main" role="main"
          class="bg-white flex flex-col md:flex-row gap-20 justify-center pb-20 px-4">

        {{-- Challenge informatie --}}
        <section class="bg-emerald-500 p-14 rounded-2xl max-w-xl"
                 aria-labelledby="challenge-title">

            <article>

                <h2 id="challenge-title"
                    class="text-2xl font-semibold mb-6">
                    {{ $challenge->title }}
                </h2>

                @php
                    $diffId = optional($challenge->difficulty)->id ?? 0;

                    $labels = [
                        1 => 'Makkelijk',
                        2 => 'Gemiddeld',
                        3 => 'Moeilijk',
                    ];

                    $stars = $diffId;
                    $difficultyLabel = $labels[$diffId] ?? 'Onbekend';
                @endphp

                {{-- Moeilijkheidsgraad --}}
                <div class="flex items-center gap-1 mb-4"
                     aria-label="Moeilijkheidsgraad: {{ $difficultyLabel }}, {{ $stars }} van de 3 sterren">

                    @for($i = 1; $i <= 3; $i++)
                        <span
                            class="text-xl {{ $i <= $stars ? 'text-yellow-400' : 'text-gray-300' }}"
                            aria-hidden="true">
                            ★
                        </span>
                    @endfor

                    <span class="ml-2 font-semibold">
                        {{ $difficultyLabel }}
                    </span>
                </div>

                <p class="mb-2">
                    {{ $challenge->description }}
                </p>

                <p class="mb-6 font-semibold">
                    Duur:
                    <span class="font-normal">
                        {{ $challenge->duration }}
                    </span>
                </p>

                {{-- Badge --}}
                <section class="flex items-center gap-5 bg-emerald-400 p-6 rounded-2xl"
                         aria-labelledby="badge-heading">

                    <img
                        src="{{ asset($challenge->badge->image) }}"
                        alt="Badge {{ $challenge->badge->name }}"
                        class="h-20 w-20 rounded-lg object-cover"
                    >

                    <div>
                        <h3 id="badge-heading"
                            class="text-xl font-bold">
                            {{ $challenge->badge->name }}
                        </h3>
                        <p>
                            {{ $challenge->badge->description }}
                        </p>
                    </div>
                </section>

                <div class="pt-6">
                    <a href="{{ route('dashboard') }}"
                       class="inline-block bg-yellow-400 hover:bg-yellow-500
                              text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                        Ga terug
                    </a>
                </div>

            </article>
        </section>

        {{-- Upload formulier --}}
        <section aria-labelledby="upload-heading" class="max-w-md w-full">

            <h2 id="upload-heading" class="sr-only">
                Upload bewijs voor deze uitdaging
            </h2>

            <form action="{{ route('upload.store', $challenge->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6 bg-white p-6 rounded-xl shadow">

                @csrf

                {{-- Bestand upload --}}
                <div>
                    <label for="content"
                           class="block text-sm font-medium text-gray-700 mb-2">
                        Upload een foto als bewijs
                    </label>

                    <img
                        src="https://static.vecteezy.com/system/resources/previews/016/017/372/large_2x/image-upload-free-png.png"
                        alt="Voorbeeld van een uploadafbeelding"
                        class="h-80 w-full rounded-md border object-cover mb-4"
                    >

                    <input
                        type="file"
                        name="content"
                        id="content"
                        class="block w-full text-sm text-gray-700
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-md file:border-0
                               file:text-sm file:font-semibold
                               file:bg-indigo-50 file:text-indigo-700
                               hover:file:bg-indigo-100"
                        aria-describedby="upload-hint"
                    >

                    <p id="upload-hint" class="text-sm text-gray-600 mt-1">
                        Upload een afbeelding om aan te tonen dat je de uitdaging hebt uitgevoerd.
                    </p>
                </div>

                {{-- Opslaan --}}
                <button type="submit"
                        class="inline-flex items-center px-6 py-2.5 rounded-md
                               bg-amber-300 text-black font-medium
                               hover:bg-amber-500
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Opslaan
                </button>

            </form>
        </section>

    </main>
</x-app-layout>
