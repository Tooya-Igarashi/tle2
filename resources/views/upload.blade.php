<x-layout>
    <h1> dit is upload page</h1>


    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
            <input type="file" name="content" id="content" class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700  hover:file:bg-indigo-100">
        </div>

        <button type="submit" class="inline-flex items-center px-6 py-2.5 rounded-md bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Save
        </button>
    </form>

</x-layout>
