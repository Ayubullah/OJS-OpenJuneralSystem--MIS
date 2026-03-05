<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'KJOS Chief Editor Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .glass-effect { background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); }
        .btn-modern { transition: all 0.2s cubic-bezier(0.4,0,0.2,1); }
        .btn-modern:hover { transform: translateY(-1px); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.5} }
        .animate-pulse-slow { animation: pulse 2s infinite; }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-56 glass-effect shadow-2xl transform -translate-x-full transition-all duration-500 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-center h-14 px-4 bg-gradient-to-r from-amber-600 via-orange-600 to-amber-700 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div class="flex items-center space-x-2 relative z-10">
                        <div class="w-7 h-7 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30">
                            <i data-lucide="shield-check" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <span class="text-lg font-black text-white tracking-tight">KJOS</span>
                            <p class="text-xs text-white/80 font-medium">Chief Editor</p>
                        </div>
                    </div>
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/5 rounded-full -translate-y-10 translate-x-10"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
                </div>

                <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto custom-scrollbar">
                    <a href="{{ route('chief_editor.dashboard') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 hover:text-amber-700 transition-all duration-300 group btn-modern border border-transparent hover:border-amber-100 hover:shadow-md {{ request()->routeIs('chief_editor.dashboard') ? 'bg-gradient-to-r from-amber-50 to-orange-50 text-amber-700 border-amber-100' : '' }}">
                        <div class="w-7 h-7 bg-amber-100 rounded-md flex items-center justify-center mr-3 group-hover:bg-amber-200 transition-colors duration-300 {{ request()->routeIs('chief_editor.dashboard') ? 'bg-amber-200' : '' }}">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 text-amber-600"></i>
                        </div>
                        <span class="font-medium text-sm">{{ __('Dashboard') }}</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-amber-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                    </a>

                    <a href="{{ route('chief_editor.articles') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 hover:text-amber-700 transition-all duration-300 group btn-modern border border-transparent hover:border-amber-100 hover:shadow-md mt-4 {{ request()->routeIs('chief_editor.articles*') ? 'bg-gradient-to-r from-amber-50 to-orange-50 text-amber-700 border-amber-100' : '' }}">
                        <div class="w-7 h-7 bg-amber-100 rounded-md flex items-center justify-center mr-3 group-hover:bg-amber-200 transition-colors duration-300 {{ request()->routeIs('chief_editor.articles*') ? 'bg-amber-200' : '' }}">
                            <i data-lucide="file-check" class="w-4 h-4 text-amber-600"></i>
                        </div>
                        <span class="font-medium text-sm">{{ __('Articles for Review') }}</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-amber-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                    </a>

                    <div class="space-y-1 mt-6">
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 hover:text-blue-700 transition-all duration-300 group btn-modern border border-transparent hover:border-blue-100 hover:shadow-md">
                            <div class="w-7 h-7 bg-blue-100 rounded-md flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-300">
                                <i data-lucide="user" class="w-4 h-4 text-blue-600"></i>
                            </div>
                            <span class="font-medium text-sm">{{ __('Profile') }}</span>
                            <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-blue-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                        </a>
                    </div>
                </nav>

                <div class="px-4 py-4 border-t border-gray-200/50">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2.5 text-red-600 rounded-lg hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 hover:text-red-700 transition-all duration-300 group btn-modern border border-transparent hover:border-red-100 hover:shadow-md">
                            <div class="w-7 h-7 bg-red-100 rounded-md flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors duration-300">
                                <i data-lucide="log-out" class="w-4 h-4 text-red-600"></i>
                            </div>
                            <span class="font-medium text-sm">{{ __('Sign Out') }}</span>
                            <i data-lucide="chevron-right" class="w-3 h-3 text-red-400 group-hover:text-red-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <header class="glass-effect shadow-lg border-b border-white/20 backdrop-blur-xl relative z-[9999]">
                <div class="flex items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                    <button id="sidebarToggle" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-white/50 focus:outline-none focus:ring-2 focus:ring-amber-500 lg:hidden btn-modern">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <div class="flex-1 min-w-0 lg:ml-0">
                        <div class="flex items-center space-x-2">
                            <h1 class="text-xl font-black leading-6 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 bg-clip-text text-transparent sm:truncate">@yield('page-title', 'Dashboard')</h1>
                            <div class="px-2 py-0.5 bg-gradient-to-r from-amber-500 to-orange-600 rounded-full">
                                <span class="text-xs font-bold text-white">CHIEF EDITOR</span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-600 font-medium">@yield('page-description', 'Welcome to your Chief Editor portal')</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="hidden md:block relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <input type="text" class="block w-48 pl-10 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-white/80 backdrop-blur-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm font-medium" placeholder="{{ __('Search...') }}">
                        </div>
                        <button class="relative p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 btn-modern group">
                            <i data-lucide="bell" class="w-5 h-5 group-hover:scale-110 transition-transform duration-200"></i>
                            <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white animate-pulse-slow"></span>
                        </button>
                        <div class="relative">
                            <button id="headerUserMenu" class="flex items-center space-x-2 p-1.5 text-sm rounded-lg hover:bg-white/50 focus:outline-none focus:ring-2 focus:ring-amber-500 btn-modern group">
                                <div class="relative">
                                    @if(auth()->user() && auth()->user()->profile_image)
                                        <img src="{{ Storage::url(auth()->user()->profile_image) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-lg object-cover shadow-lg ring-2 ring-white">
                                    @else
                                        <div class="w-8 h-8 bg-gradient-to-br from-amber-500 via-orange-500 to-amber-600 rounded-lg flex items-center justify-center shadow-lg">
                                            <span class="text-xs font-bold text-white">{{ substr(auth()->user()->name ?? 'C', 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-400 rounded-full border border-white"></div>
                                </div>
                                <div class="hidden lg:block text-left">
                                    <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name ?? 'Chief Editor' }}</p>
                                    <p class="text-xs text-gray-500 font-medium">Chief Editor</p>
                                </div>
                                <i data-lucide="chevron-down" class="w-3 h-3 text-gray-400"></i>
                            </button>
                            <div id="headerUserDropdown" class="absolute top-full right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 py-3 hidden z-[9999]">
                                <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-orange-50">
                                    <div class="flex items-center space-x-3">
                                        @if(auth()->user() && auth()->user()->profile_image)
                                            <img src="{{ Storage::url(auth()->user()->profile_image) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-lg object-cover shadow-lg ring-2 ring-white">
                                        @else
                                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 via-orange-500 to-amber-600 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-bold text-white">{{ substr(auth()->user()->name ?? 'C', 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name ?? 'Chief Editor' }}</p>
                                            <p class="text-xs text-gray-500">{{ auth()->user()->email ?? '' }}</p>
                                            <div class="flex items-center mt-1">
                                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                                <span class="text-xs text-green-600 font-medium">Online</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 hover:text-amber-700 transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-amber-200 transition-colors duration-200">
                                            <i data-lucide="user" class="w-4 h-4 text-amber-600"></i>
                                        </div>
                                        <span class="font-medium">{{ __('Profile Settings') }}</span>
                                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 ml-auto"></i>
                                    </a>
                                </div>
                                <div class="border-t border-gray-100 pt-2">
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:text-red-700 transition-all duration-200 font-medium group">
                                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors duration-200">
                                                <i data-lucide="log-out" class="w-4 h-4 text-red-600"></i>
                                            </div>
                                            <span class="font-medium">{{ __('Sign Out') }}</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

            <main class="flex-1 overflow-y-auto bg-gray-50 p-3 sm:p-4 lg:p-6 relative z-10">
                @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl shadow-sm flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                    </div>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                @endif
                @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl shadow-sm flex items-center">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
                    </div>
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <div id="sidebarOverlay" class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 hidden lg:hidden"></div>

    <script>
        lucide.createIcons();
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }
        sidebarToggle?.addEventListener('click', toggleSidebar);
        sidebarOverlay?.addEventListener('click', toggleSidebar);
        const headerUserMenuButton = document.getElementById('headerUserMenu');
        const headerUserDropdown = document.getElementById('headerUserDropdown');
        headerUserMenuButton?.addEventListener('click', function() { headerUserDropdown?.classList.toggle('hidden'); });
        document.addEventListener('click', function(e) {
            if (headerUserDropdown && !headerUserMenuButton?.contains(e.target) && !headerUserDropdown.contains(e.target)) {
                headerUserDropdown.classList.add('hidden');
            }
        });
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>
</html>
