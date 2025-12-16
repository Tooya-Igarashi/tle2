<x-app-layout>
    {{--    <x-header> upload jouw challenge</x-header>--}}

    <div class=" bg-white flex flex-col md:flex-row gap-20 justify-center pb-20">
        <div class="bg-emerald-500 p-14 rounded-2xl ">
            <div class="pb-10">
                <h1 class="text-2xl font-semibold mb-6">{{ $challenge->title }}</h1>
                <p>
                @php
                    $difficulty = $challenge->difficulty->difficulty ?? 'Onbekend';

                    $stars = match($difficulty) {
                        'Easy' => 1,
                        'Medium' => 2,
                        'Hard' => 3,
                        default => 0
                    };
                @endphp

                <div class="flex" aria-label="difficulty {{$challenge->difficulty->difficulty}}">
                    @for($i = 1; $i <= 3; $i++)
                        <span class="text-xl {{ $i <= $stars ? 'text-yellow-400' : 'text-gray-300' }}"
                              aria-hidden="true">★</span>
                    @endfor
                </div>
                <p></p>

                <p>{{ $challenge->description }}</p>
                <p>{{$challenge->duration}}</p>

            </div>

            <div class="flex flex-row items-center gap-5 bg-emerald-400 p-6 rounded-2xl pt-4">
                <img src="{{asset($challenge->badge->image)}}" alt="{{$challenge->badge->name}} badge"
                     class="h-20 rounded-lg  object-cover">


                <div>
                    <p class="text-2xl font-bold">{{$challenge->badge->name}}</p>
                    <p>{{$challenge->badge->description}}</p>
                </div>
            </div>
            <div class="pt-3">
                <a href="{{ route('dashboard') }}"
                   class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">Ga
                    terug</a>
            </div>


        </div>
        <div>
            <form action="{{ route('upload.store', $challenge->id) }}" method="POST" enctype="multipart/form-data"
                  class="space-y-6 bg-white p-6 rounded-xl shadow">
                @csrf

                {{--                    <img src="https://static.vecteezy.com/system/resources/previews/016/017/372/large_2x/image-upload-free-png.png"  class="h-80 rounded-md border object-cover">--}}
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1"> <img alt="upload foto hier"
                        src="https://static.vecteezy.com/system/resources/previews/016/017/372/large_2x/image-upload-free-png.png"
                        class="h-80 rounded-md border object-cover"></label>

                <div class="flex-row gap-4 ">


                    <button type="button" onclick="document.getElementById('content').click()"
                            class="inline-flex items-center px-6 py-2.5 rounded-md bg-amber-300 text-black font-medium hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Upload
                    </button>
                    <input type="file" name="content" id="content"
                           class=" hidden block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700  hover:file:bg-indigo-100">

                    <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 rounded-md bg-amber-300 text-black font-medium hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
