<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Videos</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <header class="bg-green-500 text-white py-4 px-6">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">VidRec</h1>
            <div>
                <a href="#" class="text-white">Account</a>
            </div>
        </div>
    </header>

    <div class="container mx-auto mt-6">
        <a href="{{ route('record') }}" class="text-lg text-gray-700 mb-4 block">&lt; Back to Recorder</a>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($videos as $video)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <video width="100%" height="auto" controls>
                        <source src="{{ asset('storage/' . $video->path) }}" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                    <div class="mt-4 flex justify-between items-center">
                        <form action="{{ route('videos.delete', $video->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-red-600 focus:outline-none">Delete</button>
                        </form>
                        <a href="{{ asset('storage/' . $video->path) }}" download="{{ $video->name }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-blue-600 focus:outline-none">Download</a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $videos->links() }}
        </div>
    </div>
    <script src="https://cdn.tailwindcss.com/"></script>
    <script>
        // Initialization for ES Users
        import {
            Dropdown,
            Collapse,
            initMDB
        } from "mdb-ui-kit";
        initMDB({
            Dropdown,
            Collapse
        });
    </script>
</body>

</html>
