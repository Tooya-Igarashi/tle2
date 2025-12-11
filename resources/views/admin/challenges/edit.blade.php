<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-black leading-tight">
            Edit Challenge
        </h1>
    </x-slot>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-2xl shadow-md p-8 py-12">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops!</strong>
                            <span class="block sm:inline">There were some problems with your input.</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.update', $challenge->id) }}" enctype="multipart/form-data" id="challenge-edit-form" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Title -->
                        <div>
                            <label class="font-semibold text-gray-800 block mb-1">Title</label>
                            <x-text-input id="title" name="title" type="text"
                                          class="w-full !bg-white border border-gray-300 rounded-xl px-4 py-2 !text-black shadow-sm focus:ring-green-600 focus:border-green-600"
                                          value="{{ old('title', $challenge->title) }}" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="font-semibold text-gray-800 block mb-1">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="w-full border border-gray-300 rounded-xl px-4 py-2 text-black shadow-sm focus:ring-green-600 focus:border-green-600"
                                      required>{{ old('description', $challenge->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="font-semibold text-gray-800 block mb-1">Duration HH:MM</label>
                            <x-text-input id="duration" name="duration" type="text" class="w-full border border-gray-300 rounded-xl px-4 py-2 !bg-white !text-black shadow-sm focus:ring-green-600 focus:border-green-600"
                                          value="{{ old('duration', $challenge->duration) }}"
                                          placeholder="00:15" required />
                            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                        </div>

                        <!-- Difficulty -->
                        <div>
                            <label class="font-semibold text-gray-800 block mb-1">Difficulty</label>
                            <select id="difficulty_id" name="difficulty_id"
                                    class="w-full !bg-white border border-gray-300 rounded-xl px-4 py-2 !text-black shadow-sm focus:ring-green-600 focus:border-green-600"
                                    required>
                                @foreach($difficulties as $difficulty)
                                    <option value="{{ $difficulty->id }}"
                                        {{ $difficulty->id == old('difficulty_id', $challenge->difficulty_id) ? 'selected' : '' }}>
                                        {{ $difficulty->difficulty }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('difficulty_id')" class="mt-2" />
                        </div>

                        <!-- Badge -->
                        <div>
                            <label class="font-semibold text-gray-800 block mb-1">Badge</label>
                            <select id="badge_id" name="badge_id"
                                    class="w-full !bg-white border border-gray-300 rounded-xl px-4 py-2 !text-black shadow-sm focus:ring-green-600 focus:border-green-600">
                                @foreach($badges as $b)
                                    <option value="{{ $b->id }}"
                                        {{ $b->id == old('badge_id', $challenge->badge_id) ? 'selected' : '' }}>
                                        {{ $b->name ?? 'Badge ' . $b->id }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('badge_id')" class="mt-2" />
                        </div>

                        <!-- Published -->
                        <div class="flex items-center">
                            <label class="font-semibold text-gray-800 block mb-1 mr-4">Published</label>
                            <input id="published" name="published" type="checkbox" value="1"
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                {{ old('published', $challenge->published) ? 'checked' : '' }} />
                        </div>

                        <!-- Image -->
                        <div>
                            <label class="font-semibold text-gray-800 block mb-1">Image</label>
                            <input id="image_path" name="image_path" type="file" accept="image/*"
                                   class="mt-1 block w-full text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />

                            @if($challenge->image_path)
                                <div class="mt-2">
                                    <label class="font-semibold text-gray-800 block mb-1">Current Image</label>
                                    <img src="{{ $challenge->image_path }}" alt="Current challenge image"
                                         class="max-h-40 rounded-lg shadow">
                                </div>
                            @endif
                            <x-input-error :messages="$errors->get('image_path')" class="mt-2" />
                        </div>

                        <hr class="border-gray-300 my-8">

                        <!-- Steps Section -->
                        <div>
                            <h3 class="text-lg font-medium !text-black mb-2">Steps</h3>
                            <p class="text-sm !text-black mb-4">
                                Use Up/Down to reorder. Delete to remove. Add to create a new step.
                            </p>

                            <ul id="steps-list" class="space-y-4">
                                @php $i = 0; @endphp
                                @foreach(($challenge->steps ?? collect())->sortBy('step_number') as $step)
                                    <li class="step-item p-4 bg-gray-50 rounded-lg border border-gray-200"
                                        data-step-id="{{ $step->id }}">
                                        <div class="flex items-start gap-4">
                                            <div class="flex flex-col items-center">
                                                <span class="step-order font-bold text-gray-700">{{ $step->step_number }}</span>
                                                <div class="flex flex-col mt-2">
                                                    <button type="button" class="move-up p-1 text-gray-500 hover:text-gray-700">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" class="move-down p-1 text-gray-500 hover:text-gray-700">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <input type="hidden" name="steps[{{ $i }}][id]" value="{{ $step->id }}">
                                            <input type="hidden" name="steps[{{ $i }}][order]" value="{{ $step->step_number }}" class="step-order-input">

                                            <div class="flex-1">
                                                <textarea name="steps[{{ $i }}][content]"
                                                          class="step-content w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                          rows="3" required>{{ $step->step_description }}</textarea>
                                            </div>

                                            <button type="button" class="remove-step text-red-600 hover:text-red-800 p-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </li>
                                    @php $i++; @endphp
                                @endforeach
                            </ul>

                            <input type="hidden" name="steps_to_delete[]" id="steps-to-delete">

                            <button type="button" id="add-step"
                                    class="mt-4 bg-green-500 text-black px-3 py-2 rounded-lg hover:bg-green-600 shadow-sm transition">

                                Add New Step
                            </button>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-300">
                            <a href="{{ route('admin.dashboard') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

    <script>
        (function(){
            const list = document.getElementById('steps-list');
            const addBtn = document.getElementById('add-step');
            const form = document.getElementById('challenge-edit-form');
            const stepsToDeleteInput = document.querySelector('input[name="steps_to_delete[]"]');

            function reindex() {
                const items = Array.from(list.querySelectorAll('.step-item'));
                items.forEach((li, idx) => {
                    const orderSpan = li.querySelector('.step-order');
                    const orderInput = li.querySelector('.step-order-input');
                    const contentInput = li.querySelector('.step-content');

                    orderSpan.textContent = idx + 1;
                    orderInput.name = `steps[${idx}][order]`;
                    orderInput.value = idx + 1;

                    // ensure content and id names updated
                    const idInput = li.querySelector('input[name^="steps"][type="hidden"]');
                    const contentName = `steps[${idx}][content]`;
                    contentInput.name = contentName;

                    if (idInput) {
                        idInput.name = `steps[${idx}][id]`;
                    }
                });
            }

            function createStepElement(id = '', content = '') {
                const li = document.createElement('li');
                li.className = 'step-item p-4 bg-gray-50 rounded-lg border border-gray-200';
                if (id) li.dataset.stepId = id;

                li.innerHTML = `
                    <div class="flex items-start gap-4">
                        <div class="flex flex-col items-center">
                            <span class="step-order font-bold" style="color: black !important;"></span>
                            <div class="flex flex-col mt-2">
                                <button type="button" class="move-up p-1" style="color: #4b5563 !important;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>
                                <button type="button" class="move-down p-1" style="color: #4b5563 !important;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        ${ id ? `<input type="hidden" name="" value="${id}">` : '' }
                        <input type="hidden" name="" value="" class="step-order-input">

                        <div class="flex-1">
                            <textarea name="" class="step-content w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" style="color: black !important;"
                                      rows="3" required>${content}</textarea>
                        </div>

                        <button type="button" class="remove-step p-2" style="color: #dc2626 !important;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                `;
                attachStepControls(li);
                return li;
            }

            function attachStepControls(li) {
                li.querySelector('.move-up').addEventListener('click', () => {
                    const prev = li.previousElementSibling;
                    if (prev) list.insertBefore(li, prev);
                    reindex();
                });
                li.querySelector('.move-down').addEventListener('click', () => {
                    const next = li.nextElementSibling;
                    if (next) list.insertBefore(next, li);
                    reindex();
                });
                li.querySelector('.remove-step').addEventListener('click', () => {
                    const id = li.dataset.stepId;
                    if (id) {
                        const current = stepsToDeleteInput.value || '';
                        stepsToDeleteInput.value = current ? current + ',' + id : id;
                    }
                    li.remove();
                    reindex();
                });
            }

            // Attach controls to existing items
            Array.from(list.querySelectorAll('.step-item')).forEach(attachStepControls);

            addBtn.addEventListener('click', () => {
                const newEl = createStepElement('', '');
                list.appendChild(newEl);
                reindex();
            });

            // On submit, ensure steps inputs are properly indexed
            form.addEventListener('submit', () => {
                reindex();
                const val = stepsToDeleteInput.value;
                if (val) {
                    stepsToDeleteInput.removeAttribute('name');
                    const ids = val.split(',').filter(Boolean);
                    ids.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'steps_to_delete[]';
                        input.value = id;
                        form.appendChild(input);
                    });
                } else {
                    stepsToDeleteInput.remove();
                }
            });

            // initial index
            reindex();
        })();
    </script>
</x-app-layout>
