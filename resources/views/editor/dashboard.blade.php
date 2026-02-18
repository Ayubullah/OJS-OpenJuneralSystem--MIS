@extends('layout.app_editor')

@section('title', __('Editor Dashboard'))
@section('page-title', __('Dashboard'))
@section('page-description', __('Overview of your editorial activities'))

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-2xl shadow-xl overflow-hidden">
        <div class="px-8 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">{{ __('Welcome back, :name!', ['name' => Auth::user()->name]) }}</h1>
                    <p class="text-blue-100 text-lg mb-2">{{ __('Here\'s what\'s happening with your submissions today') }}</p>
                    @if(isset($journalNames) && count($journalNames) > 0)
                    <div class="mt-3">
                        <p class="text-blue-100 text-sm font-medium mb-1">{{ __('Journal(s)') }}:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($journalNames as $journalName)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30 text-white">
                                <i data-lucide="book-open" class="w-4 h-4 mr-1.5"></i>
                                {{ $journalName }}
                            </span>
                            @endforeach
                        </div>
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

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Submissions -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Total Submissions') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_submissions'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="file-text" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Pending Approvals') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_approvals'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="clock" class="w-7 h-7 text-white"></i>
                </div>
            </div>
            @if($stats['pending_approvals'] > 0)
            <a href="{{ route('editor.reviews.pending-approvals') }}" class="mt-4 inline-flex items-center text-sm font-medium text-orange-600 hover:text-orange-700">
                {{ __('Review now') }} <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
            </a>
            @endif
        </div>

        <!-- Under Review -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Under Review') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['under_review'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="eye" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>

        <!-- Published -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Published') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['published'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Accepted -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">{{ __('Accepted') }}</h3>
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="check" class="w-5 h-5 text-teal-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['accepted'] }}</p>
            <a href="{{ route('editor.submissions.accepted') }}" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                {{ __('View all') }} <i data-lucide="arrow-right" class="w-4 h-4 inline"></i>
            </a>
        </div>

        <!-- Revision Required -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">{{ __('Revision Required') }}</h3>
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="edit" class="w-5 h-5 text-orange-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['revision_required'] }}</p>
            <a href="{{ route('editor.submissions.revision-required') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                {{ __('View all') }} <i data-lucide="arrow-right" class="w-4 h-4 inline"></i>
            </a>
        </div>

        <!-- Rejected -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">{{ __('Rejected') }}</h3>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['rejected'] }}</p>
            <a href="{{ route('editor.submissions.rejected') }}" class="text-sm text-red-600 hover:text-red-700 font-medium">
                {{ __('View all') }} <i data-lucide="arrow-right" class="w-4 h-4 inline"></i>
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Submissions -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Recent Submissions') }}</h3>
                    <a href="{{ route('editor.submissions.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        {{ __('View all') }} <i data-lucide="arrow-right" class="w-4 h-4 inline"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recent_submissions->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_submissions as $submission)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 truncate mb-1">
                                    {{ $submission->article->title ?? __('Untitled Article') }}
                                </h4>
                                <div class="flex items-center space-x-3 text-xs text-gray-500 mb-2">
                                    <span class="flex items-center">
                                        <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                                        {{ $submission->author->name ?? __('Unknown Author') }}
                                    </span>
                                    <span class="flex items-center">
                                        <i data-lucide="book" class="w-3 h-3 mr-1"></i>
                                        {{ $submission->article->journal->name ?? __('Unknown Journal') }}
                                    </span>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $submission->status === 'published' ? 'bg-green-100 text-green-800' : 
                                       ($submission->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                                       ($submission->status === 'accepted' ? 'bg-teal-100 text-teal-800' : 
                                       ($submission->status === 'revision_required' ? 'bg-orange-100 text-orange-800' : 
                                       ($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                </span>
                            </div>
                            <a href="{{ route('editor.submissions.show', $submission) }}" 
                               class="ml-4 p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </a>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">
                            {{ __('Submitted') }} {{ $submission->submission_date?->diffForHumans() ?? __('N/A') }}
                        </p>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="file-text" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">{{ __('No submissions yet') }}</h4>
                    <p class="text-sm text-gray-500">{{ __('Submissions will appear here as they are received') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Recent Reviews') }}</h3>
                    @if($stats['pending_approvals'] > 0)
                    <a href="{{ route('editor.reviews.pending-approvals') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                        {{ $stats['pending_approvals'] }} {{ __('pending') }} <i data-lucide="arrow-right" class="w-4 h-4 inline"></i>
                    </a>
                    @endif
                </div>
            </div>
            <div class="p-6">
                @if($recent_reviews->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_reviews as $review)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                        <span class="text-xs font-bold text-white">{{ substr($review->reviewer->user->name ?? 'R', 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900">
                                            {{ $review->reviewer->user->name ?? __('Unknown Reviewer') }}
                                        </h4>
                                        <p class="text-xs text-gray-500">{{ $review->updated_at?->diffForHumans() ?? __('N/A') }}</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-700 line-clamp-2 mb-2">
                                    {{ Str::limit(strip_tags($review->comments ?? ''), 80) }}
                                </p>
                                <div class="flex items-center space-x-2">
                                    @if($review->rating)
                                    <span class="text-xs font-bold text-gray-900">{{ $review->rating }}/10</span>
                                    @endif
                                    @if($review->editor_approved)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ __('Approved') }}
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        {{ __('Pending') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('editor.submissions.show', $review->submission) }}" 
                               class="ml-4 p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors">
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="clipboard-list" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">{{ __('No reviews yet') }}</h4>
                    <p class="text-sm text-gray-500">{{ __('Reviews will appear here as they are submitted') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Quick Actions') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('editor.submissions.index') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 group">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors">
                    <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 group-hover:text-blue-600">{{ __('View All Submissions') }}</h4>
                    <p class="text-sm text-gray-500">{{ __('Browse all article submissions') }}</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto group-hover:text-blue-600"></i>
            </a>

            @if($stats['pending_approvals'] > 0)
            <a href="{{ route('editor.reviews.pending-approvals') }}" 
               class="flex items-center p-4 border border-orange-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition-all duration-200 group bg-orange-50/50">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-orange-200 transition-colors">
                    <i data-lucide="clock" class="w-5 h-5 text-orange-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 group-hover:text-orange-600">{{ __('Pending Approvals') }}</h4>
                    <p class="text-sm text-gray-500">{{ $stats['pending_approvals'] }} {{ __('reviews waiting') }}</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto group-hover:text-orange-600"></i>
            </a>
            @else
            <div class="flex items-center p-4 border border-gray-200 rounded-lg bg-gray-50">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                    <i data-lucide="check-circle" class="w-5 h-5 text-gray-400"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-500">{{ __('Pending Approvals') }}</h4>
                    <p class="text-sm text-gray-400">{{ __('All caught up!') }}</p>
                </div>
            </div>
            @endif

            <a href="{{ route('editor.profile.edit') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200 group">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-indigo-200 transition-colors">
                    <i data-lucide="user-circle" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 group-hover:text-indigo-600">{{ __('Profile Settings') }}</h4>
                    <p class="text-sm text-gray-500">{{ __('Update your profile') }}</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto group-hover:text-indigo-600"></i>
            </a>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endsection
