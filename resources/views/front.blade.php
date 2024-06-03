<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Recorder</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
        </div>
    </div>
    <div class="flex flex-col items-center justify-center h-screen">
        <div class="flex items-center">
            <div class="mr-8">
                <h1 class="text-4xl font-bold mb-4">Record your video online</h1>
                <p class="mb-4">Everywhere, anywhere with just one click</p>
                <div class="flex space-x-4 align-left">
                    <a href="{{route('record')}}">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">Record</button>
                    </a>
                    <a href="{{ route('login') }}">
                        <button class="bg-green-500 text-white px-4 py-2 rounded">Login</button>
                    </a>
                </div>
            </div>
            <div class="ml-8">
                <svg width="371" height="371" viewBox="0 0 471 471" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M67.6527 397.34C40.5562 397.34 18.5901 375.375 18.5901 348.277V122.714C18.5901 95.6173 40.556 73.6512 67.6527 73.6512H297.542C324.639 73.6512 346.605 95.6173 346.605 122.714V172.758L407.896 136.213C427.519 124.513 452.409 138.651 452.409 161.497V309.557C452.409 332.402 427.519 346.542 407.896 334.842L346.605 298.296V348.277C346.605 375.375 324.639 397.34 297.542 397.34H67.6527ZM127.089 247.518C123.872 240.053 115.213 236.609 107.747 239.825C100.282 243.042 96.838 251.702 100.055 259.168C113.813 291.096 145.58 313.492 182.611 313.492C219.643 313.492 251.41 291.096 265.167 259.168C268.386 251.702 264.941 243.042 257.476 239.825C250.011 236.609 241.35 240.053 238.134 247.518C228.861 269.037 207.474 284.054 182.611 284.054C157.749 284.054 136.362 269.037 127.089 247.518ZM117.635 201.29C130.061 201.29 140.135 191.217 140.135 178.791C140.135 166.364 130.061 156.291 117.635 156.291C105.209 156.291 95.1353 166.364 95.1353 178.791C95.1353 191.217 105.209 201.29 117.635 201.29ZM270.073 178.791C270.073 191.217 260 201.29 247.573 201.29C235.147 201.29 225.075 191.217 225.075 178.791C225.075 166.364 235.147 156.291 247.573 156.291C260 156.291 270.073 166.364 270.073 178.791Z" fill="#2E3ECD"/>
                </svg>
            </svg>
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
