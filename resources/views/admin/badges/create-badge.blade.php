<x-app-layout>

    {{-- Header --}}
    <header role="banner">
        <x-slot name="header">
                Badge aanmaken
        </x-slot>

        <x-slot name="headerDescription">
            Maak een badge aan die gebruikers kunnen verdienen
        </x-slot>
    </header>

    <main id="main" role="main" class="max-w-6xl mx-auto px-6 pb-12">

        <section class="bg-white border border-gray-200 rounded-2xl shadow-md p-8"
                 aria-labelledby="badge-form-heading">

            <h2 id="badge-form-heading" class="sr-only">
                Formulier om een nieuwe badge aan te maken
            </h2>

            {{-- Succesmelding --}}
            @if(session('success'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 rounded"
                     role="status">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Foutmelding --}}
            @if(session('error'))
                <div class="p-4 mb-4 text-red-700 bg-red-100 rounded"
                     role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST"
                  action="{{ route('badges.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-6">

                @csrf

                {{-- Titel --}}
                <div>
                    <label for="name" class="block font-medium text-black mb-1">
                        Titel
                    </label>
                    <input id="name"
                           type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           class="w-full border border-gray-300 rounded p-2 text-black
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschrijving --}}
                <div>
                    <label for="description" class="block font-medium text-black mb-1">
                        Beschrijving
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="5"
                              required
                              class="w-full border border-gray-300 rounded p-2 text-black
                                     focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Afbeelding --}}
                <div>
                    <label for="image" class="block font-medium text-black mb-1">
                        Afbeelding
                    </label>
                    <input id="image"
                           type="file"
                           name="image"
                           accept="image/*"
                           class="w-full text-gray-700 px-3 py-2 border border-gray-300 rounded-md
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Verzenden --}}
                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold
                                   px-6 py-3 rounded-lg shadow-lg transition">
                        Badge aanmaken
                    </button>
                </div>

            </form>
        </section>

    </main>

</x-app-layout>
