@extends('layout.app_reviewer')

@section('title', 'Completed Reviews')
@section('page-title', 'Completed Reviews')
@section('page-description', 'Reviews you have finished')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <a href="{{ route('reviewer.dashboard') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Completed Reviews</span>
</li>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">Completed Reviews</h2>
                <p class="text-sm text-gray-600">Reviews you have finished</p>
            </div>
            <div class="p-6">
                @forelse($reviews as $review)
                <div class="border border-gray-200 rounded-lg p-6 mb-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
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
                                @if($review->submission->article->category)
                                <div class="flex items-center space-x-1">
                                    <i data-lucide="tag" class="w-4 h-4"></i>
                                    <span>{{ $review->submission->article->category->name }}</span>
                                </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center space-x-4 mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                                    Completed
                                </span>
                                <span class="text-sm text-gray-600 font-medium">
                                    Rating: {{ $review->rating }}/10
                                </span>
                                <span class="text-sm text-gray-500">
                                    Completed: {{ $review->updated_at?->format('M d, Y') ?? 'N/A' }}
                                </span>
                            </div>
                            
                            @if($review->comments)
                            <div class="mt-3 p-3 bg-green-50 rounded-lg">
                                <p class="text-sm text-gray-700">{{ Str::limit($review->comments, 200) }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <div class="ml-4 flex items-center space-x-2">
                            <a href="{{ route('reviewer.reviews.show', $review->id) }}" 
                               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                View Review
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="check-circle" class="w-8 h-8 text-green-600"></i>
                    </div>
                    <p class="text-gray-500 font-medium">No completed reviews</p>
                    <p class="text-sm text-gray-400 mt-1">You'll see your completed reviews here</p>
                </div>
                @endforelse
                
                @if($reviews->hasPages())
                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection







