<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Project Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-12">
    <div class="w-full max-w-5xl mx-auto px-4">
        <!-- Header -->
        <h1 class="text-4xl font-bold text-gray-800 mb-4 text-center">Welcome to Project Feedback</h1>
        <p class="text-lg text-gray-600 mb-8 text-center max-w-2xl mx-auto">We value your input! Explore our projects below and share your feedback to help us improve our work.</p>

        <!-- Call to Action Button -->
        <div class="text-center mb-12">
            <a href="{{ route('feedback.index') }}" class="inline-block bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg hover:bg-blue-700 transition duration-200 text-lg">Share Your Feedback</a>
        </div>

        <!-- Projects Overview -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Our Projects</h2>
        @if (!empty($projects))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    <div class="bg-white shadow-md rounded-lg p-6 transition hover:shadow-lg">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $project['name'] }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $project['description'] ?? 'No description available.' }}</p>
                        <a href="{{ route('feedback.index', ['project_id' => $project['id']]) }}" class="text-blue-500 font-medium hover:underline">Give Feedback</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center">No projects available at the moment.</p>
        @endif
    </div>
</body>
</html>