<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Project Feedback</title>
    @include('tailwind')
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        .fade-in-up { animation: fadeInUp 0.8s ease-out; }
        .float { animation: float 3s ease-in-out infinite; }
        .pulse-glow { animation: pulse 2s ease-in-out infinite; }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .shimmer-btn {
            background: linear-gradient(90deg, #3b82f6, #1d4ed8, #3b82f6);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }
        
        .project-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .project-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .project-card:hover::before {
            left: 100%;
        }
        
        .project-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .stats-counter {
            font-feature-settings: 'tnum';
        }
        
        .typing-effect {
            border-right: 2px solid #3b82f6;
            animation: blink 1s infinite;
        }
        
        @keyframes blink {
            0%, 50% { border-color: transparent; }
            51%, 100% { border-color: #3b82f6; }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 relative overflow-x-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-20 left-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-8 left-40 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <div class="relative z-10 w-full max-w-6xl mx-auto px-4 py-12">
        <!-- Navigation Bar -->
        <nav class="glass-effect rounded-2xl p-4 mb-12 fade-in-up">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center float">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Project Feedback
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-600">
                        <div class="w-2 h-2 bg-green-400 rounded-full pulse-glow"></div>
                        <span>System Online</span>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="text-center mb-16 fade-in-up" style="animation-delay: 0.2s;">
            <div class="mb-8">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6">
                    <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 bg-clip-text text-transparent">
                        Welcome to
                    </span>
                    <br>
                    <span id="typewriter" class="text-gray-800 typing-effect">Project Feedback</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Your voice matters! Join our community and help shape the future of our projects with your valuable insights and feedback.
                </p>
            </div>

            <!-- Interactive Stats -->
            <div class="flex flex-wrap justify-center gap-8 mb-12">
                <div class="glass-effect rounded-2xl p-6 min-w-[120px] transform hover:scale-105 transition-all duration-300">
                    <div class="text-3xl font-bold text-blue-600 stats-counter" data-count="{{ count($projects ?? []) }}">0</div>
                    <div class="text-sm text-gray-600">Active Projects</div>
                </div>
                <div class="glass-effect rounded-2xl p-6 min-w-[120px] transform hover:scale-105 transition-all duration-300">
                    <div class="text-3xl font-bold text-purple-600 stats-counter" data-count="500">0</div>
                    <div class="text-sm text-gray-600">Community Members</div>
                </div>
                <div class="glass-effect rounded-2xl p-6 min-w-[120px] transform hover:scale-105 transition-all duration-300">
                    <div class="text-3xl font-bold text-green-600 stats-counter" data-count="1250">0</div>
                    <div class="text-sm text-gray-600">Feedback Collected</div>
                </div>
            </div>

            <!-- Enhanced CTA Button -->
            <div class="mb-16">
                <a href="{{ route('feedback.index') }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 rounded-2xl overflow-hidden">
                    <span class="absolute inset-0 shimmer-btn"></span>
                    <span class="relative flex items-center space-x-3">
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span>Share Your Feedback</span>
                    </span>
                </a>
            </div>
        </div>

        <!-- Projects Section -->
        <div class="fade-in-up" style="animation-delay: 0.4s;">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Discover Our Projects</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Explore our innovative projects and help us make them even better with your feedback
                </p>
            </div>

            @if (!empty($projects))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($projects as $index => $project)
                        <div class="project-card bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 fade-in-up" style="animation-delay: {{ 0.1 * $index + 0.6 }}s;">
                            <!-- Project Icon -->
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 float">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $project['name'] }}</h3>
                            <p class="text-gray-600 mb-6 line-clamp-3">
                                {{ $project['description'] ?? 'An innovative project designed to enhance user experience and deliver exceptional value.' }}
                            </p>
                            
                            <!-- Project Status -->
                            <div class="flex items-center justify-between mb-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2 pulse-glow"></div>
                                    Active
                                </span>
                                <div class="flex items-center space-x-1 text-yellow-500">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            
                            <a href="{{ route('feedback.index', ['project_id' => $project['id']]) }}" class="group inline-flex items-center justify-center w-full px-6 py-3 text-sm font-semibold text-blue-600 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-600 hover:text-white transition-all duration-300">
                                <span>Give Feedback</span>
                                <svg class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No Projects Available</h3>
                    <p class="text-gray-500">New projects are coming soon. Check back later!</p>
                </div>
            @endif
        </div>

        <!-- Footer CTA -->
        <div class="text-center mt-20 fade-in-up" style="animation-delay: 0.8s;">
            <div class="glass-effect rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Ready to Make an Impact?</h3>
                <p class="text-gray-600 mb-6">Your feedback drives innovation. Join thousands of users helping us build better products.</p>
                <a href="{{ route('feedback.index') }}" class="inline-flex items-center px-6 py-3 text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-300">
                    Get Started Now
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Typewriter Effect
        function typeWriter(text, element, speed = 100) {
            let i = 0;
            element.textContent = '';
            element.classList.add('typing-effect');
            
            function type() {
                if (i < text.length) {
                    element.textContent += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                } else {
                    element.classList.remove('typing-effect');
                }
            }
            type();
        }

        // Counter Animation
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16);
            
            function updateCounter() {
                start += increment;
                if (start < target) {
                    element.textContent = Math.floor(start);
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            }
            updateCounter();
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('stats-counter')) {
                        const target = parseInt(entry.target.dataset.count);
                        animateCounter(entry.target, target);
                    }
                }
            });
        }, observerOptions);

        // Initialize animations when DOM loads
        document.addEventListener('DOMContentLoaded', function() {
            // Start typewriter effect
            const typewriterElement = document.getElementById('typewriter');
            if (typewriterElement) {
                setTimeout(() => {
                    typeWriter('Project Feedback', typewriterElement, 150);
                }, 1000);
            }

            // Observe counter elements
            document.querySelectorAll('.stats-counter').forEach(counter => {
                observer.observe(counter);
            });

            // Add stagger animation to project cards
            const projectCards = document.querySelectorAll('.project-card');
            projectCards.forEach((card, index) => {
                card.style.animationDelay = `${0.1 * index + 0.6}s`;
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>