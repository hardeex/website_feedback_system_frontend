<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-8">
    <div class="w-full max-w-5xl mx-auto px-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-gray-800">Project Feedback</h1>
            @if (session('developer_authenticated'))
                <form method="POST" action="{{ route('developer.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-blue-500 font-medium hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('developer.login') }}" class="text-blue-500 font-medium hover:underline">Developer Login</a>
            @endif
        </div>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('feedback.index') }}" class="mb-8">
            <div class="flex">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search projects..." class="w-full border-gray-300 rounded-l-md p-2 focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-r-md hover:bg-blue-600 transition">Search</button>
            </div>
        </form>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                {{ $errors->first('error') }}
            </div>
        @endif

        <!-- Feedback Form -->
        <form method="POST" action="{{ route('feedback.store') }}" class="bg-white shadow-md rounded-lg p-6 mb-8">
            @csrf
            <div class="mb-4">
                <label for="project_id" class="block text-gray-700 font-semibold mb-2">Select Project</label>
                <select name="project_id" id="project_id" class="w-full border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Choose a project...</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project['id'] }}" {{ $selectedProjectId == $project['id'] ? 'selected' : '' }}>{{ $project['name'] }}</option>
                    @endforeach
                </select>
                @error('project_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="rating" class="block text-gray-700 font-semibold mb-2">Rating (1-5)</label>
                <input type="number" name="rating" id="rating" min="1" max="5" value="{{ old('rating') }}" class="w-full border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500" placeholder="Enter rating (1-5)">
                @error('rating')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="comment" class="block text-gray-700 font-semibold mb-2">Comment</label>
                <textarea name="comment" id="comment" rows="4" class="w-full border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500" placeholder="Enter your feedback">{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-600 transition">Submit Feedback</button>
        </form>

        <!-- Projects Summary -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Project Feedback Summary</h2>
        @if (!empty($projects))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    <div class="bg-white shadow-md rounded-lg p-6 transition hover:shadow-lg">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $project['name'] }}</h3>
                        <p class="text-gray-600 mb-2">{{ $project['description'] ?? 'No description available.' }}</p>
                        <p class="text-gray-600 mb-2">
                            <span class="font-semibold">Average Rating:</span> {{ $projectSummaries[$project['id']]['average_rating'] ?: 'N/A' }}/5
                        </p>
                        <p class="text-gray-600 mb-4">
                            <span class="font-semibold">Feedback Count:</span> {{ $projectSummaries[$project['id']]['feedback_count'] }}
                        </p>
                        <button onclick="showFeedbackModal({{ $project['id'] }}, '{{ addslashes($project['name']) }}')" class="text-blue-500 font-medium hover:underline">View Feedback</button>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center">No projects found.</p>
        @endif
    </div>

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-[80vh] overflow-y-auto">
            <h3 id="modalTitle" class="text-xl font-semibold text-gray-800 mb-4"></h3>
            <div id="feedbackList" class="space-y-4"></div>
            <button onclick="closeFeedbackModal()" class="mt-4 bg-gray-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-gray-600 transition">Close</button>
        </div>
    </div>

    <script>
        async function showFeedbackModal(projectId, projectName) {
            const modal = document.getElementById('feedbackModal');
            const modalTitle = document.getElementById('modalTitle');
            const feedbackList = document.getElementById('feedbackList');

            modalTitle.textContent = `Feedback for ${projectName}`;
            feedbackList.innerHTML = '<p class="text-gray-500">Loading...</p>';

            try {
                const response = await fetch(`{{ config('api.backend_url') }}/projects/${projectId}/feedback`);
                if (!response.ok) throw new Error('Failed to fetch feedback');
                const data = await response.json();
                const feedbacks = data.data || [];

                feedbackList.innerHTML = feedbacks.length
                    ? feedbacks.map(feedback => `
                        <div class="border-l-4 border-blue-500 pl-4 mb-4">
                            <p class="text-gray-600"><span class="font-semibold">Rating:</span> ${feedback.rating}/5</p>
                            <p class="text-gray-600"><span class="font-semibold">Comment:</span> ${feedback.comment}</p>
                            ${feedback.developer_response ? `<p class="text-gray-600"><span class="font-semibold">Developer Response:</span> ${feedback.developer_response}</p>` : ''}
                            <p class="text-gray-600"><span class="font-semibold">Status:</span> 
                                <span class="${feedback.status === 'Fixed' ? 'bg-green-100 text-green-800' : feedback.status === 'In Progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'} inline-block px-2 py-1 rounded text-sm">${feedback.status}</span>
                            </p>
                            <p class="text-gray-500 text-sm">Posted on ${new Date(feedback.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</p>
                            @if (session('developer_authenticated'))
                            <button onclick="showResponseForm(${feedback.id}, '${addslashes(feedback.comment)}')" class="mt-2 text-blue-500 font-medium hover:underline">Respond</button>
                            <div id="responseForm-${feedback.id}" class="hidden mt-2">
                                <form onsubmit="submitResponse(event, ${feedback.id}, ${projectId}, '${projectName}')">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="passcode" value="{{ config('api.developer_passcode') }}">
                                    <div class="mb-2">
                                        <label for="developer_response-${feedback.id}" class="block text-gray-700 font-semibold">Developer Response</label>
                                        <textarea id="developer_response-${feedback.id}" name="developer_response" rows="3" class="w-full border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500" placeholder="Enter your response"></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label for="status-${feedback.id}" class="block text-gray-700 font-semibold">Status</label>
                                        <select id="status-${feedback.id}" name="status" class="w-full border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">
                                            <option value="Not Started">Not Started</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Fixed">Fixed</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="bg-blue-500 text-white font-semibold py-1 px-3 rounded-md hover:bg-blue-600 transition">Submit Response</button>
                                    <button type="button" onclick="hideResponseForm(${feedback.id})" class="ml-2 bg-gray-300 text-gray-800 font-semibold py-1 px-3 rounded-md hover:bg-gray-400 transition">Cancel</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    `).join('')
                    : '<p class="text-gray-500">No feedback yet for this project.</p>';

                modal.classList.remove('hidden');
            } catch (error) {
                feedbackList.innerHTML = '<p class="text-red-500">Error loading feedback.</p>';
                modal.classList.remove('hidden');
            }
        }

        function showResponseForm(feedbackId, comment) {
            document.getElementById(`responseForm-${feedbackId}`).classList.remove('hidden');
        }

        function hideResponseForm(feedbackId) {
            document.getElementById(`responseForm-${feedbackId}`).classList.add('hidden');
        }

        async function submitResponse(event, feedbackId, projectId, projectName) {
            event.preventDefault();
            const form = event.target;
            const developerResponse = form.querySelector(`#developer_response-${feedbackId}`).value;
            const status = form.querySelector(`#status-${feedbackId}`).value;
            const token = form.querySelector('input[name="_token"]').value;
            const passcode = form.querySelector('input[name="passcode"]').value;

            try {
                const response = await fetch(`{{ config('api.backend_url') }}/feedback/${feedbackId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        developer_response: developerResponse,
                        status: status,
                        passcode: passcode
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Failed to submit response');
                }

                // Refresh the modal
                showFeedbackModal(projectId, projectName);
            } catch (error) {
                alert('Error submitting response: ' + error.message);
            }
        }

        function closeFeedbackModal() {
            document.getElementById('feedbackModal').classList.add('hidden');
        }
    </script>
</body>
</html>