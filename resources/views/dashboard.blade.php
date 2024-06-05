<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recording App</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .flex-col {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>

<body class="bg-green-100">
    <div class="bg-green-500 p-4 flex justify-between items-center">
        <div class="flex items-center">
            <div class="w-8 h-8 text-white">
                <a>VidRec</a>
            </div>
        </div>
        <div class="text-white flex space-x-4">
            <a href="#" class="hover:underline">About</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:underline">Log Out</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow flex items-center justify-center">
        <div class="flex-grow flex items-center justify-center flex-col">
            <div class="text-center">
                <!-- Description -->
                <p class="text-xl">VidRec</p>

                <!-- Record Button -->
                <a href="{{ route('record') }}">
                    <button id="recordButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Let's Record
                    </button>
                </a>

                <!-- My Videos Button -->
                <a href="{{ route('my-videos') }}">
                    <button id="myVideosButton" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded mt-4">
                        My Videos
                    </button>
                </a>
            </div>
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
