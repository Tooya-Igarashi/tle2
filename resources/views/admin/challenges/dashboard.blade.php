        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<main>
    <table class="mx-auto">
        <thead>
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Description</th>
            <th class="px-4 py-2">Time</th>
            <th class="px-4 py-2">Difficulty</th>
            <th class="px-4 py-2">Badge</th>
            <th class="px-4 py-2">Created At</th>
            <th class="px-4 py-2">Updated At</th>
            <th class="px-4 py-2">Details</th>
            <th class="px-4 py-2">Validate</th>
            <th class="px-4 py-2">Edit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($challenge as $challenges)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $challenges->id }}</td>
                <td class="px-4 py-2">{{ $challenges->title }}</td>
                <td class="px-4 py-2">{{ Str::limit($challenges->description, 50) }}</td>
                <td class="px-4 py-2">{{ $challenges->duration }}</td>
                <td class="px-4 py-2">{{ optional($challenges->difficulty)->difficulty }}</td>
                <td class="px-4 py-2">{{ $challenges->badge_id }}</td>
                <td class="px-4 py-2">{{ $challenges->created_at->format('D-M-Y') }}</td>
                <td class="px-4 py-2">{{ $challenges->updated_at->format('D-M-Y') }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('challenges.show', $challenges->id) }}"
                       class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                        Details &gt;
                    </a>
                </td>
                <td class="px-4 py-2">
                <form method="POST" action="{{ route('admin.authenticate', $challenges->id) }}" class="mt-4">
                    @csrf
                    @method('PATCH')
                    @if($challenges->published === 0)
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            Authenticate
                        </button>
                    @elseif($challenges->published === 1)
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            Unauthenticate
                        </button>
                    @endif
                </form>
                </td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.edit', $challenges->id) }}"
                       class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                        Edit
                    </a>
                </td>
{{--                placeholder delete action--}}

                {{--                <td class="px-4 py-2">--}}
{{--                    <form method="POST" action="#">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>--}}
{{--                    </form>--}}
{{--                </td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
</body>
</html>
