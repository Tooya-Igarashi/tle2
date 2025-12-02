<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Challenge
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-6">
        @if(session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('challenges.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Title</label>
                <input type="text" name="title" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" class="w-full border rounded p-2" rows="5" required></textarea>
            </div>

            <div>
                <label class="block font-medium">Difficulty</label>
                <select name="difficulty" class="w-full border rounded p-2">
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Points</label>
                <input type="number" name="points" class="w-full border rounded p-2" required min="0">
            </div>

            <button class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                Create Challenge
            </button>
        </form>
    </div>
</x-app-layout>
