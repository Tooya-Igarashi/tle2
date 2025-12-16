<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="min-h-screen flex flex-col bg-white">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-green-200 shadow-lg mb-5">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl md:text-4xl font-bold text-black mb-4 leading-tight justify-center">
                    {{ $header }}
                </h1>

                @isset($headerDescription)
                    <p class="text-black text-lg md:text-xl max-w-3xl mb-6">
                        {{ $headerDescription }}
                    </p>
                @endisset
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <footer class="bg-sky-300 border-t border-sky-400 shadow-md ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">

            <div class="flex flex-col md:flex-row items-center justify-between gap-4">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img
                            src="{{ asset('images/BeverLogo.png') }}"
                            alt="Logo Bever"
                            class="h-10 w-auto drop-shadow-lg"
                        >
                    </a>
                </div>

                <!-- Links -->
                <div class="flex flex-wrap justify-center bg-white/90 px-4 py-2 rounded-2xl shadow-sm gap-4">
                    <a href="https://www.natuurmonumenten.nl/"
                       class="text-black pb-0.5 border-b-2 border-transparent hover:border-black">
                        Natuurmonumenten
                    </a>
                    <a href="https://www.natuurmonumenten.nl/disclaimer"
                       class="text-black pb-0.5 border-b-2 border-transparent hover:border-black">
                        Disclaimer
                    </a>
                    <a href="https://www.natuurmonumenten.nl/uw-privacy"
                       class="text-black pb-0.5 border-b-2 border-transparent hover:border-black">
                        Privacy
                    </a>
                    <a href="https://www.natuurmonumenten.nl/cookies"
                       class="text-black pb-0.5 border-b-2 border-transparent hover:border-black">
                        Cookies
                    </a>
                    <a href="https://www.natuurmonumenten.nl/algemene-voorwaarden"
                       class="text-black pb-0.5 border-b-2 border-transparent hover:border-black">
                        Voorwaarden
                    </a>
                    <a href="https://www.natuurmonumenten.nl/toegankelijkheidsverklaring"
                       class="text-black pb-0.5 border-b-2 border-transparent hover:border-black">
                        Toegankelijkheid
                    </a>
                </div>
            </div>

            <p class="text-center text-black/80 text-xs mt-2">
                © {{ date('Y') }} Eco Explorer
            </p>
        </div>
    </footer>

</div>
</body>
</html>
