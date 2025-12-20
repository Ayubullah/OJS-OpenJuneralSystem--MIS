@extends('layout.app_reviewer')

@section('title', 'Reviewer Dashboard')
@section('page-title', 'Reviewer Dashboard')
@section('page-description', 'Manage your article reviews and assignments')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Reviewer Dashboard</h1>
                    <p class="mt-2 text-gray-600">Manage your article reviews and assignments</p>
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
                        <p class="text-sm font-medium text-gray-600 mb-1">Pending Reviews</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $pendingCount ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
                    </div>
                </div>
                <a href="{{ route('reviewer.reviews.pending') }}" class="mt-4 text-sm text-yellow-600 hover:text-yellow-700 font-medium inline-flex items-center">
                    View all <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

            <!-- In Progress -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">In Progress</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $inProgressCount ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="edit" class="w-6 h-6 text-blue-600"></i>
                    </div>
                </div>
                <a href="{{ route('reviewer.reviews.in-progress') }}" class="mt-4 text-sm text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
                    View all <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

            <!-- Completed Reviews -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Completed</p>
                        <p class="text-3xl font-bold text-green-600">{{ $completedCount ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                    </div>
                </div>
                <a href="{{ route('reviewer.reviews.completed') }}" class="mt-4 text-sm text-green-600 hover:text-green-700 font-medium inline-flex items-center">
                    View all <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>

            <!-- Total Reviews -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Reviews</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $totalCount ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="clipboard-list" class="w-6 h-6 text-purple-600"></i>
                    </div>
                </div>
                <a href="{{ route('reviewer.reviews.index') }}" class="mt-4 text-sm text-purple-600 hover:text-purple-700 font-medium inline-flex items-center">
                    View all <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Recent Reviews</h2>
                        <p class="text-sm text-gray-600">Your latest review assignments</p>
                    </div>
                    <a href="{{ route('reviewer.reviews.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                        View all
                    </a>
                </div>
            </div>
            <div class="p-6">
                @forelse($recentReviews ?? [] as $review)
                <div class="border border-gray-200 rounded-lg p-4 mb-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-base font-semibold text-gray-900 mb-1">
                                {{ $review->submission->article->title ?? 'No Title' }}
                            </h3>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>{{ $review->submission->article->author->name ?? 'Unknown Author' }}</span>
                                <span>•</span>
                                <span>{{ $review->submission->article->journal->name ?? 'Unknown Journal' }}</span>
                                <span>•</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if($review->rating) bg-green-100 text-green-800
                                    @elseif($review->comments) bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    @if($review->rating)
                                        Completed
                                    @elseif($review->comments)
                                        In Progress
                                    @else
                                        Pending
                                    @endif
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('reviewer.reviews.show', $review->id) }}" 
                           class="ml-4 px-3 py-1 text-sm text-purple-600 hover:text-purple-700 font-medium">
                            View →
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="clipboard-list" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 font-medium">No reviews assigned yet</p>
                    <p class="text-sm text-gray-400 mt-1">You'll see your review assignments here</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection







