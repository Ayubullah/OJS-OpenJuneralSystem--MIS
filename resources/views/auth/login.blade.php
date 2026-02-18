<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In - KJOS</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <style>
        * {
            font-family: 'Outfit', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-float-delayed {
            animation: float 6s ease-in-out infinite;
            animation-delay: -3s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .gradient-animated {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #5ee7df);
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
        }
        
        .pattern-dots {
            background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 40px -10px rgba(102, 126, 234, 0.5);
        }
        
        .slide-up {
            animation: slideUp 0.6s ease-out forwards;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }
    </style>
</head>
<body class="min-h-screen gradient-animated">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden pattern-dots">
            <!-- Decorative Elements -->
            <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-float-delayed"></div>
            <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-white/20 rounded-2xl rotate-45 animate-float"></div>
            <div class="absolute bottom-1/3 right-1/3 w-24 h-24 bg-white/15 rounded-full animate-float-delayed"></div>
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center px-16 xl:px-24">
                <!-- Logo -->
                <div class="mb-12 slide-up">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center border border-white/30 shadow-2xl">
                            <i data-lucide="book-open" class="w-8 h-8 text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl font-black text-white tracking-tight">KJOS</h1>
                            <p class="text-white/70 font-medium">Kardan Journal Operating System</p>
                        </div>
                    </div>
                </div>
                
                <!-- Tagline -->
                <div class="slide-up stagger-1">
                    <h2 class="text-5xl xl:text-6xl font-black text-white leading-tight mb-6">
                        Welcome<br>
                        <span class="text-white/80">Back!</span>
                    </h2>
                    <p class="text-xl text-white/70 max-w-md leading-relaxed">
                        Access your dashboard to manage journals, articles, and submissions with ease.
                    </p>
                </div>
                
                <!-- Features -->
                <div class="mt-16 space-y-6 slide-up stagger-2">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Secure Access</h3>
                            <p class="text-white/60 text-sm">Enterprise-grade security</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i data-lucide="zap" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Fast & Reliable</h3>
                            <p class="text-white/60 text-sm">Lightning-fast performance</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i data-lucide="users" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Collaborative</h3>
                            <p class="text-white/60 text-sm">Work together seamlessly</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Decoration -->
            <div class="absolute bottom-8 left-16 xl:left-24 slide-up stagger-3">
                <p class="text-white/40 text-sm">© {{ date('Y') }} KJOS. All rights reserved.</p>
            </div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-16 bg-gray-50/80 backdrop-blur-sm">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-10 text-center slide-up">
                    <div class="inline-flex items-center space-x-3">
                        <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center shadow-lg">
                            <i data-lucide="book-open" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="text-2xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">KJOS</span>
                    </div>
                </div>
                
                <!-- Form Card -->
                <div class="glass-card rounded-3xl shadow-2xl p-8 lg:p-10 border border-gray-100 slide-up stagger-1">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign In</h2>
                        <p class="text-gray-500">Enter your credentials to continue</p>
                    </div>
                    
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <div class="flex items-center">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-3"></i>
                                <p class="text-sm text-green-700">{{ session('status') }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Email -->
                        <div class="space-y-2 slide-up stagger-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                                </div>
                                <input 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    value="{{ old('email') }}"
                                    required 
                                    autofocus
                                    autocomplete="username"
                                    placeholder="name@example.com"
                                    class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 input-focus @error('email') border-red-500 bg-red-50 @enderror"
                                >
                            </div>
                            @error('email')
                                <p class="text-sm text-red-500 flex items-center mt-1">
                                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="space-y-2 slide-up stagger-3">
                            <label for="password" class="block text-sm font-semibold text-gray-700">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                                </div>
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Enter your password"
                                    class="w-full pl-12 pr-12 py-4 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 input-focus @error('password') border-red-500 bg-red-50 @enderror"
                                >
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <i data-lucide="eye" id="eyeIcon" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition-colors cursor-pointer"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-sm text-red-500 flex items-center mt-1">
                                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between slide-up stagger-4">
                            <label class="flex items-center cursor-pointer group">
                                <input 
                                    id="remember_me" 
                                    name="remember" 
                                    type="checkbox"
                                    class="w-5 h-5 rounded-md border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer"
                                >
                                <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Remember me</span>
                            </label>
                            
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="slide-up stagger-5">
                            <button 
                                type="submit"
                                class="w-full btn-gradient text-white font-semibold py-4 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center space-x-2 group"
                            >
                                <span>Sign In</span>
                                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Register Link -->
                    @if (Route::has('register'))
                        <p class="mt-8 text-center text-sm text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                Register as Author
                            </a>
                        </p>
                    @endif
                </div>
                
                <!-- Footer -->
                <p class="mt-8 text-center text-sm text-gray-500 lg:hidden">
                    © {{ date('Y') }} KJOS. All rights reserved.
                </p>
            </div>
        </div>
    </div>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Password toggle
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
        
        // Add focus animations to inputs
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-[1.02]');
                this.parentElement.style.transition = 'transform 0.2s ease';
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-[1.02]');
            });
        });
    </script>
</body>
</html>
