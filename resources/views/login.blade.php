<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center py-8">
    <div class="w-full max-w-md mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Developer Access</h1>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('developer.login') }}" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            <div class="mb-4">
                <label for="passcode" class="block text-gray-700 font-semibold mb-2">Enter Passcode</label>
                <input type="password" name="passcode" id="passcode" class="w-full border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500" placeholder="Enter developer passcode" value="{{ old('passcode') }}">
                @error('passcode')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-600 transition w-full">Submit</button>
        </form>
    </div>
</body>
</html>