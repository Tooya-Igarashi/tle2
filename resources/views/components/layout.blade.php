<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
{{--    @vite(['resources/css/app.css', 'resources/js/app.js'])--}}

    <title>Document</title>
</head>

<header>
    <nav class="flex p-4 gap-2 text-base font-medium ">
        <img src="" alt="logo">

        @if (Route::has('login'))
            @auth

                <a href="{{ route('dashboard') }}"> Home</a>

                @if(auth()->user()->role)
                    <li>
                        {{--                    <a href="{{route('admin.index')}}"--}}
                        {{--                       class="flex py-2 text-base font-medium text-body-color hover:text-dark lg:ml-12 lg:inline-flex dark:text-dark-6 dark:hover:text-black">--}}
                        {{--                        Admin overview--}}
                        {{--                    </a>--}}
                    </li>
                @endif

                <a href="">dropdown</a>
                <div class="">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class=""> Log Out </button>
                    </form>
                </div>

            @else
    </nav>
</header>


<div class="">
    <a href="{{route('login')}}" class="">Login </a>

    @if (Route::has('register'))
        <a href="{{route('register')}}" class="">Sign Up </a>
    @endif
</div>
@endauth
@endif
</nav>

<body>

<main>
    {{ $slot }}
</main>

</body>

<footer class="flex p-4 gap-2 text-base font-medium bg-neutral-400">
    <a href=""> link</a>
    <a href=""> link</a>
    <img src="" alt="logo">
</footer>
</html>
