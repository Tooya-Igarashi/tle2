@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'block w-full ps-3 pe-4 py-2
           border-l-4 border-sky-600
           text-start text-base font-medium
           text-sky-900
           bg-sky-300
           focus:outline-none
           focus:text-sky-950
           focus:bg-sky-400
           focus:border-sky-700
           transition duration-150 ease-in-out'

        : 'block w-full ps-3 pe-4 py-2
           border-l-4 border-transparent
           text-start text-base font-medium
           text-sky-900
           bg-white
           hover:bg-sky-300
           hover:text-sky-950
           hover:border-sky-600
           focus:outline-none
           focus:bg-sky-400
           focus:text-sky-950
           focus:border-sky-700
           transition duration-150 ease-in-out';

@endphp


<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

