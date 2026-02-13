@extends('layout.app_admin')

@section('title', 'Articles for ')
@section('page-title', 'Reviewer Articles')
@section('page-description', 'Articles assigned to ')

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
    <a href="{{ route('admin.reviewers.articles') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Article Assignments</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500"></span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Reviewer Profile Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
                    <span class="text-xl font-bold text-white">{{ substr($reviewer->user->name ?? $reviewer->email, 0, 1) }}</span>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $reviewer->user->name ?? $reviewer->email }}</h1>
                    <p class="text-sm text-gray-600">{{ $reviewer->email }}</p>
                    @if($reviewer->specialization)
                        <p class="text-sm text-gray-500 mt-1">{{ $reviewer->specialization }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Total Reviews</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $reviews->total() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-bold text-gray-900">{{ $reviews->whereNull('rating')->count() }}</div>
                    <div class="text-sm text-gray-500">Pending</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-bold text-gray-900">{{ $reviews->whereNotNull('rating')->count() }}</div>
                    <div class="text-sm text-gray-500">Completed</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="star" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-bold text-gray-900">
                        {{ $reviews->whereNotNull('rating')->avg('rating') ? number_format($reviews->whereNotNull('rating')->avg('rating'), 1) : '0.0' }}
                    </div>
                    <div class="text-sm text-gray-500">Avg Rating</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-6 h-6 text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-bold text-gray-900">{{ $reviews->count() > 0 ? round(($reviews->whereNotNull('rating')->count() / $reviews->count()) * 100) : 0 }}%</div>
                    <div class="text-sm text-gray-500">Completion Rate</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900">Assigned Articles</h2>
        </div>
        
        <div class="divide-y divide-gray-100">
            @forelse($reviews as $review)
            <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start space-x-4">
                            <!-- Article Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    {{ $review->submission->article->title ?? 'No Title' }}
                                </h3>
                                
                                <div class="flex items-center space-x-6 text-sm text-gray-500 mb-3">
                                    <div class="flex items-center space-x-1">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                        <span>{{ $review->submission->article->author->name ?? 'Unknown Author' }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i data-lucide="book" class="w-4 h-4"></i>
                                        <span>{{ $review->submission->article->journal->name ?? 'Unknown Journal' }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i data-lucide="tag" class="w-4 h-4"></i>
                                        <span>{{ $review->submission->article->category->name ?? 'Uncategorized' }}</span>
                                    </div>
                                </div>
                                
                                <!-- Review Status -->
                                <div class="flex items-center space-x-4">
                                    @if($review->rating)
                                        <div class="flex items-center space-x-1">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                                                    @else
                                                        <i data-lucide="star" class="w-4 h-4 text-gray-300"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-sm text-gray-600">{{ $review->rating }}/5</span>
                                        </div>
                                        <span class="text-sm text-gray-500">
                                            Completed 
                                        </span>
                                    @else
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                            <span class="text-sm text-gray-600">Pending Review</span>
                                        </div>
                                        <span class="text-sm text-gray-500">
                                            Assigned {{ $review->created_at->format('M d, Y') }}
                                        </span>
                                    @endif
                                </div>
                                
                                @if($review->comments)
                                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                        <p class="text-sm text-gray-700 line-clamp-2">{{ $review->comments }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center space-x-2 ml-4">
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
                                title="Review Details">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="file-text" class="w-8 h-8 text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No articles assigned</h3>
                <p class="text-gray-500">This reviewer hasn't been assigned any articles yet.</p>
            </div>
            @endforelse
        </div>
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
</script>
@endsection
