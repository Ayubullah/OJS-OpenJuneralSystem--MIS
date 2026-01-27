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
                        @if($review->plagiarism_percentage !== null)
                        <div class="flex items-center space-x-2 mt-2">
                            <i data-lucide="file-search" class="w-4 h-4 text-orange-500"></i>
                            <span class="text-sm text-gray-600">Plagiarism:</span>
                            <span class="text-sm font-bold {{ $review->plagiarism_percentage > 20 ? 'text-red-600' : ($review->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                {{ number_format($review->plagiarism_percentage, 2) }}%
                            </span>
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
            <!-- Review Format Document -->
            @if($review->reviewer->review_format_file)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center mr-4">
                            <i data-lucide="file-text" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Review Format Document</h3>
                            <p class="text-sm text-gray-600">Download the review format guide</p>
                        </div>
                    </div>
                    <a href="{{ route('review.format.download', ['file' => basename($review->reviewer->review_format_file)]) }}" 
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-colors">
                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                        Download Format
                    </a>
                </div>
            </div>
            @endif

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

                <form action="{{ route('reviewer.reviews.update', $review->id) }}" method="POST" id="reviewForm">
                    @csrf
                    @method('PUT')

                    <!-- Review Format Selection -->
                    <div class="mb-6 p-4 bg-gradient-to-r from-purple-50 to-blue-50 border border-purple-200 rounded-xl">
                        <label class="block text-sm font-semibold text-gray-900 mb-3">
                            <i data-lucide="settings" class="w-4 h-4 inline mr-2"></i>
                            Select Review Format
                        </label>
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="review_format" value="detailed" id="review_format_detailed" checked class="mr-2 w-4 h-4 text-purple-600 focus:ring-purple-500" onchange="toggleReviewFormat()">
                                <span class="text-sm font-medium text-gray-900">Detailed Review Format</span>
                                <span class="ml-2 text-xs text-gray-500">(All questions and criteria)</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="review_format" value="simple" id="review_format_simple" class="mr-2 w-4 h-4 text-purple-600 focus:ring-purple-500" onchange="toggleReviewFormat()">
                                <span class="text-sm font-medium text-gray-900">Simple Review Format</span>
                                <span class="ml-2 text-xs text-gray-500">(Rating, Plagiarism, Comments)</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <!-- Simple Review Format -->
                        <div id="simple_review_format" class="hidden">
                            <div class="border border-gray-200 rounded-xl p-6 bg-white">
                                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i data-lucide="file-text" class="w-5 h-5 mr-2 text-purple-600"></i>
                                    Simple Review
                                </h4>
                                
                                <div class="space-y-6">
                                    <!-- Rating Field -->
                                    <div>
                                        <label for="rating_simple" class="block text-sm font-medium text-gray-700 mb-2">
                                            Rating (0-10) <span class="text-gray-500">(Optional)</span>
                                        </label>
                                        <div class="flex items-center space-x-4">
                                            <input type="number" 
                                                   name="rating" 
                                                   id="rating_simple" 
                                                   value="{{ old('rating', $review->rating) }}"
                                                   min="0" 
                                                   max="10" 
                                                   step="0.1"
                                                   class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            <span class="text-sm text-gray-600">out of 10</span>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Rate the article quality from 0 (poor) to 10 (excellent)</p>
                                    </div>

                                    <!-- Plagiarism Percentage Field -->
                                    <div>
                                        <label for="plagiarism_percentage_simple" class="block text-sm font-medium text-gray-700 mb-2">
                                            Plagiarism Percentage <span class="text-gray-500">(Optional)</span>
                                        </label>
                                        <div class="flex items-center space-x-4">
                                            <input type="number" 
                                                   name="plagiarism_percentage" 
                                                   id="plagiarism_percentage_simple" 
                                                   value="{{ old('plagiarism_percentage', $review->plagiarism_percentage) }}"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-32 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('plagiarism_percentage') border-red-500 @enderror">
                                            <span class="text-sm text-gray-600">%</span>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Enter the plagiarism percentage detected (0-100%)</p>
                                        @error('plagiarism_percentage')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Comments Field -->
                                    <div>
                                        <label for="comments_simple" class="block text-sm font-medium text-gray-700 mb-2">
                                            Review Comments <span class="text-red-500">*</span>
                                        </label>
                                        <!-- Rich Text Editor Container -->
                                        <div id="editor-container-simple" class="bg-white border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-purple-500 focus-within:border-purple-500" style="min-height: 300px;"></div>
                                        <!-- Hidden textarea to store HTML content -->
                                        <textarea name="comments" 
                                                  id="comments_simple" 
                                                  minlength="10"
                                                  style="display: none;">{{ old('comments', $review->comments) }}</textarea>
                                        <p class="mt-1 text-xs text-gray-500">Your review comments will be visible to the author and editor.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Review Format -->
                        <div id="detailed_review_format">
                        <!-- General Comments Section -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-blue-50 to-purple-50">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i data-lucide="file-text" class="w-5 h-5 mr-2 text-purple-600"></i>
                                General Comments
                            </h4>
                            <p class="text-sm text-gray-600 mb-6">Please provide detailed comments for each of the following criteria:</p>
                            
                            <div class="space-y-6">
                                <!-- Question 1: Originality -->
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <label for="originality_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                                        1. Originality
                                    </label>
                                    <p class="text-xs text-gray-600 mb-3 italic">Does the paper contain new and significant information adequate to justify publication?</p>
                                    <textarea name="originality_comment" 
                                              id="originality_comment" 
                                              rows="4"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ old('originality_comment', $review->originality_comment) }}</textarea>
                                </div>

                                <!-- Question 2: Relationship to Literature -->
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <label for="relationship_to_literature_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                                        2. Relationship to Literature
                                    </label>
                                    <p class="text-xs text-gray-600 mb-3 italic">Does the paper demonstrate an adequate understanding of the relevant literature in the field and cite an appropriate range of literature sources? Is any significant work ignored?</p>
                                    <textarea name="relationship_to_literature_comment" 
                                              id="relationship_to_literature_comment" 
                                              rows="4"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ old('relationship_to_literature_comment', $review->relationship_to_literature_comment) }}</textarea>
                                </div>

                                <!-- Question 3: Methodology -->
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <label for="methodology_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                                        3. Methodology
                                    </label>
                                    <p class="text-xs text-gray-600 mb-3 italic">Is the paper's argument built on an appropriate base of theory, concepts, or other ideas? Has the research or equivalent intellectual work on which the paper is based been well designed? Are the methods employed appropriate?</p>
                                    <textarea name="methodology_comment" 
                                              id="methodology_comment" 
                                              rows="4"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ old('methodology_comment', $review->methodology_comment) }}</textarea>
                                </div>

                                <!-- Question 4: Results -->
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <label for="results_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                                        4. Results
                                    </label>
                                    <p class="text-xs text-gray-600 mb-3 italic">Are results presented clearly and analyzed appropriately? Do the conclusions adequately tie together the other elements of the paper?</p>
                                    <textarea name="results_comment" 
                                              id="results_comment" 
                                              rows="4"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ old('results_comment', $review->results_comment) }}</textarea>
                                </div>

                                <!-- Question 5: Implications -->
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <label for="implications_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                                        5. Implications for research, practice and society
                                    </label>
                                    <p class="text-xs text-gray-600 mb-3 italic">Does the paper clearly identify any implications for research, practice and society? Does the paper bridge the gap between theory and practice? How can the research be used in practice (economic and commercial impact), teaching, influencing public policy, and research (contributing to the body of knowledge)? What is the impact on society (influencing public attitudes and quality of life)? Are these implications consistent with the findings and conclusions of the paper?</p>
                                    <textarea name="implications_comment" 
                                              id="implications_comment" 
                                              rows="4"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ old('implications_comment', $review->implications_comment) }}</textarea>
                                </div>

                                <!-- Question 6: Quality of Communication -->
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <label for="quality_of_communication_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                                        6. Quality of Communication
                                    </label>
                                    <p class="text-xs text-gray-600 mb-3 italic">Does the paper clearly express its case, measured against the technical language of the field and the expected knowledge of the journal's readership? Has attention been paid to the clarity of expression and readability, such as sentence structure, jargon use, acronyms, etc.?</p>
                                    <textarea name="quality_of_communication_comment" 
                                              id="quality_of_communication_comment" 
                                              rows="4"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ old('quality_of_communication_comment', $review->quality_of_communication_comment) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Strengths and Weaknesses Section -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-green-50 to-blue-50">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i data-lucide="thumbs-up" class="w-5 h-5 mr-2 text-green-600"></i>
                                Strengths and Weaknesses
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="strengths" class="block text-sm font-semibold text-gray-900 mb-2">
                                        Strengths
                                    </label>
                                    <textarea name="strengths" 
                                              id="strengths" 
                                              rows="5"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('strengths', $review->strengths) }}</textarea>
                                </div>
                                <div>
                                    <label for="weaknesses" class="block text-sm font-semibold text-gray-900 mb-2">
                                        Weaknesses
                                    </label>
                                    <textarea name="weaknesses" 
                                              id="weaknesses" 
                                              rows="5"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('weaknesses', $review->weaknesses) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Suggestions for Improvement Section -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-yellow-50 to-orange-50">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i data-lucide="lightbulb" class="w-5 h-5 mr-2 text-yellow-600"></i>
                                Suggestions for Improvement
                            </h4>
                            <textarea name="suggestions_for_improvement" 
                                      id="suggestions_for_improvement" 
                                      rows="5"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">{{ old('suggestions_for_improvement', $review->suggestions_for_improvement) }}</textarea>
                        </div>

                        <!-- Paper Score Section -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-purple-50 to-pink-50">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i data-lucide="award" class="w-5 h-5 mr-2 text-purple-600"></i>
                                Paper Score (Ten-point System)
                            </h4>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="relevance_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                            Relevance <span class="text-gray-500 font-normal">(Out of 5)</span>
                                        </label>
                                        <input type="number" 
                                               name="relevance_score" 
                                               id="relevance_score" 
                                               value="{{ old('relevance_score', $review->relevance_score) }}"
                                               min="0" 
                                               max="5" 
                                               step="0.1"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                                    </div>
                                    <div>
                                        <label for="originality_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                            Originality <span class="text-gray-500 font-normal">(Out of 10)</span>
                                        </label>
                                        <input type="number" 
                                               name="originality_score" 
                                               id="originality_score" 
                                               value="{{ old('originality_score', $review->originality_score) }}"
                                               min="0" 
                                               max="10" 
                                               step="0.1"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                                    </div>
                                    <div>
                                        <label for="significance_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                            Significance <span class="text-gray-500 font-normal">(Out of 15)</span>
                                        </label>
                                        <input type="number" 
                                               name="significance_score" 
                                               id="significance_score" 
                                               value="{{ old('significance_score', $review->significance_score) }}"
                                               min="0" 
                                               max="15" 
                                               step="0.1"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                                    </div>
                                    <div>
                                        <label for="technical_soundness_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                            Technical Soundness <span class="text-gray-500 font-normal">(Out of 15)</span>
                                        </label>
                                        <input type="number" 
                                               name="technical_soundness_score" 
                                               id="technical_soundness_score" 
                                               value="{{ old('technical_soundness_score', $review->technical_soundness_score) }}"
                                               min="0" 
                                               max="15" 
                                               step="0.1"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                                    </div>
                                    <div>
                                        <label for="clarity_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                            Clarity of Presentation/Language <span class="text-gray-500 font-normal">(Out of 10)</span>
                                        </label>
                                        <input type="number" 
                                               name="clarity_score" 
                                               id="clarity_score" 
                                               value="{{ old('clarity_score', $review->clarity_score) }}"
                                               min="0" 
                                               max="10" 
                                               step="0.1"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                                    </div>
                                    <div>
                                        <label for="documentation_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                            Overall Documentation and APA/Chicago <span class="text-gray-500 font-normal">(Out of 5)</span>
                                        </label>
                                        <input type="number" 
                                               name="documentation_score" 
                                               id="documentation_score" 
                                               value="{{ old('documentation_score', $review->documentation_score) }}"
                                               min="0" 
                                               max="5" 
                                               step="0.1"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                                    </div>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <label for="total_score" class="block text-sm font-bold text-gray-900 mb-2">
                                        Total Score <span class="text-gray-500 font-normal">(Out of 60)</span>
                                    </label>
                                    <input type="number" 
                                           name="total_score" 
                                           id="total_score" 
                                           value="{{ old('total_score', $review->total_score) }}"
                                           min="0" 
                                           max="60" 
                                           step="0.1"
                                           readonly
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 font-bold text-lg text-purple-600">
                                    <p class="mt-1 text-xs text-gray-500">This will be automatically calculated based on the scores above.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Final Evaluation Section -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-indigo-50 to-blue-50">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i data-lucide="star" class="w-5 h-5 mr-2 text-indigo-600"></i>
                                Final Evaluation
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="final_evaluation" value="excellent" {{ old('final_evaluation', $review->final_evaluation) === 'excellent' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">Excellent</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="final_evaluation" value="very_good" {{ old('final_evaluation', $review->final_evaluation) === 'very_good' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">Very Good</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="final_evaluation" value="fair" {{ old('final_evaluation', $review->final_evaluation) === 'fair' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">Fair</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="final_evaluation" value="poor" {{ old('final_evaluation', $review->final_evaluation) === 'poor' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">Poor</span>
                                </label>
                            </div>
                        </div>

                        <!-- Recommendation Section -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-red-50 to-pink-50">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i data-lucide="check-circle" class="w-5 h-5 mr-2 text-red-600"></i>
                                Recommendation
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="recommendation" value="acceptance" {{ old('recommendation', $review->recommendation) === 'acceptance' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">Acceptance</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="recommendation" value="minor_revision" {{ old('recommendation', $review->recommendation) === 'minor_revision' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">Minor Revision</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="recommendation" value="major_revision" {{ old('recommendation', $review->recommendation) === 'major_revision' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">Major Revision</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="recommendation" value="rejection" {{ old('recommendation', $review->recommendation) === 'rejection' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">Rejection</span>
                                </label>
                            </div>
                        </div>

                        <!-- Additional Fields (Rating and Plagiarism) -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-white">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i data-lucide="settings" class="w-5 h-5 mr-2 text-gray-600"></i>
                                Additional Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">
                                        Overall Rating (0-10) <span class="text-gray-500">(Optional)</span>
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
                                <div>
                                    <label for="plagiarism_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                                        Plagiarism Percentage <span class="text-gray-500">(Optional)</span>
                                    </label>
                                    <div class="flex items-center space-x-4">
                                        <input type="number" 
                                               name="plagiarism_percentage" 
                                               id="plagiarism_percentage" 
                                               value="{{ old('plagiarism_percentage', $review->plagiarism_percentage) }}"
                                               min="0" 
                                               max="100" 
                                               step="0.01"
                                               class="w-32 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('plagiarism_percentage') border-red-500 @enderror">
                                        <span class="text-sm text-gray-600">%</span>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Enter the plagiarism percentage detected (0-100%)</p>
                                    @error('plagiarism_percentage')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- General Comments Field (Optional) -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-white">
                            <label for="comments" class="block text-sm font-medium text-gray-700 mb-2">
                                General Review Comments <span class="text-gray-500">(Optional)</span>
                            </label>
                            <!-- Rich Text Editor Container -->
                            <div id="editor-container" class="bg-white border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-purple-500 focus-within:border-purple-500" style="min-height: 300px;"></div>
                            <!-- Hidden textarea to store HTML content -->
                            <textarea name="comments" 
                                      id="comments" 
                                      style="display: none;">{{ old('comments', $review->comments) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Additional general comments (optional). Use the formatting toolbar to style your text.</p>
                        </div>

                        </div>
                        <!-- End Detailed Review Format -->

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
            <div class="space-y-6">
                <!-- Review Status Header -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Review Details</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                            Review Completed
                        </span>
                    </div>
                </div>

                <!-- General Comments Section -->
                @if($review->originality_comment || $review->relationship_to_literature_comment || $review->methodology_comment || $review->results_comment || $review->implications_comment || $review->quality_of_communication_comment)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i data-lucide="file-text" class="w-5 h-5 mr-2 text-purple-600"></i>
                        General Comments
                    </h4>
                    <div class="space-y-4">
                        @if($review->originality_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">1. Originality</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->originality_comment }}</p>
                        </div>
                        @endif
                        @if($review->relationship_to_literature_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">2. Relationship to Literature</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->relationship_to_literature_comment }}</p>
                        </div>
                        @endif
                        @if($review->methodology_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">3. Methodology</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->methodology_comment }}</p>
                        </div>
                        @endif
                        @if($review->results_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">4. Results</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->results_comment }}</p>
                        </div>
                        @endif
                        @if($review->implications_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">5. Implications for research, practice and society</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->implications_comment }}</p>
                        </div>
                        @endif
                        @if($review->quality_of_communication_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">6. Quality of Communication</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->quality_of_communication_comment }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Strengths and Weaknesses -->
                @if($review->strengths || $review->weaknesses)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i data-lucide="thumbs-up" class="w-5 h-5 mr-2 text-green-600"></i>
                        Strengths and Weaknesses
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($review->strengths)
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">Strengths</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->strengths }}</p>
                        </div>
                        @endif
                        @if($review->weaknesses)
                        <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">Weaknesses</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->weaknesses }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Suggestions for Improvement -->
                @if($review->suggestions_for_improvement)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i data-lucide="lightbulb" class="w-5 h-5 mr-2 text-yellow-600"></i>
                        Suggestions for Improvement
                    </h4>
                    <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->suggestions_for_improvement }}</p>
                    </div>
                </div>
                @endif

                <!-- Paper Score -->
                @if($review->total_score !== null || $review->relevance_score !== null || $review->originality_score !== null)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i data-lucide="award" class="w-5 h-5 mr-2 text-purple-600"></i>
                        Paper Score
                    </h4>
                    <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                            @if($review->relevance_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">Relevance</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->relevance_score, 1) }}/5</p>
                            </div>
                            @endif
                            @if($review->originality_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">Originality</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->originality_score, 1) }}/10</p>
                            </div>
                            @endif
                            @if($review->significance_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">Significance</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->significance_score, 1) }}/15</p>
                            </div>
                            @endif
                            @if($review->technical_soundness_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">Technical Soundness</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->technical_soundness_score, 1) }}/15</p>
                            </div>
                            @endif
                            @if($review->clarity_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">Clarity</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->clarity_score, 1) }}/10</p>
                            </div>
                            @endif
                            @if($review->documentation_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">Documentation</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->documentation_score, 1) }}/5</p>
                            </div>
                            @endif
                        </div>
                        @if($review->total_score !== null)
                        <div class="border-t border-purple-300 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-900">Total Score</span>
                                <span class="text-2xl font-bold text-purple-600">{{ number_format($review->total_score, 1) }}/60</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Final Evaluation and Recommendation -->
                @if($review->final_evaluation || $review->recommendation)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i data-lucide="star" class="w-5 h-5 mr-2 text-indigo-600"></i>
                        Evaluation & Recommendation
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($review->final_evaluation)
                        <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-200">
                            <span class="text-xs text-gray-600">Final Evaluation</span>
                            <p class="text-lg font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $review->final_evaluation) }}</p>
                        </div>
                        @endif
                        @if($review->recommendation)
                        <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                            <span class="text-xs text-gray-600">Recommendation</span>
                            <p class="text-lg font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $review->recommendation) }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- General Comments -->
                @if($review->comments)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">General Review Comments</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-700 ql-editor" style="padding: 0;">
                            {!! $review->comments !!}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Plagiarism Percentage -->
                @if($review->plagiarism_percentage !== null)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 border border-orange-200 rounded-lg">
                        <div class="flex items-center space-x-2 mb-2">
                            <i data-lucide="file-search" class="w-5 h-5 text-orange-600"></i>
                            <h4 class="text-sm font-semibold text-orange-800">Plagiarism Percentage</h4>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl font-bold {{ $review->plagiarism_percentage > 20 ? 'text-red-600' : ($review->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                {{ number_format($review->plagiarism_percentage, 2) }}%
                            </span>
                            <span class="text-sm text-gray-600">detected</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">This information is visible to the author.</p>
                    </div>
                </div>
                @endif

                <!-- Author Reply -->
                @if($review->author_reply)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center space-x-2 mb-2">
                            <i data-lucide="message-square" class="w-5 h-5 text-green-600"></i>
                            <h4 class="text-sm font-semibold text-green-800">Author's Reply</h4>
                        </div>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $review->author_reply }}</p>
                    </div>
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
                    @if($review->plagiarism_percentage !== null)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Plagiarism Percentage</span>
                        <span class="text-sm font-bold text-gray-900">{{ number_format($review->plagiarism_percentage, 2) }}%</span>
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

    // Toggle between review formats
    function toggleReviewFormat() {
        const detailedFormat = document.getElementById('detailed_review_format');
        const simpleFormat = document.getElementById('simple_review_format');
        const detailedRadio = document.getElementById('review_format_detailed');
        const simpleRadio = document.getElementById('review_format_simple');

        if (detailedRadio && detailedRadio.checked) {
            detailedFormat.classList.remove('hidden');
            simpleFormat.classList.add('hidden');
            
            // Sync values from simple to detailed
            const ratingSimple = document.getElementById('rating_simple');
            const ratingDetailed = document.getElementById('rating');
            const plagiarismSimple = document.getElementById('plagiarism_percentage_simple');
            const plagiarismDetailed = document.getElementById('plagiarism_percentage');
            
            if (ratingSimple && ratingDetailed && ratingSimple.value) {
                ratingDetailed.value = ratingSimple.value;
            }
            if (plagiarismSimple && plagiarismDetailed && plagiarismSimple.value) {
                plagiarismDetailed.value = plagiarismSimple.value;
            }
        } else if (simpleRadio && simpleRadio.checked) {
            detailedFormat.classList.add('hidden');
            simpleFormat.classList.remove('hidden');
            
            // Sync values from detailed to simple
            const ratingDetailed = document.getElementById('rating');
            const ratingSimple = document.getElementById('rating_simple');
            const plagiarismDetailed = document.getElementById('plagiarism_percentage');
            const plagiarismSimple = document.getElementById('plagiarism_percentage_simple');
            
            if (ratingDetailed && ratingSimple && ratingDetailed.value) {
                ratingSimple.value = ratingDetailed.value;
            }
            if (plagiarismDetailed && plagiarismSimple && plagiarismDetailed.value) {
                plagiarismSimple.value = plagiarismDetailed.value;
            }
        }
    }

    // Initialize Quill Rich Text Editor
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize toggle on page load
        toggleReviewFormat();

        // Store Quill instances globally for form submission
        let quillDetailed = null;
        let quillSimple = null;

        // Initialize Quill Rich Text Editor for Detailed Format
        const editorContainer = document.getElementById('editor-container');
        const hiddenTextarea = document.getElementById('comments');
        
        if (editorContainer && hiddenTextarea && typeof Quill !== 'undefined') {
            try {
                // Initialize Quill editor
                quillDetailed = new Quill('#editor-container', {
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
                placeholder: 'Additional general comments (optional). Use the formatting toolbar to style your text.'
            });

            // Set initial content if there's old input or existing review
            const initialContent = hiddenTextarea.value;
            if (initialContent) {
                // Check if it's HTML or plain text
                if (initialContent.trim().startsWith('<')) {
                    quillDetailed.root.innerHTML = initialContent;
                } else {
                    quillDetailed.setText(initialContent);
                }
            }

            // Update hidden textarea when content changes
            quillDetailed.on('text-change', function() {
                const html = quillDetailed.root.innerHTML;
                const text = quillDetailed.getText().trim();
                
                // Update hidden textarea with HTML
                hiddenTextarea.value = html;
            });

            // Note: Form submission is handled in a unified handler below

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
            } catch (error) {
                console.error('Error initializing detailed Quill editor:', error);
            }
        }

        // Initialize Quill Rich Text Editor for Simple Format
        const editorContainerSimple = document.getElementById('editor-container-simple');
        const hiddenTextareaSimple = document.getElementById('comments_simple');
        
        if (editorContainerSimple && hiddenTextareaSimple && typeof Quill !== 'undefined') {
            try {
                // Initialize Quill editor
                quillSimple = new Quill('#editor-container-simple', {
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
                placeholder: 'Write your review comments here. Please provide constructive feedback on the article\'s strengths, weaknesses, methodology, writing quality, and suggestions for improvement. (Minimum 10 characters)'
            });

            // Set initial content if there's old input or existing review
            const initialContentSimple = hiddenTextareaSimple.value;
            if (initialContentSimple) {
                // Check if it's HTML or plain text
                if (initialContentSimple.trim().startsWith('<')) {
                    quillSimple.root.innerHTML = initialContentSimple;
                } else {
                    quillSimple.setText(initialContentSimple);
                }
            }

            // Update hidden textarea when content changes
            quillSimple.on('text-change', function() {
                const html = quillSimple.root.innerHTML;
                const text = quillSimple.getText().trim();
                
                // Update hidden textarea with HTML
                hiddenTextareaSimple.value = html;
                
                // Validate minimum length
                if (text.length < 10) {
                    hiddenTextareaSimple.setCustomValidity('Review comments must be at least 10 characters long.');
                } else {
                    hiddenTextareaSimple.setCustomValidity('');
                }
            });

            // Note: Form submission is handled in a unified handler below
            } catch (error) {
                console.error('Error initializing simple Quill editor:', error);
            }
        }

        // Auto-calculate total score
        function calculateTotalScore() {
            const relevance = parseFloat(document.getElementById('relevance_score')?.value || 0);
            const originality = parseFloat(document.getElementById('originality_score')?.value || 0);
            const significance = parseFloat(document.getElementById('significance_score')?.value || 0);
            const technicalSoundness = parseFloat(document.getElementById('technical_soundness_score')?.value || 0);
            const clarity = parseFloat(document.getElementById('clarity_score')?.value || 0);
            const documentation = parseFloat(document.getElementById('documentation_score')?.value || 0);
            
            const total = relevance + originality + significance + technicalSoundness + clarity + documentation;
            
            const totalScoreInput = document.getElementById('total_score');
            if (totalScoreInput) {
                totalScoreInput.value = total.toFixed(1);
            }
        }

        // Add event listeners to all score inputs
        const scoreInputs = document.querySelectorAll('.score-input');
        scoreInputs.forEach(input => {
            input.addEventListener('input', calculateTotalScore);
            input.addEventListener('change', calculateTotalScore);
        });

        // Calculate initial total score on page load
        calculateTotalScore();

        // Sync rating and plagiarism fields between formats
        const ratingDetailed = document.getElementById('rating');
        const ratingSimple = document.getElementById('rating_simple');
        const plagiarismDetailed = document.getElementById('plagiarism_percentage');
        const plagiarismSimple = document.getElementById('plagiarism_percentage_simple');

        if (ratingDetailed && ratingSimple) {
            ratingDetailed.addEventListener('input', function() {
                ratingSimple.value = this.value;
            });
            ratingSimple.addEventListener('input', function() {
                ratingDetailed.value = this.value;
            });
        }

        if (plagiarismDetailed && plagiarismSimple) {
            plagiarismDetailed.addEventListener('input', function() {
                plagiarismSimple.value = this.value;
            });
            plagiarismSimple.addEventListener('input', function() {
                plagiarismDetailed.value = this.value;
            });
        }

        // Unified form submission handler
        const form = document.getElementById('reviewForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const simpleFormatChecked = document.getElementById('review_format_simple')?.checked;
                const hiddenTextarea = document.getElementById('comments');
                const hiddenTextareaSimple = document.getElementById('comments_simple');
                
                // Sync content from Quill editors based on active format
                if (simpleFormatChecked && quillSimple) {
                    // Simple format is active - comments are required
                    const html = quillSimple.root.innerHTML;
                    const text = quillSimple.getText().trim();
                    
                    // Update both textareas
                    if (hiddenTextareaSimple) {
                        hiddenTextareaSimple.value = html;
                    }
                    if (hiddenTextarea) {
                        hiddenTextarea.value = html;
                    }
                    
                    // Validate minimum length for simple format
                    if (text.length < 10) {
                        e.preventDefault();
                        alert('Review comments must be at least 10 characters long.');
                        return false;
                    }
                } else if (quillDetailed) {
                    // Detailed format is active - comments are optional
                    const html = quillDetailed.root.innerHTML;
                    const text = quillDetailed.getText().trim();
                    
                    // Only set value if there's actual content (not just empty HTML)
                    if (text.length > 0) {
                        if (hiddenTextarea) {
                            hiddenTextarea.value = html;
                        }
                        // Also sync to simple format textarea
                        if (hiddenTextareaSimple) {
                            hiddenTextareaSimple.value = html;
                        }
                    } else {
                        // Empty content - set empty string
                        if (hiddenTextarea) {
                            hiddenTextarea.value = '';
                        }
                        if (hiddenTextareaSimple) {
                            hiddenTextareaSimple.value = '';
                        }
                    }
                } else {
                    // No Quill editor initialized - ensure textareas are empty or have existing values
                    // This shouldn't happen, but handle it gracefully
                    console.warn('No Quill editor found');
                }
            });
        }
    });
</script>
@endsection

