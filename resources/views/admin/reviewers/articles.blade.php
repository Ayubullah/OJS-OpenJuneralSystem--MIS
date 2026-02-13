@extends('layout.app_admin')

@section('title', 'Articles Assigned to Reviewers')
@section('page-title', 'Reviewer Assignments')
@section('page-description', 'Manage articles assigned to reviewers')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Reviewers</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Article Assignments</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Reviewer Assignments</h1>
                    <p class="mt-2 text-sm text-gray-600">Track articles assigned to reviewers and their review progress</p>
                </div>
                <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                    <!-- Filter Dropdown -->
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Reviewers</option>
                            @foreach($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}">{{ $reviewer->user->name ?? $reviewer->email }}</option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                    </div>
                    <!-- Status Filter -->
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="pending">Pending Reviews</option>
                            <option value="completed">Completed Reviews</option>
                            <option value="overdue">Overdue Reviews</option>
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            </div>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($reviews as $review)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
            <!-- Article Header -->
            <div class="p-6 pb-4">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
                            {{ $review->submission->article->title ?? 'No Title' }}
                        </h3>
                        <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            <span class="truncate">{{ $review->submission->article->journal->name ?? 'Unknown Journal' }}</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <i data-lucide="tag" class="w-4 h-4"></i>
                            <span>{{ $review->submission->article->category->name ?? 'Uncategorized' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($review->rating)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Completed
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Reviewer Info -->
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold text-white">{{ substr($review->reviewer->user->name ?? $review->reviewer->email, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $review->reviewer->user->name ?? $review->reviewer->email }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $review->reviewer->specialization ?? 'No specialization' }}</p>
                    </div>
                </div>

                <!-- Author Info -->
                <div class="flex items-center space-x-2 mb-4">
                    <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                    <span class="text-sm text-gray-600">{{ $review->submission->article->author->name ?? 'Unknown Author' }}</span>
                </div>

                <!-- Review Progress -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Review Progress</span>
                        <span class="font-medium text-gray-900">
                            @if($review->rating)
                                {{ $review->rating }}/5 Stars
                            @else
                                Not Started
                            @endif
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-300" 
                             style="width: {{ $review->rating ? ($review->rating / 5) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Article Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <div class="flex items-center space-x-1">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>Assigned {{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($review->review_date)
                            <div class="flex items-center space-x-1">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>Reviewed {{ $review->review_date->format('M d, Y') }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.articles.show', $review->submission->article) }}" 
                           class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        @if(!$review->rating)
                            <form action="{{ route('admin.reviews.remind-reviewer', $review) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200" 
                                        title="Send Reminder"
                                        onclick="return confirm('Send reminder email to this reviewer?')">
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                </button>
                            </form>
                        @endif
                        <button class="p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors duration-200" 
                                title="View Review Details">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="users" class="w-8 h-8 text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No reviewer assignments found</h3>
                <p class="text-gray-500 mb-6">Articles will appear here once they are assigned to reviewers.</p>
                <a href="{{ route('admin.reviewers.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                    Manage Reviewers
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($reviews->hasPages())
    <div class="flex items-center justify-center">
        {{ $reviews->links() }}
    </div>
    @endif
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
    
    // Add filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const reviewerFilter = document.querySelector('select');
        const statusFilter = document.querySelectorAll('select')[1];
        
        function applyFilters() {
            const reviewerId = reviewerFilter.value;
            const status = statusFilter.value;
            
            // Build URL with filters
            let url = new URL(window.location);
            if (reviewerId) url.searchParams.set('reviewer', reviewerId);
            if (status) url.searchParams.set('status', status);
            
            // Reload page with filters
            window.location.href = url.toString();
        }
        
        reviewerFilter.addEventListener('change', applyFilters);
        statusFilter.addEventListener('change', applyFilters);
    });
</script>
@endsection
