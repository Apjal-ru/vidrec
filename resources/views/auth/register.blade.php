<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h2 class="text-2xl font-bold mb-4 text-center">Want to save your recording?</h2>
            <p class="text-center mb-4">Make a new account</p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 p-2 w-full border rounded" value="{{ old('email') }}" required autocomplete="username">
                    @error('email')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 p-2 w-full border rounded" required autocomplete="new-password">
                    @error('password')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 p-2 w-full border rounded" required autocomplete="new-password">
                    @error('password_confirmation')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Register</button>
            </form>
            <p class="mt-4 text-center">Already have an account? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Sign In</a></p>
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
