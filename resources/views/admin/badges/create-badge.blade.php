<x-app-layout>
    <x-slot name="header">
        Create Badge
    </x-slot>
    <x-slot name="headerDescription">
        Maak een badge aan voor gebruikers om te verdienen
    </x-slot>

    <div class="max-w-6xl mx-auto px-6 pb-12 ">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-8">

            @if(session('success'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-4 text-red-700 bg-red-100 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('badges.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block font-medium text-black">Title</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full border border-gray-300 rounded p-2 text-black" required>
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium text-black">Description</label>
                    <textarea name="description" class="w-full border border-gray-300 rounded p-2 text-black"
                              rows="5" required>{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium text-black">Image</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-gray-700 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">

                    Create Badge
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
