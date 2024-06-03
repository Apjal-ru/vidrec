<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password</title>
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
            <h2 class="text-2xl font-bold mb-4 text-center">Confirm Password</h2>
            <p class="mb-4 text-sm text-gray-600 text-center">This is a secure area of the application. Please confirm your password before continuing.</p>
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 p-2 w-full border rounded" required autocomplete="current-password">
                    @error('password')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Confirm</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com/"></script>
</body>
</html>
