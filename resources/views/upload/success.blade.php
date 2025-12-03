<x-layout>

    @if('succes')
        <div class="mb-4 rounded bg-green-100 border border-green-400 text-green-800 px-4 py-2">
            <strong>upload is gelukt!</strong>   {{ session('success') }}
        </div>
    @endif


    <h1>test</h1>
    <img src="{{asset('storage/' . $photo->content)}}" alt="{{$photo->id}}" class="rounded-lg w-full object-cover">

</x-layout>
