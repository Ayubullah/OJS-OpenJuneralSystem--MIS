<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KJOS Admin Dashboard')</title>
    
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
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
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
                <div class="flex items-center justify-center h-14 px-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div class="flex items-center space-x-2 relative z-10">
                        <div class="w-7 h-7 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30">
                            <i data-lucide="book-open" class="w-4 h-4 text-white"></i>
                        </div>
                         <div>
                             <span class="text-lg font-black text-white tracking-tight">KJOS</span>
                             <p class="text-xs text-white/80 font-medium">Admin</p>
                         </div>
                    </div>
                    <!-- Decorative elements -->
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/5 rounded-full -translate-y-10 translate-x-10"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto custom-scrollbar">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-700 transition-all duration-300 group btn-modern border border-transparent hover:border-blue-100 hover:shadow-md">
                        <div class="w-7 h-7 bg-blue-100 rounded-md flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-300">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 text-blue-600"></i>
                        </div>
                         <div class="flex-1">
                             <span class="font-medium text-sm">{{ __('Dashboard') }}</span>
                         </div>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-blue-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1"></i>
                    </a>
                    
                    <!-- Editorial Workflow -->
                    

                    <!-- Articles Management -->
                    <div class="space-y-1 mt-4">
                        <button id="articlesMenuToggle" class="w-full px-3 py-2 flex items-center justify-between text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-teal-50 hover:to-cyan-50 hover:text-teal-700 transition-all duration-300 group btn-modern border border-transparent hover:border-teal-100 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="w-5 h-5 bg-gradient-to-br from-teal-100 to-cyan-100 rounded flex items-center justify-center mr-2">
                                    <i data-lucide="file-text" class="w-3 h-3 text-teal-600"></i>
                                </div>
                                <h3 class="text-xs font-bold text-gray-600 uppercase tracking-wider group-hover:text-teal-700">{{ __('Articles') }}</h3>
                            </div>
                            <i data-lucide="chevron-down" id="articlesMenuIcon" class="w-4 h-4 text-gray-400 group-hover:text-teal-600 transition-transform duration-300"></i>
                        </button>
                        
                        <!-- Articles Submenu -->
                        <ul id="articlesSubmenu" class="submenu-container space-y-1 ml-2 pl-3 border-l-2 border-gray-100 hidden">
                            <li class="submenu-item">
                                <a href="{{ route('admin.articles.index') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-violet-50 hover:to-purple-50 hover:text-violet-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-violet-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-violet-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="file-text" class="w-4 h-4 text-violet-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('All Articles') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-violet-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('admin.submissions.index') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-emerald-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="inbox" class="w-4 h-4 text-emerald-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('All Submissions') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-emerald-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('admin.submissions.published') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('Published') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-green-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('admin.submissions.accepted') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-teal-50 hover:to-cyan-50 hover:text-teal-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-teal-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-teal-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="check" class="w-4 h-4 text-teal-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('Accepted') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-teal-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('admin.submissions.submitted') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-yellow-50 hover:to-amber-50 hover:text-yellow-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="send" class="w-4 h-4 text-yellow-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('Submitted') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-yellow-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('admin.submissions.under-review') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="eye" class="w-4 h-4 text-blue-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('Under Review') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-blue-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('admin.submissions.revision-required') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-orange-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-orange-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="edit" class="w-4 h-4 text-orange-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('Revision Required') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-orange-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('admin.submissions.rejected') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 hover:text-red-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="x-circle" class="w-4 h-4 text-red-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('Rejected') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-red-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Previous Articles -->
                    <a href="{{ route('admin.previous-articles.index') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 hover:text-purple-700 transition-all duration-300 group btn-modern border border-transparent hover:border-purple-100 hover:shadow-md">
                        <div class="w-7 h-7 bg-purple-100 rounded-md flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors duration-300">
                            <i data-lucide="archive" class="w-4 h-4 text-purple-600"></i>
                        </div>
                        <span class="font-medium text-sm">{{ __('Previous Articles') }}</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-purple-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                    </a>

                    <!-- Reminders -->
                    <a href="{{ route('admin.reminders.index') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-700 transition-all duration-300 group btn-modern border border-transparent hover:border-orange-100 hover:shadow-md">
                        <div class="w-7 h-7 bg-orange-100 rounded-md flex items-center justify-center mr-3 group-hover:bg-orange-200 transition-colors duration-300">
                            <i data-lucide="bell" class="w-4 h-4 text-orange-600"></i>
                        </div>
                        <span class="font-medium text-sm">{{ __('Reminder') }}</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-orange-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                    </a>

                    <!-- User Management -->
                    <div class="space-y-1 mt-4">
                        <button id="usersMenuToggle" class="w-full px-3 py-2 flex items-center justify-between text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-700 transition-all duration-300 group btn-modern border border-transparent hover:border-blue-100 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="w-5 h-5 bg-gradient-to-br from-teal-100 to-cyan-100 rounded flex items-center justify-center mr-2">
                                    <i data-lucide="users" class="w-3 h-3 text-teal-600"></i>
                                </div>
                                <h3 class="text-xs font-bold text-gray-600 uppercase tracking-wider group-hover:text-blue-700">{{ __('Users') }}</h3>
                            </div>
                            <i data-lucide="chevron-down" id="usersMenuIcon" class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition-transform duration-300"></i>
                        </button>
                        
                        <!-- Users Submenu -->
                        <ul id="usersSubmenu" class="submenu-container space-y-1 ml-2 pl-3 border-l-2 border-gray-100 hidden">
                            <li class="submenu-item">
                                <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="users" class="w-4 h-4 text-blue-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('All Users') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-blue-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('admin.editors.index') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-indigo-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-indigo-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="user-cog" class="w-4 h-4 text-indigo-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('Editors') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-indigo-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('admin.reviewers.index') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-emerald-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="user-check" class="w-4 h-4 text-emerald-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('Reviewers') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-emerald-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('admin.authors.index') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-sky-50 hover:to-blue-50 hover:text-sky-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-sky-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-sky-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="user-pen" class="w-4 h-4 text-sky-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{ __('Authors') }}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-sky-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                        </ul>
                        
                        
                    </div>
                    
                    <!-- System -->
                    <div class="space-y-1 mt-4">
                        <button id="settingsMenuToggle" class="w-full px-3 py-2 flex items-center justify-between text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-gray-50 hover:to-slate-50 hover:text-gray-700 transition-all duration-300 group btn-modern border border-transparent hover:border-gray-100 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="w-5 h-5 bg-gradient-to-br from-gray-100 to-slate-100 rounded flex items-center justify-center mr-2">
                                    <i data-lucide="settings" class="w-3 h-3 text-gray-600"></i>
                                </div>
                                <h3 class="text-xs font-bold text-gray-600 uppercase tracking-wider group-hover:text-gray-700">{{__('Settings')}}</h3>
                            </div>
                            <i data-lucide="chevron-down" id="settingsMenuIcon" class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-300"></i>
                        </button>
                        
                        <!-- Settings Submenu -->
                        <ul id="settingsSubmenu" class="submenu-container space-y-1 ml-2 pl-3 border-l-2 border-gray-100 hidden">
                            <li class="submenu-item">
                                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-teal-50 hover:to-emerald-50 hover:text-teal-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-teal-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-teal-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="folder" class="w-4 h-4 text-teal-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{__('Categories')}}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-teal-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('admin.journals.index') }}" class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700 transition-all duration-300 group relative">
                                    <div class="submenu-icon w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-all duration-300 shadow-sm">
                                        <i data-lucide="book" class="w-4 h-4 text-green-600"></i>
                                    </div>
                                    <span class="font-medium text-sm">{{__('Journals')}}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-gray-400 group-hover:text-green-600 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 ml-auto"></i>
                                </a>
                            </li>
                            
                        </ul>
                        
                        
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
                            <div class="px-2 py-0.5 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full">
                                <span class="text-xs font-bold text-white">ADMIN</span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-600 font-medium">
                             @yield('page-description', __('Welcome to your KJOS admin dashboard'))
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
                        @php
                            $flag = app()->getLocale() === 'en' ? '🇺🇸' : '🇦🇫';
                        @endphp
                        <form method="POST" action="{{ route('locale.switch') }}" class="relative group" id="localeSwitcher">
                            @csrf
                            <label for="locale-select" class="sr-only">{{ __('Select language') }}</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                                    <span class="h-8 w-8 flex items-center justify-center text-lg rounded-full bg-white shadow-sm border border-gray-200">
                                        {{ $flag }}
                                    </span>
                                </div>
                                <select id="locale-select" name="locale" aria-label="{{ __('Select language') }}" class="pl-14 pr-12 py-2.5 min-w-[180px] text-sm font-semibold text-gray-900 rounded-xl border border-gray-200 bg-white/90 backdrop-blur-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:shadow-lg hover:-translate-y-px appearance-none cursor-pointer">
                                    <option value="en" @selected(app()->getLocale() === 'en')>🇺🇸 {{ __('English') }}</option>
                                    <option value="fa" @selected(app()->getLocale() === 'fa')>🇮🇷 {{ __('Dari / Farsi') }}</option>
                                    <option value="ps" @selected(app()->getLocale() === 'ps')>🇦🇫 {{ __('Pashto') }}</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 group-hover:text-indigo-500 transition-colors duration-200"></i>
                                </div>
                                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-transparent via-indigo-50/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                        </form>

                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 btn-modern group">
                            <i data-lucide="bell" class="w-5 h-5 group-hover:scale-110 transition-transform duration-200"></i>
                            <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white animate-pulse-slow"></span>
                        </button>
                        

                        <!-- Quick Actions -->
                        <button class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 btn-modern group">
                            <i data-lucide="plus" class="w-5 h-5 group-hover:scale-110 transition-transform duration-200"></i>
                        </button>
                        
                        <!-- User Menu -->
                        <div class="relative z-[9999]">
                            <button id="headerUserMenu" class="flex items-center space-x-2 p-1.5 text-sm rounded-lg hover:bg-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 btn-modern group">
                                <div class="relative">
                                    @if(auth()->user()->profile_image)
                                        <img src="{{ Storage::url(auth()->user()->profile_image) }}" 
                                             alt="{{ auth()->user()->name }}" 
                                             class="w-8 h-8 rounded-lg object-cover shadow-lg ring-2 ring-white">
                                    @else
                                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 via-purple-500 to-blue-500 rounded-lg flex items-center justify-center shadow-lg">
                                            <span class="text-xs font-bold text-white">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-400 rounded-full border border-white"></div>
                                </div>
                                 <div class="hidden lg:block text-left">
                                    <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name ?? __('Admin User') }}</p>
                                    <p class="text-xs text-gray-500 font-medium">{{ __(ucfirst(auth()->user()->role ?? 'Administrator')) }}</p>
                                 </div>
                                <i data-lucide="chevron-down" class="w-3 h-3 text-gray-400 group-hover:text-gray-600 transition-colors duration-200"></i>
                            </button>
                            
                            <!-- Header User Dropdown -->
                            <div id="headerUserDropdown" class="absolute top-full right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 py-3 hidden z-[9999] backdrop-blur-sm">
                                <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                                    <div class="flex items-center space-x-3">
                                        @if(auth()->user()->profile_image)
                                            <img src="{{ Storage::url(auth()->user()->profile_image) }}" 
                                                 alt="{{ auth()->user()->name }}" 
                                                 class="w-10 h-10 rounded-lg object-cover shadow-lg ring-2 ring-white">
                                        @else
                                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 via-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-bold text-white">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name ?? __('Admin User') }}</p>
                                            <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                                            <div class="flex items-center mt-1">
                                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                                <span class="text-xs text-green-600 font-medium">{{ __('Online') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="py-2">
                                    <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-700 transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                                            <i data-lucide="user" class="w-4 h-4 text-blue-600"></i>
                                        </div>
                                         <span class="font-medium">{{ __('Profile Settings') }}</span>
                                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 ml-auto group-hover:text-blue-600 opacity-0 group-hover:opacity-100 transition-all duration-200"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 hover:text-purple-700 transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors duration-200">
                                            <i data-lucide="settings" class="w-4 h-4 text-purple-600"></i>
                                        </div>
                                         <span class="font-medium">{{ __('Account Settings') }}</span>
                                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 ml-auto group-hover:text-purple-600 opacity-0 group-hover:opacity-100 transition-all duration-200"></i>
                                    </a>
                                    
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700 transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors duration-200">
                                            <i data-lucide="help-circle" class="w-4 h-4 text-green-600"></i>
                                        </div>
                                         <span class="font-medium">{{ __('Help & Support') }}</span>
                                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 ml-auto group-hover:text-green-600 opacity-0 group-hover:opacity-100 transition-all duration-200"></i>
                                    </a>
                                    
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-yellow-50 hover:to-amber-50 hover:text-yellow-700 transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-200 transition-colors duration-200">
                                            <i data-lucide="moon" class="w-4 h-4 text-yellow-600"></i>
                                        </div>
                                         <span class="font-medium">{{ __('Dark Mode') }}</span>
                                        <div class="ml-auto">
                                            <div class="w-8 h-4 bg-gray-200 rounded-full relative">
                                                <div class="w-3 h-3 bg-white rounded-full absolute top-0.5 left-0.5 transition-transform duration-200"></div>
                                            </div>
                                        </div>
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

        // Locale switcher submit on change
        const localeForm = document.getElementById('localeSwitcher');
        const localeSelect = localeForm?.querySelector('select[name="locale"]');
        if (localeSelect && localeForm) {
            localeSelect.addEventListener('change', () => localeForm.submit());
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
                    submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i>{{ __("Signing out...") }}';
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
                                } else if (menuId === 'usersSubmenu') {
                                    const icon = document.getElementById('usersMenuIcon');
                                    if (icon) icon.classList.add('rotate-180');
                                } else if (menuId === 'settingsSubmenu') {
                                    const icon = document.getElementById('settingsMenuIcon');
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
        
        // Users submenu toggle functionality
        const usersMenuToggle = document.getElementById('usersMenuToggle');
        const usersSubmenu = document.getElementById('usersSubmenu');
        const usersMenuIcon = document.getElementById('usersMenuIcon');
        
        if (usersMenuToggle && usersSubmenu) {
            usersMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleSubmenu(usersSubmenu, usersMenuIcon);
            });
        }
        
        // Settings submenu toggle functionality
        const settingsMenuToggle = document.getElementById('settingsMenuToggle');
        const settingsSubmenu = document.getElementById('settingsSubmenu');
        const settingsMenuIcon = document.getElementById('settingsMenuIcon');
        
        if (settingsMenuToggle && settingsSubmenu) {
            settingsMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleSubmenu(settingsSubmenu, settingsMenuIcon);
            });
        }
        
        // Initialize active submenu items on page load
        highlightActiveSubmenuItems();
        
    </script>
</body>
</html>
