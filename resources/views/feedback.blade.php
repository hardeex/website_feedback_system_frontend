<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Feedback Dashboard</title>
   @include('tailwind')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4361ee',
                        secondary: '#3f37c9',
                        success: '#4cc9f0',
                        info: '#4895ef',
                        warning: '#f72585',
                        light: '#f8f9fa',
                        dark: '#212529',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }
        
        .rating-star {
            cursor: pointer;
            transition: transform 0.2s, color 0.2s;
        }
        
        .rating-star:hover {
            transform: scale(1.2);
        }
        
        .project-card {
            transition: all 0.3s ease;
            transform-origin: center;
        }
        
        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .feedback-item {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .smooth-transition {
            transition: all 0.3s ease;
        }
        
        .progress-bar {
            transition: width 1s ease-in-out;
        }
        
        /* Custom scrollbar for modal */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center py-8">
    <div class="w-full max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 p-4 bg-white rounded-xl shadow-sm">
            <div class="flex items-center">
                <div class="bg-primary p-3 rounded-lg mr-4">
                    <i class="fas fa-comment-alt text-white text-2xl"></i>
                </div>
                <a href="{{route('welcome')}}">
                    <h1 class="text-3xl font-bold text-gray-800">Project Feedback</h1>
                    <p class="text-gray-500">Share and manage project feedback</p>
                </a>
            </div>
            @if (session('developer_authenticated'))
                <form method="POST" action="{{ route('developer.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg transition flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('developer.login') }}" class="bg-primary hover:bg-secondary text-white font-medium py-2 px-4 rounded-lg transition flex items-center">
                    <i class="fas fa-lock mr-2"></i> Developer Login
                </a>
            @endif
        </div>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('feedback.index') }}" class="mb-8">
            <div class="relative flex items-center">
                <i class="fas fa-search absolute left-4 text-gray-400"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search projects..." 
                    class="w-full border-gray-200 rounded-lg py-3 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-transparent shadow-sm">
                <button type="submit" class="bg-primary text-white font-semibold py-3 px-6 rounded-lg ml-2 hover:bg-secondary transition flex items-center">
                    <span>Search</span>
                </button>
            </div>
        </form>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm flex items-start" role="alert">
                <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        @if ($errors->has('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm flex items-start" role="alert">
                <i class="fas fa-exclamation-circle text-red-500 mt-1 mr-3"></i>
                <div>{{ $errors->first('error') }}</div>
            </div>
        @endif

        <!-- Feedback Form -->
        <div class="bg-white shadow-md rounded-xl p-6 mb-8 border border-gray-100">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-plus-circle text-primary mr-2"></i> Submit New Feedback
            </h2>
            <form method="POST" action="{{ route('feedback.store') }}" id="feedbackForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="project_id" class="block text-gray-700 font-medium mb-2">Select Project</label>
                        <div class="relative">
                            <select name="project_id" id="project_id" 
                                class="w-full border-gray-200 rounded-lg p-3 focus:ring-2 focus:ring-primary focus:border-transparent appearance-none shadow-sm">
                                <option value="">Choose a project...</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project['id'] }}" {{ $selectedProjectId == $project['id'] ? 'selected' : '' }}>{{ $project['name'] }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        @error('project_id')
                            <p class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rating" class="block text-gray-700 font-medium mb-2">Rating</label>
                        <div class="flex items-center mb-2">
                            <div id="starRating" class="flex">
                                <i class="rating-star far fa-star text-2xl text-yellow-400 mr-1" data-value="1"></i>
                                <i class="rating-star far fa-star text-2xl text-yellow-400 mr-1" data-value="2"></i>
                                <i class="rating-star far fa-star text-2xl text-yellow-400 mr-1" data-value="3"></i>
                                <i class="rating-star far fa-star text-2xl text-yellow-400 mr-1" data-value="4"></i>
                                <i class="rating-star far fa-star text-2xl text-yellow-400" data-value="5"></i>
                            </div>
                            <span id="ratingText" class="ml-2 text-gray-500">(Click to rate)</span>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating') }}">
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="comment" class="block text-gray-700 font-medium mb-2">Comment</label>
                    <textarea name="comment" id="comment" rows="4" 
                        class="w-full border-gray-200 rounded-lg p-3 focus:ring-2 focus:ring-primary focus:border-transparent shadow-sm" 
                        placeholder="Share your experience with this project...">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-primary text-white font-semibold py-3 px-6 rounded-lg hover:bg-secondary transition flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i> Submit Feedback
                    </button>
                </div>
            </form>
        </div>

        <!-- Projects Summary -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-chart-bar text-primary mr-2"></i> Project Feedback Summary
        </h2>
        
        @if (!empty($projects))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    <div class="project-card bg-white shadow-md rounded-xl p-6 border border-gray-100 cursor-pointer" 
                         onclick="showFeedbackModal({{ $project['id'] }}, '{{ e($project['name']) }}')">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $project['name'] }}</h3>
                            <span class="bg-blue-100 text-primary text-xs font-semibold px-2 py-1 rounded-full">
                                {{ $projectSummaries[$project['id']]['feedback_count'] }} feedback
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($project['description'] ?? 'No description available.', 80) }}</p>
                        
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Average Rating</span>
                                <span class="text-sm font-bold text-primary">{{ $projectSummaries[$project['id']]['average_rating'] ?: '0' }}/5</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-primary h-2 rounded-full progress-bar" 
                                     style="width: {{ ($projectSummaries[$project['id']]['average_rating'] / 5) * 100 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                            <span class="text-primary font-medium text-sm hover:underline">View feedback</span>
                            <i class="fas fa-chevron-right text-primary text-sm"></i>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white shadow-md rounded-xl p-8 text-center">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-700 mb-2">No projects found</h3>
                <p class="text-gray-500">There are no projects to display at the moment.</p>
            </div>
        @endif
    </div>

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-3xl mx-4 max-h-[90vh] overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 id="modalTitle" class="text-xl font-semibold text-gray-800"></h3>
                <button onclick="closeFeedbackModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="feedbackList" class="p-6 overflow-y-auto custom-scrollbar flex-grow">
                <!-- Feedback items will be loaded here -->
            </div>
            
            <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                <button onclick="closeFeedbackModal()" class="bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Enhanced star rating functionality
        const stars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('ratingInput');
        const ratingText = document.getElementById('ratingText');
        let currentRating = 0;
        
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = parseInt(star.getAttribute('data-value'));
                currentRating = value;
                ratingInput.value = value;
                updateStars(value);
                ratingText.textContent = `(${value}/5)`;
            });
            
            star.addEventListener('mouseover', () => {
                const value = parseInt(star.getAttribute('data-value'));
                updateStars(value, true);
            });
            
            star.addEventListener('mouseout', () => {
                updateStars(currentRating);
            });
        });
        
        function updateStars(rating, isHover = false) {
            stars.forEach(star => {
                const value = parseInt(star.getAttribute('data-value'));
                if (value <= rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                    star.style.color = isHover ? '#fbbf24' : '#f59e0b';
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                    star.style.color = '#d1d5db';
                }
            });
        }
        
        // Initialize stars if there's an existing value
        if (ratingInput.value) {
            currentRating = parseInt(ratingInput.value);
            updateStars(currentRating);
            ratingText.textContent = `(${currentRating}/5)`;
        }

        // JavaScript function to escape strings
        function escapeString(str) {
            if (!str) return '';
            return str.replace(/'/g, "\\'").replace(/"/g, '\\"').replace(/\\/g, '\\\\');
        }

        // Modal functionality
        const modal = document.getElementById('feedbackModal');
        
        async function showFeedbackModal(projectId, projectName) {
            const modalTitle = document.getElementById('modalTitle');
            const feedbackList = document.getElementById('feedbackList');

            modalTitle.textContent = `Feedback for ${projectName}`;
            feedbackList.innerHTML = `
                <div class="flex justify-center items-center h-40">
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin text-primary text-2xl mb-2"></i>
                        <p class="text-gray-500">Loading feedback...</p>
                    </div>
                </div>
            `;

            // Show modal with transition
            modal.classList.remove('pointer-events-none');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                modal.classList.remove('opacity-0');
            }, 10);

            try {
                const headers = {
                    'Accept': 'application/json',
                    @if (session('developer_authenticated'))
                        'X-Developer-Passcode': '{{ config('api.developer_passcode') }}'
                    @endif
                };

                const response = await fetch(`{{ config('api.backend_url') }}/projects/${projectId}/feedback`, {
                    method: 'GET',
                    headers: headers
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(`Failed to fetch feedback: ${response.status} ${response.statusText}`);
                }

                const data = await response.json();
                const feedbacks = data.data || [];

                if (feedbacks.length === 0) {
                    feedbackList.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-comment-slash text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-700 mb-2">No feedback yet</h3>
                            <p class="text-gray-500">This project doesn't have any feedback yet.</p>
                        </div>
                    `;
                    return;
                }

                feedbackList.innerHTML = feedbacks.map((feedback, index) => `
                    <div class="feedback-item border border-gray-100 rounded-lg p-4 mb-4 shadow-sm" style="animation-delay: ${index * 0.05}s">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center">
                                ${generateStarRating(feedback.rating)}
                                <span class="ml-2 text-sm font-medium text-gray-700">${feedback.rating}/5</span>
                            </div>
                            <span class="text-xs text-gray-500">${new Date(feedback.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</span>
                        </div>
                        
                        <p class="text-gray-700 mb-3">${escapeHTML(feedback.comment)}</p>
                        
                        <div class="flex justify-between items-center">
                            <span class="status-badge ${getStatusClass(feedback.status)}">${feedback.status}</span>
                            
                            @if (session('developer_authenticated'))
                            <button onclick="showResponseForm(${feedback.id}, '${escapeString(feedback.comment)}')" 
                                class="text-primary hover:text-secondary text-sm font-medium flex items-center">
                                <i class="fas fa-reply mr-1"></i> Respond
                            </button>
                            @endif
                        </div>
                        
                        ${feedback.developer_response ? `
                            <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-code text-blue-500 mr-2"></i>
                                    <span class="text-sm font-medium text-blue-800">Developer Response</span>
                                </div>
                                <p class="text-blue-700">${escapeHTML(feedback.developer_response)}</p>
                            </div>
                        ` : ''}
                        
                        @if (session('developer_authenticated'))
                        <div id="responseForm-${feedback.id}" class="hidden mt-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <form onsubmit="submitResponse(event, ${feedback.id}, ${projectId}, '${escapeString(projectName)}')">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="passcode" value="{{ config('api.developer_passcode') }}">
                                
                                <div class="mb-3">
                                    <label for="developer_response-${feedback.id}" class="block text-gray-700 font-medium mb-1 text-sm">Developer Response</label>
                                    <textarea id="developer_response-${feedback.id}" name="developer_response" rows="3" 
                                        class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-primary focus:border-transparent text-sm" 
                                        placeholder="Enter your response here...">${feedback.developer_response || ''}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status-${feedback.id}" class="block text-gray-700 font-medium mb-1 text-sm">Status</label>
                                    <div class="relative">
                                        <select id="status-${feedback.id}" name="status" 
                                            class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-primary focus:border-transparent appearance-none text-sm">
                                            <option value="Not Started" ${feedback.status === 'Not Started' ? 'selected' : ''}>Not Started</option>
                                            <option value="In Progress" ${feedback.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                                            <option value="Fixed" ${feedback.status === 'Fixed' ? 'selected' : ''}>Fixed</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="hideResponseForm(${feedback.id})" 
                                        class="bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg text-sm hover:bg-gray-300 transition">
                                        Cancel
                                    </button>
                                    <button type="submit" 
                                        class="bg-primary text-white font-medium py-2 px-4 rounded-lg text-sm hover:bg-secondary transition flex items-center">
                                        <i class="fas fa-check mr-1"></i> Submit Response
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                `).join('');
            } catch (error) {
                console.error('Error in showFeedbackModal:', error);
                feedbackList.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-700">
                        <div class="flex items-center mb-1">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span class="font-medium">Error loading feedback</span>
                        </div>
                        <p class="text-sm">${error.message}</p>
                    </div>
                `;
            }
        }

        function generateStarRating(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    stars += `<i class="fas fa-star text-yellow-400 text-sm"></i>`;
                } else {
                    stars += `<i class="far fa-star text-yellow-400 text-sm"></i>`;
                }
            }
            return `<div class="flex">${stars}</div>`;
        }

        function getStatusClass(status) {
            switch(status) {
                case 'Fixed': return 'bg-green-100 text-green-800';
                case 'In Progress': return 'bg-yellow-100 text-yellow-800';
                default: return 'bg-gray-100 text-gray-800';
            }
        }

        function escapeHTML(str) {
            if (!str) return '';
            return str
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
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
                        'Accept': 'application/json',
                        'X-Developer-Passcode': passcode
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
                console.error('Error in submitResponse:', error);
                alert('Error submitting response: ' + error.message);
            }
        }

        function closeFeedbackModal() {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('pointer-events-none');
            }, 300);
        }

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeFeedbackModal();
            }
        });

        // Initialize progress bar animations
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                // Trigger animation
                setTimeout(() => {
                    bar.style.width = bar.style.width;
                }, 100);
            });
        });
    </script>
</body>
</html>