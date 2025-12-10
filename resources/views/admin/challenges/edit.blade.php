<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Challenge</title>
</head>
<body>
{{-- Debug - keep this to see what data we have --}}

<form method="POST" action="{{ route('admin.update', $challenge->id) }}" enctype="multipart/form-data" id="challenge-edit-form">
    @csrf
    @method('PATCH')

    <div>
        <label>Title</label>
        <input name="title" value="{{ $challenge->title ?? '' }}" required>
    </div>

    <div>
        <label>Description</label>
        <textarea name="description" required>{{ $challenge->description ?? '' }}</textarea>
    </div>

    <div>
        <label>Duration (HH:MM)</label>
        <input name="duration" value="{{ $challenge->duration ?? '' }}" required>
    </div>

    <div>
        <label>Difficulty</label>
        <select name="difficulty_id" required>
            @foreach($difficulties as $difficulty)
                <option value="{{ $difficulty->id }}"
                    @selected($difficulty->id == ($challenge->difficulty_id ?? ''))>
                    {{ $difficulty->difficulty }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Badge</label>
        <select name="badge_id">
            <option value="">-- none --</option>
            @foreach($badges as $b)
                <option value="{{ $b->id }}"
                    @selected($b->id == ($challenge->badge_id ?? ''))>
                    {{ $b->name ?? 'Badge '.$b->id }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Published</label>
        <input type="checkbox" name="published" value="1"
            @checked($challenge->published ?? false)>
    </div>

    <div>
        <label>Image (optional)</label>
        <input type="file" name="image_path" accept="image/*">
        @if($challenge->image_path ?? false)
            <div>Current: <img src="{{ $challenge->image_path }}" style="max-height:80px"></div>
        @endif
    </div>

    <hr>

    <h3>Steps</h3>
    <p>Use Up/Down to reorder. Delete to remove. Add to create a new step.</p>

    <ul id="steps-list" style="list-style:none;padding:0;">
        @php $i = 0; @endphp
        @foreach(($challenge->steps ?? collect())->sortBy('step_number') as $step)
            <li class="step-item" data-step-id="{{ $step->id }}">
                <div style="display:flex;gap:8px;align-items:center;">
                    <span class="step-order">{{ $step->step_number }}</span>.
                    <input type="hidden" name="steps[{{ $i }}][id]" value="{{ $step->id }}">
                    <input type="hidden" name="steps[{{ $i }}][order]" value="{{ $step->step_number }}" class="step-order-input">
                    <textarea name="steps[{{ $i }}][content]" class="step-content" required>{{ $step->step_description }}</textarea>

                    <button type="button" class="move-up">Up</button>
                    <button type="button" class="move-down">Down</button>
                    <button type="button" class="remove-step">Delete</button>
                </div>
            </li>
            @php $i++; @endphp
        @endforeach
    </ul>

    <input type="hidden" name="steps_to_delete[]" id="steps-to-delete">

    <button type="button" id="add-step">Add step</button>

    <div>
        <button type="submit">Save changes</button>
        <a href="{{ route('admin.dashboard') }}">Cancel</a>
    </div>
</form>

<script>
    // Your JavaScript remains the same
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
            li.className = 'step-item';
            if (id) li.dataset.stepId = id;

            li.innerHTML = `
            <div style="display:flex;gap:8px;align-items:center;">
                <span class="step-order"></span>.
                ${ id ? `<input type="hidden" name="" value="${id}">` : '' }
                <input type="hidden" name="" value="" class="step-order-input">
                <textarea name="" class="step-content" required>${content}</textarea>
                <button type="button" class="move-up">Up</button>
                <button type="button" class="move-down">Down</button>
                <button type="button" class="remove-step">Delete</button>
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
                    // append id to steps_to_delete (comma separated)
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

        // On submit, ensure steps inputs are properly indexed and set hidden steps_to_delete as array-like input
        form.addEventListener('submit', () => {
            reindex();
            // convert steps_to_delete comma string into multiple inputs if needed
            const val = stepsToDeleteInput.value;
            if (val) {
                // remove current hidden and create one per id
                stepsToDeleteInput.removeAttribute('name'); // clear name so we can recreate
                const ids = val.split(',').filter(Boolean);
                ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'steps_to_delete[]';
                    input.value = id;
                    form.appendChild(input);
                });
            } else {
                // remove placeholder
                stepsToDeleteInput.remove();
            }
        });

        // initial index
        reindex();
    })();
</script>
</body>
</html>
