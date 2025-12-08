const hasSteps = document.getElementById('hasSteps');
const stepsContainer = document.getElementById('stepsContainer');
const addStep = document.getElementById('addStep');
const stepsList = document.getElementById('stepsList');

hasSteps.addEventListener('change', () => {
    stepsContainer.classList.toggle('hidden', !hasSteps.checked);
});

let stepNumber = 1;

addStep.addEventListener('click', () => {
    const div = document.createElement('div');
    div.classList.add('border', 'p-4', 'rounded');

    div.innerHTML = `
                <label class="font-semibold">Step ${stepNumber}</label>
                <textarea name="steps[]" class="w-full border rounded p-2 mt-2" rows="3" required></textarea>
                <button type="button" class="removeStep mt-2 bg-red-500 text-white px-2 py-1 rounded">Remove</button>
            `;

    stepsList.appendChild(div);

    div.querySelector('.removeStep').addEventListener('click', () => {
        div.remove();
    });

    stepNumber++;
});
