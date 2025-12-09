<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white">Create Challenge</h2>
    </x-slot>
    <div class="max-w-6xl mx-auto px-6 pb-12 ">

        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-8">

            @if(session('success'))
                <div class="p-4 mb-6 text-green-700 bg-green-100 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 mb-6 text-red-700 bg-red-100 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('challenges.store') }}" enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                {{-- TITLE --}}
                <div>
                    <label class="font-semibold text-gray-800 block mb-1">Title</label>
                    <input name="title" value="{{ old('title') }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2 text-black shadow-sm focus:ring-green-600 focus:border-green-600"
                           required>
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <label class="font-semibold text-gray-800 block mb-1">Description</label>
                    <textarea name="description"
                              class="w-full border border-gray-300 rounded-xl px-4 py-2 text-black shadow-sm focus:ring-green-600 focus:border-green-600"
                              rows="5" required>{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DIFFICULTY --}}
                <div>
                    <label class="font-semibold text-gray-800 block mb-1">Difficulty</label>
                    <select name="difficulty_id"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 text-black shadow-sm focus:ring-green-600 focus:border-green-600">
                        @foreach($difficulties as $difficulty)
                            <option
                                value="{{ $difficulty->id }}" {{ old('difficulty_id') == $difficulty->id ? 'selected' : '' }}>
                                {{ $difficulty->difficulty }}
                            </option>
                        @endforeach
                    </select>
                    @error('difficulty_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image --}}
                <div>
                    <label class="font-semibold text-gray-800 block mb-1">Image</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-gray-700 px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- OPTIONAL BADGE --}}
                <div>
                    <label class="font-semibold text-gray-800 block mb-1">Badge</label>
                    <select name="badge_id"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 text-black shadow-sm focus:ring-green-600 focus:border-green-600">
                        <option value="">None</option>
                        @foreach($badges as $badge)
                            <option value="{{ $badge->id }}" {{ old('badge_id') == $badge->id ? 'selected' : '' }}>
                                {{ $badge->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('badge_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PUBLISHED --}}
                <div class="flex items-center">
                    <label class="font-semibold flex items-center gap-2 text-gray-800">
                        <input type="checkbox" name="published" value="1" {{ old('published') ? 'checked' : '' }}>
                        Publish immediately
                    </label>
                    @error('published')
                    <p class="text-red-500 text-sm mt-1 ml-4">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Duration --}}
                <div>
                    <label class="font-semibold text-gray-800 block mb-1">Duration (HH:MM)</label>
                    <input name="duration" type="text" value="{{ old('duration') }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2 text-black shadow-sm focus:ring-green-600 focus:border-green-600"
                           placeholder="01:30" required>
                    @error('duration')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TOGGLE FOR STEPS --}}
                <div>
                    <label class="font-semibold flex items-center gap-2 text-gray-800">
                        <input type="checkbox" id="hasSteps" {{ old('steps') ? 'checked' : '' }}>
                        This challenge has steps
                    </label>
                </div>

                {{-- STEPS CONTAINER --}}
                <div id="stepsContainer" class="{{ old('steps') ? '' : 'hidden' }} space-y-4">

                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-lg text-gray-800">Steps</h3>
                        <button type="button" id="addStep"
                                class="bg-green-500 text-black px-3 py-2 rounded-lg hover:bg-green-600 shadow-sm transition">
                            + Add Step
                        </button>
                    </div>

                    <div id="stepsList">
                        @if(old('steps'))
                            @foreach(old('steps') as $index => $step)
                                <div class="step-item border border-gray-300 p-4 rounded-xl mb-4">
                                    <div class="step-header flex justify-between items-center mb-2">
                                        <span
                                            class="step-title font-semibold text-gray-800">Step {{ $index + 1 }}</span>
                                        <button type="button"
                                                class="remove-step bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                            Remove
                                        </button>
                                    </div>
                                    <textarea name="steps[]"
                                              class="w-full border border-gray-300 rounded-xl px-3 py-2 text-black shadow-sm focus:ring-green-600 focus:border-green-600"
                                              rows="3" required>{{ $step }}</textarea>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                        Create Challenge
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const hasSteps = document.getElementById('hasSteps');
            const stepsContainer = document.getElementById('stepsContainer');
            const addStep = document.getElementById('addStep');
            const stepsList = document.getElementById('stepsList');

            // Initialize steps if old data exists
            if (hasSteps.checked) {
                stepsContainer.classList.remove('hidden');
                updateStepNumbers();
            }

            // Toggle steps visibility
            hasSteps.addEventListener('change', () => {
                stepsContainer.classList.toggle('hidden', !hasSteps.checked);
                if (!hasSteps.checked) {
                    stepsList.innerHTML = ''; // Clear steps when unchecked
                }
            });

            // Add step button
            addStep.addEventListener('click', () => {
                const stepDiv = document.createElement('div');
                stepDiv.classList.add('step-item', 'border', 'border-gray-300', 'p-4', 'rounded', 'mb-4');

                stepDiv.innerHTML = `
                    <div class="step-header flex justify-between items-center mb-2">
                        <span class="step-title font-semibold text-white"></span>
                        <button type="button" class="remove-step bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                            Remove
                        </button>
                    </div>
                    <textarea name="steps[]" class="w-full border border-gray-300 rounded p-2 text-black" rows="3" required></textarea>
                `;

                stepsList.appendChild(stepDiv);
                stepsList.setAttribute('class', 'text-white font-semibold');
                updateStepNumbers();

                // Add remove functionality
                const removeBtn = stepDiv.querySelector('.remove-step');
                removeBtn.addEventListener('click', function () {
                    this.closest('.step-item').remove();
                    updateStepNumbers();
                });
            });

            // Add remove functionality to existing steps (from old data)
            document.querySelectorAll('.remove-step').forEach(btn => {
                btn.addEventListener('click', function () {
                    this.closest('.step-item').remove();
                    updateStepNumbers();
                });
            });

            function updateStepNumbers() {
                const steps = stepsList.querySelectorAll('.step-item');
                steps.forEach((step, index) => {
                    const stepNumber = index + 1;
                    const titleSpan = step.querySelector('.step-title');
                    if (titleSpan) {
                        titleSpan.textContent = `Step ${stepNumber}`;
                    }
                });
            }
        });
    </script>

</x-app-layout>
