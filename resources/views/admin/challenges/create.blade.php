<x-app-layout class="text-white">
    <x-slot name="header">
        <h2 class="text-xl font-bold">Create Challenge</h2>
    </x-slot>
    @vite('resources/js/app.js')
    <div class="max-w-4xl mx-auto p-6">

        <form method="POST" action="{{ route('challenges.store') }}" class="space-y-6">
            @csrf

            {{-- TITLE --}}
            <div>
                <label class="font-semibold text-white">Title</label>
                <input name="title" class="w-full border rounded p-2" required>
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="font-semibold text-white">Description</label>
                <textarea name="description" class="w-full border rounded p-2" rows="5" required></textarea>
            </div>

            {{-- DIFFICULTY --}}
            <div>
                <label class="font-semibold text-white">Difficulty</label>
                <select name="difficulty_id" class="w-full border rounded p-2">
                    @foreach($difficulties as $difficulty)
                        <option value="{{ $difficulty->id }}">{{ $difficulty->difficulty }}</option>
                    @endforeach
                </select>
            </div>

            {{-- OPTIONAL BADGE --}}
            <div>
                <label class="font-semibold text-white">Badge</label>
                <select name="badge_id" class="w-full border rounded p-2">
                    <option value="">None</option>
                    @foreach($badges as $badge)
                        <option value="{{ $badge->id }}">{{ $badge->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- PUBLISHED --}}
            <div>
                <label class="font-semibold flex items-center gap-2 text-white">
                    <input type="checkbox" name="published" value="1"> Publish
                </label>
            </div>

            {{-- Duration --}}
            <div>
                <label class="font-semibold text-white">Duration (HH:MM:SS)</label>
                <input name="duration" type="text" class="w-full border rounded p-2" placeholder="01:30:00" required>
            </div>


            {{-- TOGGLE FOR STEPS --}}
            <div>
                <label class="font-semibold flex items-center gap-2">
                    <input type="checkbox" id="hasSteps">
                    This challenge has steps
                </label>
            </div>


            {{-- STEPS CONTAINER --}}
            <div id="stepsContainer" class="hidden space-y-4">

                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-lg text-white">Steps</h3>
                    <button type="button" id="addStep" class="bg-green-500 text-white px-3 py-2 rounded">
                        + Add Step
                    </button>
                </div>

                <div id="stepsList"></div>
            </div>


            {{-- SUBMIT --}}
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Create Challenge
            </button>

        </form>
    </div>

</x-app-layout>
