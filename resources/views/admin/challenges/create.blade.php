<x-app-layout>

    {{-- Header --}}
    <header role="banner">
        <x-slot name="header">
            Challenge aanmaken
        </x-slot>

        <x-slot name="headerDescription">
            Maak jouw eigen uitdaging aan
        </x-slot>
    </header>

    <main id="main" role="main" class="max-w-6xl mx-auto px-6 pb-12">

        <section class="bg-white border border-gray-200 rounded-2xl shadow-md p-8"
                 aria-labelledby="form-heading">

            <h2 id="form-heading" class="sr-only">
                Formulier om een nieuwe uitdaging aan te maken
            </h2>

            {{-- Succesmelding --}}
            @if(session('success'))
                <div class="p-4 mb-6 text-green-700 bg-green-100 rounded"
                     role="status">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Foutmeldingen --}}
            @if($errors->any())
                <div class="p-4 mb-6 text-red-700 bg-red-100 rounded"
                     role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('challenges.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-6">

                @csrf

                {{-- Titel --}}
                <div>
                    <label for="title" class="font-semibold text-gray-800 block mb-1">
                        Titel
                    </label>
                    <input id="title"
                           name="title"
                           value="{{ old('title') }}"
                           required
                           class="w-full border border-gray-300 rounded-xl px-4 py-2 text-black shadow-sm
                                  focus:ring-green-600 focus:border-green-600">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschrijving --}}
                <div>
                    <label for="description" class="font-semibold text-gray-800 block mb-1">
                        Beschrijving
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="5"
                              required
                              class="w-full border border-gray-300 rounded-xl px-4 py-2 text-black shadow-sm
                                     focus:ring-green-600 focus:border-green-600">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Moeilijkheidsgraad --}}
                <div>
                    <label for="difficulty_id" class="font-semibold text-gray-800 block mb-1">
                        Moeilijkheidsgraad
                    </label>
                    <select id="difficulty_id"
                            name="difficulty_id"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 text-black shadow-sm
                                   focus:ring-green-600 focus:border-green-600">
                        @foreach($difficulties as $difficulty)
                            <option value="{{ $difficulty->id }}"
                                {{ old('difficulty_id') == $difficulty->id ? 'selected' : '' }}>
                                {{ $difficulty->difficulty }}
                            </option>
                        @endforeach
                    </select>
                    @error('difficulty_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Afbeelding --}}
                <div>
                    <label for="image" class="font-semibold text-gray-800 block mb-1">
                        Afbeelding
                    </label>
                    <input id="image"
                           type="file"
                           name="image"
                           accept="image/*"
                           class="w-full text-gray-700 px-3 py-2 border border-gray-300 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-green-600">
                    @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Badge (optioneel) --}}
                <div>
                    <label for="badge_id" class="font-semibold text-gray-800 block mb-1">
                        Badge (optioneel)
                    </label>
                    <select id="badge_id"
                            name="badge_id"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 text-black shadow-sm
                                   focus:ring-green-600 focus:border-green-600">
                        <option value="">Geen badge</option>
                        @foreach($badges as $badge)
                            <option value="{{ $badge->id }}"
                                {{ old('badge_id') == $badge->id ? 'selected' : '' }}>
                                {{ $badge->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('badge_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Publiceren --}}
                <div class="flex items-center">
                    <label for="published" class="font-semibold flex items-center gap-2 text-gray-800">
                        <input id="published"
                               type="checkbox"
                               name="published"
                               value="1"
                            {{ old('published') ? 'checked' : '' }}>
                        Direct publiceren
                    </label>
                </div>

                {{-- Duur --}}
                <div>
                    <label for="duration" class="font-semibold text-gray-800 block mb-1">
                        Duur (UU:MM)
                    </label>
                    <input id="duration"
                           name="duration"
                           type="text"
                           value="{{ old('duration') }}"
                           placeholder="01:30"
                           required
                           class="w-full border border-gray-300 rounded-xl px-4 py-2 text-black shadow-sm
                                  focus:ring-green-600 focus:border-green-600">
                    @error('duration')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stappen aan/uit --}}
                <div>
                    <label for="hasSteps" class="font-semibold flex items-center gap-2 text-gray-800">
                        <input id="hasSteps" type="checkbox" {{ old('steps') ? 'checked' : '' }}>
                        Deze uitdaging heeft stappen
                    </label>
                </div>

                {{-- Stappen --}}
                <div id="stepsContainer"
                     class="{{ old('steps') ? '' : 'hidden' }} space-y-4"
                     aria-live="polite">

                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-lg text-gray-800">
                            Stappen
                        </h3>
                        <button type="button"
                                id="addStep"
                                class="bg-green-500 text-black px-3 py-2 rounded-lg hover:bg-green-600 shadow-sm transition">
                            Stap toevoegen
                        </button>
                    </div>

                    <div id="stepsList">
                        @if(old('steps'))
                            @foreach(old('steps') as $index => $step)
                                <div class="step-item border border-gray-300 p-4 rounded-xl mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="step-title font-semibold text-gray-800">
                                            Stap {{ $index + 1 }}
                                        </span>
                                        <button type="button"
                                                class="remove-step bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                            Verwijderen
                                        </button>
                                    </div>
                                    <textarea name="steps[]"
                                              rows="3"
                                              required
                                              class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black shadow-sm
                                                     focus:ring-green-600 focus:border-green-600">{{ $step }}</textarea>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Verzenden --}}
                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold
                                   px-6 py-3 rounded-lg shadow-lg transition">
                        Challenge aanmaken
                    </button>
                </div>

            </form>
        </section>

    </main>

</x-app-layout>
