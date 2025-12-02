<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if(Auth::check())
                Welkom, {{Auth::user()->name}}
            @else
                Welkom!
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Help jij de natuur?") }}
                </div>
            </div>
        </div>
    </div>

    {{--    Zoekbalk & Filter--}}
    <div>
        <form method="GET" action="{{ route('dashboard') }}">
            @csrf

            <div>
                <label for="search">Zoek Challenge</label>

                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       placeholder="Zoek challenge">
            </div>
        </form>
    </div>

    {{-- Kolom challenges --}}
    <h2>
        Challenges
    </h2>
    <div>

        <div>
            @forelse($challenges as $challenge)
                <div>
                    {{ $challenge->title }}
                </div>

                <p>
                    {{ Str::limit($challenge->description, 120) }}
                </p>
        </div>
        @empty
            <p>
                Er zijn nog geen challenges.
            </p>
        @endforelse
    </div>

</x-app-layout>
