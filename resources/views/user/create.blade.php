<x-app-layout>
    <x-slot name="header">
        Maak een nieuwe challenge aan
    </x-slot>
    <div class="max-w-6xl mx-auto px-6 pb-20 ">

        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-8">
            @if(session('success'))
                <div class="p-4 mb-6 text-green-700 bg-green-100 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 mb-6 text-red-700 bg-red-100 rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                {{-- TITLE --}}
                <div>
                    <label class="font-semibold text-black">Titel</label>
                    <input name="title" value="{{ old('title') }}"
                           class="w-full border border-gray-300 rounded p-2 text-black" required>
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <label class="font-semibold text-black">Beschrijven</label>
                    <textarea name="description" class="w-full border border-gray-300 rounded p-2 text-black" rows="5"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DIFFICULTY --}}
                <div>
                    <label class="font-semibold text-black">Moeilijkheid</label>
                    <select name="difficulty_id" class="w-full border border-gray-300 rounded p-2 text-black">
                        @foreach($difficulties as $difficulty)
                            <option
                                value="{{ $difficulty->id }}" {{ old('difficulty_id') == $difficulty->id ? 'selected' : '' }}>
                                @if($difficulty->difficulty === 'Easy')
                                    <span class="text-yellow-400' : 'text-gray-300'">(Easy) ★</span>
                                @elseif($difficulty->difficulty === 'Medium')
                                    <span class="text-yellow-400' : 'text-gray-300' }}">(Medium) ★★</span>
                                @else
                                    <span class="text-yellow-400' : 'text-gray-300' }}">(Hard) ★★★</span>
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('difficulty_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image --}}
                <div>
                    <label class="font-semibold text-black">Foto</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-white px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- OPTIONAL BADGE --}}
                <div>
                    <label class="font-semibold text-black">Badge</label>
                    <select name="badge_id" class="w-full border border-gray-300 rounded p-2 text-black">
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

                {{-- Duration --}}
                <div>
                    <label class="font-semibold text-black">Hoe lang duurt dit? (Uren:Minuten)</label>
                    <input name="duration" type="text" value="{{ old('duration') }}"
                           class="w-full border border-gray-300 rounded p-2 text-black" placeholder="01:30" required>
                    @error('duration')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TOGGLE FOR STEPS --}}
                <div>
                    <label class="font-semibold flex items-center gap-2 text-black">
                        <input type="checkbox" id="hasSteps" {{ old('steps') ? 'checked' : '' }}>
                        Heeft deze challenge stappen om te volgen?
                    </label>
                </div>

                {{-- STEPS CONTAINER --}}
                <div id="stepsContainer" class="{{ old('steps') ? '' : 'hidden' }} space-y-4">

                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-lg text-black">Stappen</h3>
                        <button type="button" id="addStep"
                                class="bg-green-500 text-black px-3 py-2 rounded hover:bg-green-600 transition">
                            + Voeg een stap toe
                        </button>
                    </div>

                    <div id="stepsList">
                        @if(old('steps'))
                            @foreach(old('steps') as $index => $step)
                                <div class="step-item border border-gray-300 p-4 rounded mb-4">
                                    <div class="step-header flex justify-between items-center mb-2">
                                        <span class="step-title font-semibold text-black">Stap {{ $index + 1 }}</span>
                                        <button type="button"
                                                class="remove-step bg-red-500 text-black px-3 py-1 rounded hover:bg-red-600 transition">
                                            Remove
                                        </button>
                                    </div>
                                    <textarea name="steps[]"
                                              class="w-full border border-gray-300 rounded p-2 text-black"
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
                            Verwijder stap
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
                        titleSpan.textContent = `Stap ${stepNumber}`;
                    }
                });
            }
        });
    </script>

</x-app-layout>
