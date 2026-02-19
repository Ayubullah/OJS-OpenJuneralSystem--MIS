<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'KJOS Editorial Assistant Dashboard')</title>

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Backdrop blur support */
        .backdrop-blur-glass {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* Smooth slide animations */
        .slide-enter {
            transform: translateX(-100%);
            opacity: 0;
        }

        .slide-enter-active {
            transform: translateX(0);
            opacity: 1;
            transition: all 0.3s ease-in-out;
        }

        /* Glassmorphism effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Modern button hover effects */
        .btn-modern {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-modern:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Pulse animation for notifications */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse-slow {
            animation: pulse 2s infinite;
        }
        
        /* Rotate transition for chevron */
        .rotate-180 {
            transform: rotate(180deg);
        }
        
        /* Modern submenu active indicator */
        .submenu-item {
            position: relative;
            transition: all 0.2s ease;
        }
        
        .submenu-item.active {
            background: rgba(99, 102, 241, 0.08);
            border-left: 3px solid #6366f1;
        }
        
        .submenu-item.active::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            background: #6366f1;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.6);
            animation: pulse-dot 1.8s infinite;
        }
        
        @keyframes pulse-dot {
            0%, 100% {
                opacity: 1;
                transform: translateY(-50%) scale(1);
            }
            50% {
                opacity: 0.7;
                transform: translateY(-50%) scale(1.2);
            }
        }
        
        .submenu-item.active .submenu-icon {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .submenu-item.active .submenu-icon i {
            color: white;
        }
        
        .submenu-item.active span {
            color: #111827;
            font-weight: 600;
        }
        
        .submenu-item.active a {
            color: #111827;
        }
        
        /* Simple submenu show/hide */
        .submenu-container.hidden {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-50 antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-56 glass-effect shadow-2xl transform -translate-x-full transition-all duration-500 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-14 px-4 bg-gradient-to-r from-blue-600 via-cyan-600 to-indigo-600 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div class="flex items-center space-x-2 relative z-10">
                        <div class="w-7 h-7 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30">
                            <i data-lucide="book-open" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <span class="text-lg font-black text-white tracking-tight">KJOS</span>
                            <p class="text-xs text-white/80 font-medium">Editorial Assistant</p>
                        </div>
                    </div>
                    <!-- Decorative elements -->
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/5 rounded-full -translate-y-10 translate-x-10"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto custom-scrollbar">
                    <!-- Dashboard -->
                    <a href="{{ route('editorial_assistant.dashboard') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-700 transition-all duration-300 group btn-modern border border-transparent hover:border-indigo-100 hover:shadow-md {{ request()->routeIs('editorial_assistant.dashboard') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 border-indigo-100' : '' }}">
                        <div class="w-7 h-7 bg-indigo-100 rounded-md flex items-center justify-center mr-3 group-hover:bg-indigo-200 transition-colors duration-300 {{ request()->routeIs('editorial_assistant.dashboard') ? 'bg-indigo-200' : '' }}">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 text-indigo-600"></i>
                        </div>
                        <span class="font-medium text-sm">Dashboard</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-indigo-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                    </a>

                    <!-- Accepted Articles -->
                    <a href="{{ route('editorial_assistant.articles.index') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-teal-50 hover:to-cyan-50 hover:text-teal-700 transition-all duration-300 group btn-modern border border-transparent hover:border-teal-100 hover:shadow-md mt-4 {{ request()->routeIs('editorial_assistant.articles.*') ? 'bg-gradient-to-r from-teal-50 to-cyan-50 text-teal-700 border-teal-100' : '' }}">
                        <div class="w-7 h-7 bg-teal-100 rounded-md flex items-center justify-center mr-3 group-hover:bg-teal-200 transition-colors duration-300 {{ request()->routeIs('editorial_assistant.articles.*') ? 'bg-teal-200' : '' }}">
                            <i data-lucide="check-circle" class="w-4 h-4 text-teal-600"></i>
                        </div>
                        <span class="font-medium text-sm">Accepted Articles</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-teal-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                    </a>

                    <!-- Profile Settings -->
                    <div class="space-y-1 mt-6">
                        <div class="space-y-1 mt-4">
                            <button id="profileMenuToggle" class="w-full px-3 py-2 flex items-center justify-between text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 hover:text-blue-700 transition-all duration-300 group btn-modern border border-transparent hover:border-blue-100 hover:shadow-md">
                                <div class="flex items-center">
                                    <div class="w-5 h-5 bg-gradient-to-br from-blue-100 to-cyan-100 rounded flex items-center justify-center mr-2">
                                        <i data-lucide="user-circle" class="w-3 h-3 text-blue-600"></i>
                                    </div>
                                    <h3 class="text-xs font-bold text-gray-600 uppercase tracking-wider group-hover:text-blue-700">{{ __('Profile') }}</h3>
                                </div>
                                <i data-lucide="chevron-down" id="profileMenuIcon" class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition-transform duration-300"></i>
                            </button>
                            
                            <!-- Profile Submenu -->
                            <ul id="profileSubmenu" class="submenu-container space-y-1 ml-2 pl-3 border-l-2 border-gray-100 hidden">
                                <li class="submenu-item">
                                    <a href="{{ route('editorial_assistant.profile.edit') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 hover:text-blue-700 transition-all duration-300 group relative">
                                        <div class="submenu-icon w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-all duration-300 shadow-sm">
                                            <i data-lucide="user" class="w-4 h-4 text-blue-600"></i>
                                        </div>
                                        <span class="font-medium text-sm">{{ __('Profile Settings') }}</span>
                                        <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-blue-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                
                <!-- Sign Out Section -->
                <div class="px-4 py-4 border-t border-gray-200/50">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2.5 text-red-600 rounded-lg hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 hover:text-red-700 transition-all duration-300 group btn-modern border border-transparent hover:border-red-100 hover:shadow-md">
                            <div class="w-7 h-7 bg-red-100 rounded-md flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors duration-300">
                                <i data-lucide="log-out" class="w-4 h-4 text-red-600"></i>
                            </div>
                            <span class="font-medium text-sm">{{__('Sign Out')}}</span>
                            <i data-lucide="chevron-right" class="w-3 h-3 text-red-400 group-hover:text-red-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Header -->
            <header class="glass-effect shadow-lg border-b border-white/20 backdrop-blur-xl relative z-[9999]">
                <div class="flex items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                    <!-- Mobile menu button -->
                    <button id="sidebarToggle" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 lg:hidden btn-modern">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>

                    <!-- Page Title -->
                    <div class="flex-1 min-w-0 lg:ml-0">
                        <div class="flex items-center space-x-2">
                            <h1 class="text-xl font-black leading-6 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 bg-clip-text text-transparent sm:truncate">
                                @yield('page-title', 'Dashboard')
                            </h1>
                            <div class="px-2 py-0.5 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-full">
                                <span class="text-xs font-bold text-white">EDITORIAL ASSISTANT</span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-600 font-medium">
                            @yield('page-description', 'Welcome to your Editorial Assistant portal')
                        </p>
                    </div>

                    <!-- Header Actions -->
                    <div class="flex items-center space-x-2">
                        <!-- Search -->
                        <div class="hidden md:block relative">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <input type="text" class="block w-48 pl-10 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-white/80 backdrop-blur-sm placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm font-medium transition-all duration-200" placeholder="{{__('Search...')}}">
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center">
                                    <kbd class="px-1.5 py-0.5 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded">⌘K</kbd>
                                </div>
                            </div>
                        </div>

                        <!-- Language Selector -->
                        <div class="relative group">
                            <select class="appearance-none bg-gradient-to-r from-white to-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 pr-10 text-sm font-semibold text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:border-indigo-300 hover:shadow-md hover:shadow-indigo-100 cursor-pointer min-w-[140px]">
                                <option value="en" class="py-2">🇺🇸 English</option>
                                <option value="fa" class="py-2">🇮🇷 فارسی</option>
                                <option value="ps" class="py-2">🇦🇫 پښتو</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 group-hover:text-indigo-500 transition-colors duration-200"></i>
                            </div>
                            <!-- Decorative gradient overlay -->
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-transparent via-transparent to-indigo-50/30 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>

                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 btn-modern group">
                            <i data-lucide="bell" class="w-5 h-5 group-hover:scale-110 transition-transform duration-200"></i>
                            <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white animate-pulse-slow"></span>
                        </button>



                        <!-- User Menu -->
                        <div class="relative z-[9999]">
                            <button id="headerUserMenu" class="flex items-center space-x-2 p-1.5 text-sm rounded-lg hover:bg-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500 btn-modern group">
                                <div class="relative">
                                    @if(auth()->user()->profile_image)
                                        <img src="{{ Storage::url(auth()->user()->profile_image) }}" 
                                             alt="{{ auth()->user()->name }}" 
                                             class="w-8 h-8 rounded-lg object-cover shadow-lg ring-2 ring-white">
                                    @else
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 via-cyan-500 to-indigo-500 rounded-lg flex items-center justify-center shadow-lg">
                                            <span class="text-xs font-bold text-white">{{ substr(auth()->user()->name ?? 'E', 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-400 rounded-full border border-white"></div>
                                </div>
                                <div class="hidden lg:block text-left">
                                    <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name ?? 'Editorial Assistant' }}</p>
                                    <p class="text-xs text-gray-500 font-medium">Editorial Assistant</p>
                                </div>
                                <i data-lucide="chevron-down" class="w-3 h-3 text-gray-400 group-hover:text-gray-600 transition-colors duration-200"></i>
                            </button>

                            <!-- Header User Dropdown -->
                            <div id="headerUserDropdown" class="absolute top-full right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 py-3 hidden z-[9999] backdrop-blur-sm">
                                <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
                                    <div class="flex items-center space-x-3">
                                        @if(auth()->user()->profile_image)
                                            <img src="{{ Storage::url(auth()->user()->profile_image) }}" 
                                                 alt="{{ auth()->user()->name }}" 
                                                 class="w-10 h-10 rounded-lg object-cover shadow-lg ring-2 ring-white">
                                        @else
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 via-cyan-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-bold text-white">{{ substr(auth()->user()->name ?? 'E', 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name ?? 'Editorial Assistant' }}</p>
                                            <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'EditorialAssistant@example.com' }}</p>
                                            <div class="flex items-center mt-1">
                                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                                <span class="text-xs text-green-600 font-medium">Online</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="py-2">
                                    <a href="{{ route('editorial_assistant.profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 hover:text-blue-700 transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                                            <i data-lucide="user" class="w-4 h-4 text-blue-600"></i>
                                        </div>
                                         <span class="font-medium">Profile Settings</span>
                                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 ml-auto group-hover:text-blue-600 opacity-0 group-hover:opacity-100 transition-all duration-200"></i>
                                    </a>
                                    
                                    <a href="{{ route('editorial_assistant.profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-blue-50 hover:text-cyan-700 transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-cyan-200 transition-colors duration-200">
                                            <i data-lucide="settings" class="w-4 h-4 text-cyan-600"></i>
                                        </div>
                                         <span class="font-medium">Account Settings</span>
                                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 ml-auto group-hover:text-cyan-600 opacity-0 group-hover:opacity-100 transition-all duration-200"></i>
                                    </a>
                                </div>

                                <div class="border-t border-gray-100 pt-2">
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:text-red-700 transition-all duration-200 font-medium group">
                                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors duration-200">
                                                <i data-lucide="log-out" class="w-4 h-4 text-red-600"></i>
                                            </div>
                                            <span class="font-medium">Sign Out</span>
                                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 ml-auto group-hover:text-red-600 opacity-0 group-hover:opacity-100 transition-all duration-200"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Breadcrumb -->
                @hasSection('breadcrumb')
                <div class="px-4 py-2 sm:px-6 lg:px-8 border-t border-gray-100">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-4">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
                @endif
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-3 sm:p-4 lg:p-6 relative z-10">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebarOverlay" class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 hidden lg:hidden"></div>

    <!-- JavaScript -->
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Sidebar toggle functionality
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');

            // Add slide animation
            if (!sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.add('slide-enter-active');
                setTimeout(() => sidebar.classList.remove('slide-enter-active'), 300);
            }
        }

        sidebarToggle?.addEventListener('click', toggleSidebar);
        sidebarOverlay?.addEventListener('click', toggleSidebar);

        // Header user menu toggle functionality
        const headerUserMenuButton = document.getElementById('headerUserMenu');
        const headerUserDropdown = document.getElementById('headerUserDropdown');

        function toggleHeaderUserMenu() {
            headerUserDropdown?.classList.toggle('hidden');
        }

        headerUserMenuButton?.addEventListener('click', toggleHeaderUserMenu);


        // Close menus when clicking outside
        document.addEventListener('click', function(e) {
            if (headerUserDropdown && !headerUserMenuButton?.contains(e.target) && !headerUserDropdown.contains(e.target)) {
                headerUserDropdown.classList.add('hidden');
            }
        });

        // Close sidebar and menus on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
                if (headerUserDropdown && !headerUserDropdown.classList.contains('hidden')) {
                    headerUserDropdown.classList.add('hidden');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }
        });

        // Active navigation highlighting with enhanced styling
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('nav a[href]');

        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href !== '#' && href === currentPath) {
                // Remove hover classes and add active classes
                link.classList.remove('hover:bg-gradient-to-r', 'hover:from-blue-50', 'hover:to-indigo-50', 'hover:text-blue-700');
                link.classList.add('bg-gradient-to-r', 'from-indigo-500', 'to-purple-600', 'text-white', 'shadow-lg', 'transform', 'scale-105');

                // Style the icon container
                const iconContainer = link.querySelector('div');
                if (iconContainer) {
                    iconContainer.classList.remove('bg-blue-100');
                    iconContainer.classList.add('bg-white/20', 'backdrop-blur-sm');
                }

                // Style the icon
                const icon = link.querySelector('i');
                if (icon) {
                    icon.classList.add('text-white');
                }

                // Style the chevron
                const chevron = link.querySelector('i[data-lucide="chevron-right"]');
                if (chevron) {
                    chevron.classList.add('text-white', 'opacity-100');
                }
            }
        });

        // Search functionality (placeholder)
        const searchInput = document.querySelector('input[placeholder*="Search"]');
        if (searchInput) {
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.blur();
                }
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault();
                    this.focus();
                }
            });
        }

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';

        // Notification animation
        const notificationBtn = document.querySelector('button[class*="animate-pulse-slow"]');
        if (notificationBtn) {
            notificationBtn.addEventListener('click', function() {
                // Add click feedback
                this.classList.add('scale-95');
                setTimeout(() => this.classList.remove('scale-95'), 150);
            });
        }

        // Add loading states for forms
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i>Signing out...';
                    lucide.createIcons();
                }
            });
        });
        
        // Function to toggle submenu (simple show/hide)
        function toggleSubmenu(submenu, icon) {
            const isHidden = submenu.classList.contains('hidden');
            
            if (isHidden) {
                submenu.classList.remove('hidden');
                if (icon) icon.classList.add('rotate-180');
            } else {
                submenu.classList.add('hidden');
                if (icon) icon.classList.remove('rotate-180');
            }
        }
        
        // Function to detect and highlight active submenu items
        function highlightActiveSubmenuItems() {
            const currentPath = window.location.pathname;
            const submenuItems = document.querySelectorAll('.submenu-item a');
            
            submenuItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href) {
                    // Normalize to pathname
                    let itemPath = href;
                    try { itemPath = new URL(href, window.location.origin).pathname; } catch (e) {}
                    if (!itemPath.startsWith('/')) itemPath = '/' + itemPath.replace(/^\/+/, '');
                    
                    // Check if current path matches or starts with item path
                    if (currentPath === itemPath || (itemPath !== '/' && currentPath.startsWith(itemPath))) {
                        const parentLi = item.closest('.submenu-item');
                        if (parentLi) {
                            parentLi.classList.add('active');
                            // Auto-expand parent submenu
                            const submenu = parentLi.closest('ul');
                            if (submenu && submenu.classList.contains('submenu-container')) {
                                submenu.classList.remove('hidden');
                                
                                // Update chevron icon
                                const menuId = submenu.id;
                                if (menuId === 'articlesSubmenu') {
                                    const icon = document.getElementById('articlesMenuIcon');
                                    if (icon) icon.classList.add('rotate-180');
                                } else if (menuId === 'approvalsSubmenu') {
                                    const icon = document.getElementById('approvalsMenuIcon');
                                    if (icon) icon.classList.add('rotate-180');
                                } else if (menuId === 'profileSubmenu') {
                                    const icon = document.getElementById('profileMenuIcon');
                                    if (icon) icon.classList.add('rotate-180');
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Articles submenu toggle functionality
        const articlesMenuToggle = document.getElementById('articlesMenuToggle');
        const articlesSubmenu = document.getElementById('articlesSubmenu');
        const articlesMenuIcon = document.getElementById('articlesMenuIcon');
        
        if (articlesMenuToggle && articlesSubmenu) {
            articlesMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleSubmenu(articlesSubmenu, articlesMenuIcon);
            });
        }
        
        // Approvals submenu toggle functionality
        const approvalsMenuToggle = document.getElementById('approvalsMenuToggle');
        const approvalsSubmenu = document.getElementById('approvalsSubmenu');
        const approvalsMenuIcon = document.getElementById('approvalsMenuIcon');
        
        if (approvalsMenuToggle && approvalsSubmenu) {
            approvalsMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleSubmenu(approvalsSubmenu, approvalsMenuIcon);
            });
        }
        
        // Profile submenu toggle functionality
        const profileMenuToggle = document.getElementById('profileMenuToggle');
        const profileSubmenu = document.getElementById('profileSubmenu');
        const profileMenuIcon = document.getElementById('profileMenuIcon');
        
        if (profileMenuToggle && profileSubmenu) {
            profileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleSubmenu(profileSubmenu, profileMenuIcon);
            });
        }
        
        // Initialize active submenu items on page load
        highlightActiveSubmenuItems();
    </script>
</body>

</html>