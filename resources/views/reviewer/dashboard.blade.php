@extends('layout.app_reviewer')

@section('title', __('Reviewer Dashboard'))
@section('page-title', __('Reviewer Dashboard'))
@section('page-description', __('Manage your article reviews and assignments'))

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 rounded-2xl shadow-xl overflow-hidden mb-6">
                <div class="px-8 py-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ __('Welcome back, :name!', ['name' => Auth::user()->name]) }}</h1>
                            <p class="text-purple-100 text-lg mb-2">{{ __('Here\'s what\'s happening with your submissions today') }}</p>
                            @if(isset($journalName) && $journalName)
                            <div class="mt-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30 text-white">
                                    <i data-lucide="book-open" class="w-4 h-4 mr-1.5"></i>
                                    {{ $journalName }}
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="hidden md:block">
                            <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30">
                                <i data-lucide="layout-dashboard" class="w-12 h-12 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ __('Reviewer Dashboard') }}</h2>
                    <p class="mt-2 text-gray-600">{{ __('Manage your article reviews and assignments') }}</p>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Pending Reviews -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Pending Reviews') }}</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $pendingCount ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
                    </div>
                </div>
                <a href="{{ route('reviewer.reviews.pending') }}" class="mt-4 text-sm text-yellow-600 hover:text-yellow-700 font-medium inline-flex items-center">
                    {{ __('View all') }} <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

            <!-- In Progress -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">{{ __('In Progress') }}</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $inProgressCount ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="edit" class="w-6 h-6 text-blue-600"></i>
                    </div>
                </div>
                <a href="{{ route('reviewer.reviews.in-progress') }}" class="mt-4 text-sm text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                    {{ __('View all') }} <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

            <!-- Completed Reviews -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Completed') }}</p>
                        <p class="text-3xl font-bold text-green-600">{{ $completedCount ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                    </div>
                </div>
                <a href="{{ route('reviewer.reviews.completed') }}" class="mt-4 text-sm text-green-600 hover:text-green-700 font-medium inline-flex items-center">
                    {{ __('View all') }} <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

            <!-- Total Reviews -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Total Reviews') }}</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $totalCount ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="clipboard-list" class="w-6 h-6 text-purple-600"></i>
                    </div>
                </div>
                <a href="{{ route('reviewer.reviews.index') }}" class="mt-4 text-sm text-purple-600 hover:text-purple-700 font-medium inline-flex items-center">
                    {{ __('View all') }} <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Messages from Editor -->
        <div id="messages-section" class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-8">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px overflow-x-auto">
                    <button onclick="showReviewerTab('editorMessages')" id="reviewerEditorMessagesTab" class="tab-button active px-6 py-4 text-sm font-medium text-green-600 border-b-2 border-green-600 whitespace-nowrap">
                        <i data-lucide="user-cog" class="w-4 h-4 inline mr-2"></i>
                        {{ __('Editor Messages') }}
                        @if(isset($editorMessages) && $editorMessages->count() > 0)
                        <span class="ml-2 px-2 py-0.5 bg-green-500 text-white text-xs font-bold rounded-full">{{ $editorMessages->count() }}</span>
                        @endif
                    </button>
                    <button onclick="showReviewerTab('adminMessages')" id="reviewerAdminMessagesTab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        <i data-lucide="shield" class="w-4 h-4 inline mr-2"></i>
                        {{ __('Admin Messages') }}
                        @if(isset($adminMessages) && $adminMessages->count() > 0)
                        <span class="ml-2 px-2 py-0.5 bg-indigo-500 text-white text-xs font-bold rounded-full">{{ $adminMessages->count() }}</span>
                        @endif
                    </button>
                </nav>
            </div>

            <!-- Editor Messages Tab -->
            <div id="reviewerEditorMessagesTabContent" class="tab-content p-4">
                @if(isset($editorMessages) && $editorMessages->count() > 0)
                <div class="space-y-2">
                    @foreach($editorMessages as $message)
                    <div class="bg-white rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-white">{{ substr($message->editor->name ?? 'E', 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-sm font-semibold text-gray-900">{{ $message->editor->name ?? __('Editor') }}</span>
                                        @if($message->article_id)
                                        <span class="text-xs text-gray-500">• {{ __('Article ID') }}: {{ $message->article_id }}</span>
                                        <span class="text-xs text-gray-600 font-medium">{{ $message->article->title ?? __('Untitled Article') }}</span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-500 whitespace-nowrap">{{ $message->created_at->format('M d, h:i A') }}</span>
                                </div>
                                <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($message->message, 150) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i data-lucide="user-cog" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                    <p class="text-sm text-gray-500">{{ __('No editor messages yet') }}</p>
                </div>
                @endif
            </div>

            <!-- Admin Messages Tab -->
            <div id="reviewerAdminMessagesTabContent" class="tab-content p-4 hidden">
                @if(isset($adminMessages) && $adminMessages->count() > 0)
                <div class="space-y-2">
                    @foreach($adminMessages as $message)
                    <div class="bg-white rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-white">{{ substr($message->editor->name ?? 'A', 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-sm font-semibold text-gray-900">{{ $message->editor->name ?? __('Admin') }}</span>
                                        <span class="px-1.5 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-bold rounded">{{ __('Admin') }}</span>
                                        @if($message->article_id)
                                        <span class="text-xs text-gray-500">• {{ __('Article ID') }}: {{ $message->article_id }}</span>
                                        <span class="text-xs text-gray-600 font-medium">{{ $message->article->title ?? __('Untitled Article') }}</span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-500 whitespace-nowrap">{{ $message->created_at->format('M d, h:i A') }}</span>
                                </div>
                                <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($message->message, 150) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i data-lucide="shield" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                    <p class="text-sm text-gray-500">{{ __('No admin messages yet') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">{{ __('Recent Reviews') }}</h2>
                        <p class="text-sm text-gray-600">{{ __('Your latest review assignments') }}</p>
                    </div>
                    <a href="{{ route('reviewer.reviews.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                        {{ __('View all') }}
                    </a>
                </div>
            </div>
            <div class="p-6">
                @forelse($recentReviews ?? [] as $review)
                <div class="border border-gray-200 rounded-lg p-4 mb-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-base font-semibold text-gray-900 mb-1">
                                {{ $review->submission->article->title ?? __('No Title') }}
                            </h3>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>{{ $review->submission->article->journal->name ?? __('Unknown Journal') }}</span>
                                <span>•</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if($review->rating) bg-green-100 text-green-800
                                    @elseif($review->comments) bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    @if($review->rating)
                                        {{ __('Completed') }}
                                    @elseif($review->comments)
                                        {{ __('In Progress') }}
                                    @else
                                        {{ __('Pending') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('reviewer.reviews.show', $review->id) }}" 
                           class="ml-4 px-3 py-1 text-sm text-purple-600 hover:text-purple-700 font-medium">
                            {{ __('View') }} →
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="clipboard-list" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 font-medium">{{ __('No reviews assigned yet') }}</p>
                    <p class="text-sm text-gray-400 mt-1">{{ __('You\'ll see your review assignments here') }}</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    function showReviewerTab(tabName) {
        // Hide all tab contents
        document.getElementById('reviewerEditorMessagesTabContent').classList.add('hidden');
        document.getElementById('reviewerAdminMessagesTabContent').classList.add('hidden');
        
        // Remove active class from all tabs
        const tabs = ['reviewerEditorMessagesTab', 'reviewerAdminMessagesTab'];
        tabs.forEach(tabId => {
            const tab = document.getElementById(tabId);
            if (tab) {
                tab.classList.remove('active', 'text-green-600', 'border-green-600');
                tab.classList.add('text-gray-500', 'border-transparent');
            }
        });
        
        // Show selected tab content and activate tab
        if (tabName === 'editorMessages') {
            document.getElementById('reviewerEditorMessagesTabContent').classList.remove('hidden');
            document.getElementById('reviewerEditorMessagesTab').classList.add('active', 'text-green-600', 'border-green-600');
            document.getElementById('reviewerEditorMessagesTab').classList.remove('text-gray-500', 'border-transparent');
        } else if (tabName === 'adminMessages') {
            document.getElementById('reviewerAdminMessagesTabContent').classList.remove('hidden');
            document.getElementById('reviewerAdminMessagesTab').classList.add('active', 'text-green-600', 'border-green-600');
            document.getElementById('reviewerAdminMessagesTab').classList.remove('text-gray-500', 'border-transparent');
        }
    }
</script>
@endsection







