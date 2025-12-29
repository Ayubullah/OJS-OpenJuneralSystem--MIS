@extends('layout.app_reviewer')

@section('title', 'Review Details')
@section('page-title', 'Review Details')
@section('page-description', 'View detailed review information')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <a href="{{ route('reviewer.dashboard') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('reviewer.reviews.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Reviews</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Details</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Review Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-purple-50 to-pink-50">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-3 mb-4">
                        @if($review->rating)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                                Completed
                            </span>
                        @elseif($review->comments)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i data-lucide="edit" class="w-4 h-4 mr-1"></i>
                                In Progress
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i data-lucide="clock" class="w-4 h-4 mr-1"></i>
                                Pending
                            </span>
                        @endif
                        @if($review->rating)
                        <div class="flex items-center space-x-1">
                            <span class="text-sm font-bold text-gray-900">{{ $review->rating }}/10</span>
                            <div class="flex space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                <i data-lucide="star" class="w-4 h-4 {{ $i <= ($review->rating / 2) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                        </div>
                        @endif
                        <span class="text-sm text-gray-500">Assigned: {{ $review->created_at?->format('M d, Y') ?? 'N/A' }}</span>
                        @if($review->review_date)
                        <span class="text-sm text-gray-500">Deadline: {{ \Carbon\Carbon::parse($review->review_date)->format('M d, Y') }}</span>
                        @endif
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $review->submission->article->title ?? 'Untitled Article' }}</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            <span>{{ $review->submission->article->journal->name ?? 'Unknown Journal' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>{{ $review->submission->article->author->name ?? 'Unknown Author' }}</span>
                        </div>
                        @if($review->submission->article->category)
                        <div class="flex items-center space-x-2">
                            <i data-lucide="tag" class="w-4 h-4"></i>
                            <span>{{ $review->submission->article->category->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Article Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Article Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Title</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $review->submission->article->title ?? 'Untitled Article' }}</p>
                    </div>
                    @if($review->submission->article->abstract)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Abstract</label>
                        <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $review->submission->article->abstract }}</p>
                    </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Journal</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->article->journal->name ?? 'Unknown Journal' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Category</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->article->category->name ?? 'Uncategorized' }}</p>
                        </div>
                    </div>
                    @if($review->submission->article->word_count)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Word Count</label>
                            <p class="text-sm font-semibold text-gray-900">{{ number_format($review->submission->article->word_count) }}</p>
                        </div>
                        @if($review->submission->article->number_of_tables)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tables</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->article->number_of_tables }}</p>
                        </div>
                        @endif
                        @if($review->submission->article->number_of_figures)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Figures</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->article->number_of_figures }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Submission Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Submission Information</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Submission Date</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->submission_date?->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Version</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->version_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $review->submission->status === 'published' ? 'bg-green-100 text-green-800' : 
                                   ($review->submission->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                                   ($review->submission->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($review->submission->status === 'accepted' ? 'bg-emerald-100 text-emerald-800' : 
                                   ($review->submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))) }}">
                                {{ ucfirst(str_replace('_', ' ', $review->submission->status)) }}
                            </span>
                        </div>
                    </div>
                    @if($review->submission->file_path)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Manuscript File</label>
                        <a href="{{ asset('storage/' . $review->submission->file_path) }}" target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                            View File
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Author Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Author Information</h3>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center">
                        <span class="text-lg font-bold text-white">{{ substr($review->submission->author->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $review->submission->author->name ?? 'Unknown Author' }}</h4>
                        <p class="text-sm text-gray-600">{{ $review->submission->author->email ?? 'No email' }}</p>
                        @if($review->submission->author->affiliation)
                        <p class="text-sm text-gray-500">{{ $review->submission->author->affiliation }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Previous Review Comments -->
            @if(isset($previousReviews) && $previousReviews->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Previous Review Comments</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i data-lucide="history" class="w-4 h-4 mr-1"></i>
                        {{ $previousReviews->count() }} Previous Review(s)
                    </span>
                </div>
                <div class="space-y-4">
                    @foreach($previousReviews as $prevReview)
                    <div class="border border-gray-200 rounded-xl p-4 bg-gradient-to-r from-gray-50 to-blue-50">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="file-text" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Version {{ $prevReview->submission->version_number ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $prevReview->submission->submission_date?->format('M d, Y') ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($prevReview->rating)
                                <span class="text-sm font-bold text-gray-900">{{ $prevReview->rating }}/10</span>
                                <div class="flex space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i data-lucide="star" class="w-3 h-3 {{ $i <= ($prevReview->rating / 2) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                @endif
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $prevReview->submission->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                       ($prevReview->submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst(str_replace('_', ' ', $prevReview->submission->status ?? 'unknown')) }}
                                </span>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center space-x-2 mb-2">
                                <i data-lucide="user" class="w-4 h-4 text-purple-600"></i>
                                <p class="text-xs font-semibold text-gray-700">Your Review Comment</p>
                            </div>
                            <div class="text-sm text-gray-700 ql-editor" style="padding: 0;">
                                {!! $prevReview->comments !!}
                            </div>
                        </div>
                        @php
                            $authorReply = $prevReview->author_reply ?? null;
                            $hasAuthorReply = $authorReply && trim($authorReply) !== '';
                        @endphp
                        @if($hasAuthorReply)
                        <div class="mt-3 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-3">
                            <div class="flex items-center space-x-2 mb-2">
                                <i data-lucide="message-square" class="w-4 h-4 text-green-600"></i>
                                <p class="text-xs font-semibold text-green-800">Author's Reply</p>
                            </div>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ trim($authorReply) }}</p>
                        </div>
                        @else
                        <div class="mt-3 bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <p class="text-xs text-gray-500 italic">
                                <i data-lucide="info" class="w-3 h-3 inline mr-1"></i>
                                No author reply yet for this review
                            </p>
                        </div>
                        @endif
                        <p class="text-xs text-gray-500 mt-2">
                            <i data-lucide="clock" class="w-3 h-3 inline mr-1"></i>
                            Reviewed on {{ $prevReview->updated_at?->format('M d, Y \a\t h:i A') ?? 'N/A' }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Review Form / Review Comments -->
            @if(!$review->rating)
            <!-- Review Form -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Write Your Review</h3>
                    <div class="flex items-start space-x-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-sm text-blue-800 font-medium">Review Visibility</p>
                            <p class="text-xs text-blue-700 mt-1">Your review comments will be visible to the author and editor. Once submitted, the article status will be updated to "Under Review".</p>
                        </div>
                    </div>
                </div>
                
                @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="list-disc list-inside text-sm text-red-800">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('reviewer.reviews.update', $review->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Rating Field -->
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">
                                Rating (0-10) <span class="text-gray-500">(Optional, can be added later)</span>
                            </label>
                            <div class="flex items-center space-x-4">
                                <input type="number" 
                                       name="rating" 
                                       id="rating" 
                                       value="{{ old('rating', $review->rating) }}"
                                       min="0" 
                                       max="10" 
                                       step="0.1"
                                       class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <span class="text-sm text-gray-600">out of 10</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Rate the article quality from 0 (poor) to 10 (excellent)</p>
                        </div>

                        <!-- Comments Field -->
                        <div>
                            <label for="comments" class="block text-sm font-medium text-gray-700 mb-2">
                                Review Comments <span class="text-red-500">*</span>
                            </label>
                            <!-- Rich Text Editor Container -->
                            <div id="editor-container" class="bg-white border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-purple-500 focus-within:border-purple-500" style="min-height: 400px;"></div>
                            <!-- Hidden textarea to store HTML content -->
                            <textarea name="comments" 
                                      id="comments" 
                                      required
                                      minlength="10"
                                      style="display: none;">{{ old('comments', $review->comments) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Your review comments will be visible to the author and editor. Use the formatting toolbar to style your text.</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('reviewer.reviews.index') }}" 
                               class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors font-medium">
                                <i data-lucide="send" class="w-4 h-4 mr-2 inline"></i>
                                Submit Review
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @else
            <!-- Review Comments (Read-only for completed reviews) -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Review Comments</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                        Review Completed
                    </span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                    <div class="text-sm text-gray-700 ql-editor" style="padding: 0;">
                        {!! $review->comments !!}
                    </div>
                </div>
                @if($review->author_reply)
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <i data-lucide="message-square" class="w-5 h-5 text-green-600"></i>
                        <h4 class="text-sm font-semibold text-green-800">Author's Reply</h4>
                    </div>
                    <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $review->author_reply }}</p>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Review Status -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Review Status</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Status</span>
                        @if($review->rating)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Completed
                            </span>
                        @elseif($review->comments)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                In Progress
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @endif
                    </div>
                    @if($review->rating)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Rating</span>
                        <span class="text-sm font-bold text-gray-900">{{ $review->rating }}/10</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Assigned</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $review->created_at?->format('M d, Y') ?? 'N/A' }}</span>
                    </div>
                    @if($review->review_date)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Deadline</span>
                        <span class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($review->review_date)->format('M d, Y') }}</span>
                    </div>
                    @endif
                    @if($review->updated_at)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $review->updated_at?->format('M d, Y') ?? 'N/A' }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('reviewer.reviews.index') }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        Back to Reviews
                    </a>
                    @if(!$review->rating)
                    <div class="text-xs text-gray-500 text-center mt-2">
                        <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                        Scroll down to write your review
                    </div>
                    @endif
                </div>
            </div>

            <!-- Review Timeline -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                            <i data-lucide="file-text" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Review Assigned</p>
                            <p class="text-xs text-gray-500">{{ $review->created_at?->format('M d, Y H:i') ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @if($review->comments && $review->updated_at && $review->updated_at->ne($review->created_at))
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
                            <i data-lucide="edit" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Comments Added</p>
                            <p class="text-xs text-gray-500">{{ $review->updated_at?->format('M d, Y H:i') ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @endif
                    @if($review->rating)
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Review Completed</p>
                            <p class="text-xs text-gray-500">{{ $review->updated_at?->format('M d, Y H:i') ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quill.js Rich Text Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<style>
    /* Quill editor content styling for display */
    .ql-editor {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    .ql-editor ol, .ql-editor ul {
        padding-left: 1.5em;
        margin: 0.5em 0;
    }
    .ql-editor ol li, .ql-editor ul li {
        padding-left: 0.5em;
    }
    .ql-editor li.ql-indent-1 {
        padding-left: 3em;
    }
    .ql-editor li.ql-indent-2 {
        padding-left: 4.5em;
    }
    .ql-editor li.ql-indent-3 {
        padding-left: 6em;
    }
    .ql-editor li.ql-indent-4 {
        padding-left: 7.5em;
    }
    .ql-editor li.ql-indent-5 {
        padding-left: 9em;
    }
    .ql-editor li.ql-indent-6 {
        padding-left: 10.5em;
    }
    .ql-editor li.ql-indent-7 {
        padding-left: 12em;
    }
    .ql-editor li.ql-indent-8 {
        padding-left: 13.5em;
    }
    .ql-editor p {
        margin: 0.5em 0;
    }
    .ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4, .ql-editor h5, .ql-editor h6 {
        margin: 0.5em 0;
        font-weight: 600;
    }
    .ql-editor blockquote {
        border-left: 4px solid #e5e7eb;
        padding-left: 1em;
        margin: 1em 0;
        color: #6b7280;
    }
    .ql-editor code, .ql-editor pre {
        background-color: #f3f4f6;
        border-radius: 4px;
        padding: 2px 4px;
    }
    .ql-editor pre {
        padding: 8px;
        margin: 0.5em 0;
    }
    .ql-editor a {
        color: #6366f1;
        text-decoration: underline;
    }
    .ql-editor strong {
        font-weight: 600;
    }
    .ql-editor em {
        font-style: italic;
    }
</style>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Initialize Quill Rich Text Editor
    document.addEventListener('DOMContentLoaded', function() {
        const editorContainer = document.getElementById('editor-container');
        const hiddenTextarea = document.getElementById('comments');
        
        if (editorContainer && hiddenTextarea) {
            // Initialize Quill editor
            const quill = new Quill('#editor-container', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'font': [] }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'align': [] }],
                        ['blockquote', 'code-block'],
                        ['link', 'image'],
                        ['clean']
                    ]
                },
                placeholder: 'Write your detailed review comments here. Please provide constructive feedback on the article\'s strengths, weaknesses, methodology, writing quality, and suggestions for improvement. (Minimum 10 characters)'
            });

            // Set initial content if there's old input or existing review
            const initialContent = hiddenTextarea.value;
            if (initialContent) {
                // Check if it's HTML or plain text
                if (initialContent.trim().startsWith('<')) {
                    quill.root.innerHTML = initialContent;
                } else {
                    quill.setText(initialContent);
                }
            }

            // Update hidden textarea when content changes
            quill.on('text-change', function() {
                const html = quill.root.innerHTML;
                const text = quill.getText().trim();
                
                // Update hidden textarea with HTML
                hiddenTextarea.value = html;
                
                // Validate minimum length
                if (text.length < 10) {
                    hiddenTextarea.setCustomValidity('Review comments must be at least 10 characters long.');
                } else {
                    hiddenTextarea.setCustomValidity('');
                }
            });

            // Before form submission, ensure content is synced
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const html = quill.root.innerHTML;
                    const text = quill.getText().trim();
                    
                    // Update hidden textarea
                    hiddenTextarea.value = html;
                    
                    // Validate minimum length
                    if (text.length < 10) {
                        e.preventDefault();
                        alert('Review comments must be at least 10 characters long.');
                        return false;
                    }
                });
            }

            // Custom styles for Quill editor
            const style = document.createElement('style');
            style.textContent = `
                .ql-container {
                    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    font-size: 14px;
                    min-height: 350px;
                }
                .ql-editor {
                    min-height: 350px;
                    padding: 16px;
                }
                .ql-editor.ql-blank::before {
                    font-style: normal;
                    color: #9ca3af;
                }
                .ql-toolbar {
                    border-top: 1px solid #e5e7eb;
                    border-left: 1px solid #e5e7eb;
                    border-right: 1px solid #e5e7eb;
                    border-bottom: none;
                    background: #f9fafb;
                    padding: 12px;
                    border-radius: 8px 8px 0 0;
                }
                .ql-container {
                    border-bottom: 1px solid #e5e7eb;
                    border-left: 1px solid #e5e7eb;
                    border-right: 1px solid #e5e7eb;
                    border-top: none;
                    border-radius: 0 0 8px 8px;
                }
                .ql-snow .ql-stroke {
                    stroke: #6b7280;
                }
                .ql-snow .ql-fill {
                    fill: #6b7280;
                }
                .ql-snow .ql-picker-label {
                    color: #6b7280;
                }
                .ql-snow .ql-picker-options {
                    background: white;
                    border: 1px solid #e5e7eb;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                }
                .ql-snow .ql-tooltip {
                    background: white;
                    border: 1px solid #e5e7eb;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                }
            `;
            document.head.appendChild(style);
        }
    });
</script>
@endsection

