<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Login</title>
    @include('feedback')
    <style>
        @keyframes slideInFromTop {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInFromBottom {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
            50% { box-shadow: 0 0 30px rgba(59, 130, 246, 0.6); }
        }
        
        @keyframes matrix {
            0% { opacity: 0; transform: translateY(-20px); }
            50% { opacity: 1; }
            100% { opacity: 0; transform: translateY(20px); }
        }
        
        .slide-in-top { animation: slideInFromTop 0.8s ease-out; }
        .slide-in-bottom { animation: slideInFromBottom 0.8s ease-out; }
        .float { animation: float 3s ease-in-out infinite; }
        .pulse-glow { animation: pulse 2s ease-in-out infinite; }
        .glow-effect { animation: glow 3s ease-in-out infinite; }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .cyber-grid {
            background-image: 
                linear-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        
        .matrix-bg {
            position: absolute;
            font-family: 'Courier New', monospace;
            color: rgba(59, 130, 246, 0.3);
            font-size: 12px;
            animation: matrix 4s linear infinite;
        }
        
        .input-focus {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
        }
        
        .btn-cyber {
            background: linear-gradient(45deg, #3b82f6, #1d4ed8);
            position: relative;
            overflow: hidden;
        }
        
        .btn-cyber::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-cyber:hover::before {
            left: 100%;
        }
        
        .security-indicator {
            position: relative;
        }
        
        .security-indicator::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -30px;
            width: 20px;
            height: 20px;
            border: 2px solid #10b981;
            border-radius: 50%;
            transform: translateY(-50%);
            animation: pulse 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 cyber-grid opacity-20"></div>
    
    <!-- Matrix Effect -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="matrix-bg" style="top: 10%; left: 10%;">01101001</div>
        <div class="matrix-bg" style="top: 30%; left: 80%; animation-delay: 1s;">11010110</div>
        <div class="matrix-bg" style="top: 60%; left: 20%; animation-delay: 2s;">10011010</div>
        <div class="matrix-bg" style="top: 80%; left: 70%; animation-delay: 3s;">01110100</div>
    </div>
    
    <!-- Floating Orbs -->
    <div class="absolute top-20 left-20 w-32 h-32 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 float" style="animation-delay: 0s;"></div>
    <div class="absolute top-40 right-20 w-32 h-32 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 float" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-20 left-40 w-32 h-32 bg-cyan-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 float" style="animation-delay: 4s;"></div>

    <div class="relative z-10 min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <!-- Header Section -->
            <div class="text-center mb-8 slide-in-top">
                <div class="relative inline-block mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center float glow-effect">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center pulse-glow">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-4xl font-bold text-white mb-4">Developer Access</h1>
                <p class="text-blue-200">Secure portal for authorized developers</p>
                
                <!-- Security Features -->
                <div class="flex justify-center space-x-6 mt-6 text-sm">
                    <div class="flex items-center space-x-2 text-blue-300">
                        <div class="w-2 h-2 bg-green-400 rounded-full pulse-glow"></div>
                        <span>Encrypted</span>
                    </div>
                    <div class="flex items-center space-x-2 text-blue-300">
                        <div class="w-2 h-2 bg-green-400 rounded-full pulse-glow"></div>
                        <span>Verified</span>
                    </div>
                    <div class="flex items-center space-x-2 text-blue-300">
                        <div class="w-2 h-2 bg-green-400 rounded-full pulse-glow"></div>
                        <span>Protected</span>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            @if (session('success'))
                <div class="glass-effect rounded-xl p-4 mb-6 border-l-4 border-green-400 slide-in-bottom">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-green-100 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="glass-effect rounded-xl p-4 mb-6 border-l-4 border-red-400 slide-in-bottom">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-red-100 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('developer.login') }}" class="glass-effect rounded-2xl p-8 shadow-2xl slide-in-bottom" style="animation-delay: 0.3s;">
                @csrf
                
                <!-- Form Header -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-white mb-2">Authentication Required</h2>
                    <p class="text-blue-200 text-sm">Enter your developer passcode to continue</p>
                </div>

                <!-- Passcode Input -->
                <div class="mb-6">
                    <label for="passcode" class="block text-blue-200 font-semibold mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                        Developer Passcode
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="passcode" 
                            id="passcode" 
                            class="w-full bg-white/10 border border-white/20 rounded-xl p-4 text-white placeholder-blue-300 focus:ring-2 focus:ring-blue-400 focus:border-transparent input-focus backdrop-blur-sm" 
                            placeholder="Enter your secure passcode" 
                            value="{{ old('passcode') }}"
                            autocomplete="current-password"
                        >
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <button type="button" onclick="togglePasswordVisibility()" class="text-blue-300 hover:text-blue-200 transition-colors">
                                <svg id="eye-closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414L8.464 8.464m5.656 5.656l1.414 1.414m-1.414-1.414l1.414 1.414M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <svg id="eye-open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('passcode')
                        <div class="mt-2 flex items-center text-red-400 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Security Info -->
                <div class="mb-6 p-4 bg-blue-900/30 rounded-xl border border-blue-400/30">
                    <div class="flex items-center text-blue-200 text-sm">
                        <svg class="w-5 h-5 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <div>
                            <p class="font-medium">Secure Authentication</p>
                            <p class="text-xs text-blue-300 mt-1">Your connection is encrypted and monitored</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="btn-cyber w-full text-white font-bold py-4 px-6 rounded-xl hover:scale-105 transition-all duration-300 transform focus:outline-none focus:ring-4 focus:ring-blue-400 relative"
                    id="submitBtn"
                >
                    <span class="relative z-10 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span id="btnText">Access Developer Portal</span>
                        <div id="loadingSpinner" class="hidden ml-3">
                            <div class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                        </div>
                    </span>
                </button>

                <!-- Additional Info -->
                <div class="mt-6 text-center">
                    <p class="text-blue-300 text-sm">
                        Need access? Contact your system administrator
                    </p>
                </div>
            </form>

            <!-- Footer -->
            <div class="text-center mt-8 slide-in-bottom" style="animation-delay: 0.6s;">
                <div class="flex items-center justify-center space-x-4 text-blue-400 text-sm">
                    <div class="flex items-center space-x-1">
                        <div class="w-2 h-2 bg-green-400 rounded-full pulse-glow"></div>
                        <span>System Status: Online</span>
                    </div>
                    <div class="w-1 h-4 bg-blue-400/30"></div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>SSL Protected</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('passcode');
            const eyeClosed = document.getElementById('eye-closed');
            const eyeOpen = document.getElementById('eye-open');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeClosed.classList.add('hidden');
                eyeOpen.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeClosed.classList.remove('hidden');
                eyeOpen.classList.add('hidden');
            }
        }

        // Form submission handling
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            
            // Show loading state
            btnText.textContent = 'Authenticating...';
            loadingSpinner.classList.remove('hidden');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        });

        // Add floating animation to input on focus
        const passcodeInput = document.getElementById('passcode');
        passcodeInput.addEventListener('focus', function() {
            this.parentElement.classList.add('transform', '-translate-y-1');
        });
        
        passcodeInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('transform', '-translate-y-1');
        });

        // Keyboard shortcut for form submission (Ctrl/Cmd + Enter)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                document.querySelector('form').submit();
            }
        });

        // Add subtle parallax effect to floating orbs
        document.addEventListener('mousemove', function(e) {
            const orbs = document.querySelectorAll('.float');
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;
            
            orbs.forEach((orb, index) => {
                const speed = (index + 1) * 0.5;
                const x = mouseX * speed;
                const y = mouseY * speed;
                orb.style.transform = `translate(${x}px, ${y}px)`;
            });
        });

        // Auto-focus passcode input when page loads
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.getElementById('passcode').focus();
            }, 1000);
        });

        // Add ripple effect to button
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            const button = e.target;
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            const ripple = document.createElement('div');
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            button.style.position = 'relative';
            button.style.overflow = 'hidden';
            button.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>