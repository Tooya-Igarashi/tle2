<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-white">
            Create Badge
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-6">
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

        <form method="POST" action="{{ route('badges.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-white">Title</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded p-2 text-black" required>
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-white">Description</label>
                <textarea name="description" class="w-full border border-gray-300 rounded p-2 text-black"
                          rows="5" required>{{ old('description') }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-white">Image</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full text-gray-700 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-200">
                Create Badge
            </button>
        </form>
    </div>
</x-app-layout>
