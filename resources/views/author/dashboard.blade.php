@extends('layout.app_author')

@section('title', 'Author Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview of your articles and submissions')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl shadow-xl overflow-hidden">
        <div class="px-8 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="text-indigo-100 text-lg">Track your article submissions and review progress</p>
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
        <!-- Total Articles -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Articles</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_articles'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="file-text" class="w-7 h-7 text-white"></i>
                </div>
            </div>
            <a href="{{ route('author.articles.index') }}" class="mt-4 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-700">
                View all <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Published -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Published</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['published'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>

        <!-- Under Review -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Under Review</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['under_review'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="eye" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>

        <!-- Revision Required -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Revision Required</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['revision_required'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="edit" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Accepted -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Accepted</h3>
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="check" class="w-5 h-5 text-teal-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['accepted'] }}</p>
            <p class="text-sm text-gray-500">Articles accepted for publication</p>
        </div>

        <!-- Submitted -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Submitted</h3>
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="send" class="w-5 h-5 text-yellow-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['submitted'] }}</p>
            <p class="text-sm text-gray-500">Awaiting initial review</p>
        </div>

        <!-- Rejected -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Rejected</h3>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ $stats['rejected'] }}</p>
            <p class="text-sm text-gray-500">Articles not accepted</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Articles -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Recent Articles</h3>
                    <a href="{{ route('author.articles.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        View all <i data-lucide="arrow-right" class="w-4 h-4 inline"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recent_articles->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_articles as $article)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 truncate mb-1">
                                    {{ $article->title ?? 'Untitled Article' }}
                                </h4>
                                <div class="flex items-center space-x-3 text-xs text-gray-500 mb-2">
                                    @if($article->journal)
                                    <span class="flex items-center">
                                        <i data-lucide="book" class="w-3 h-3 mr-1"></i>
                                        {{ $article->journal->name }}
                                    </span>
                                    @endif
                                    @if($article->category)
                                    <span class="flex items-center">
                                        <i data-lucide="tag" class="w-3 h-3 mr-1"></i>
                                        {{ $article->category->name }}
                                    </span>
                                    @endif
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 
                                       ($article->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                                       ($article->status === 'accepted' ? 'bg-teal-100 text-teal-800' : 
                                       ($article->status === 'revision_required' ? 'bg-orange-100 text-orange-800' : 
                                       ($article->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                                </span>
                            </div>
                            <a href="{{ route('author.articles.show', $article) }}" 
                               class="ml-4 p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </a>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">
                            Created {{ $article->created_at?->diffForHumans() ?? 'N/A' }}
                        </p>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="file-text" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">No articles yet</h4>
                    <p class="text-sm text-gray-500 mb-4">Get started by submitting your first article</p>
                    <a href="{{ route('author.articles.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Submit New Article
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Recent Reviews</h3>
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
                                            {{ $review->reviewer->user->name ?? 'Unknown Reviewer' }}
                                        </h4>
                                        <p class="text-xs text-gray-500">{{ $review->updated_at?->diffForHumans() ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-700 line-clamp-2 mb-2">
                                    {{ Str::limit(strip_tags($review->editor_edited_comments ?? $review->comments ?? ''), 80) }}
                                </p>
                                <div class="flex items-center space-x-2">
                                    @if($review->rating)
                                    <span class="text-xs font-bold text-gray-900">{{ $review->rating }}/10</span>
                                    @endif
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
                                    On: {{ $review->submission->article->title ?? 'Untitled Article' }}
                                </p>
                            </div>
                            <a href="{{ route('author.articles.show', $review->submission->article) }}" 
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
                    <h4 class="text-lg font-medium text-gray-900 mb-2">No reviews yet</h4>
                    <p class="text-sm text-gray-500">Reviews will appear here once your articles are reviewed</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('author.articles.create') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all duration-200 group">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-200 transition-colors">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-green-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 group-hover:text-green-600">Submit New Article</h4>
                    <p class="text-sm text-gray-500">Create and submit a new article</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto group-hover:text-green-600"></i>
            </a>

            <a href="{{ route('author.articles.index') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200 group">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-indigo-200 transition-colors">
                    <i data-lucide="file-text" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 group-hover:text-indigo-600">My Articles</h4>
                    <p class="text-sm text-gray-500">View and manage all articles</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto group-hover:text-indigo-600"></i>
            </a>

            <a href="{{ route('author.profile.edit') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 group">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-purple-200 transition-colors">
                    <i data-lucide="user-circle" class="w-5 h-5 text-purple-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 group-hover:text-purple-600">Profile Settings</h4>
                    <p class="text-sm text-gray-500">Update your profile information</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto group-hover:text-purple-600"></i>
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

