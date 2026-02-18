@extends('layout.app_reviewer')

@section('title', __('Review Details'))
@section('page-title', __('Review Details'))
@section('page-description', __('View detailed review information'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <a href="{{ route('reviewer.dashboard') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Dashboard') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('reviewer.reviews.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Reviews') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ __('Details') }}</span>
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
                                {{ __('Completed') }}
                            </span>
                        @elseif($review->comments)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i data-lucide="edit" class="w-4 h-4 mr-1"></i>
                                {{ __('In Progress') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i data-lucide="clock" class="w-4 h-4 mr-1"></i>
                                {{ __('Pending') }}
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
                        <span class="text-sm text-gray-500">{{ __('Assigned') }}: {{ $review->created_at?->format('M d, Y') ?? __('N/A') }}</span>
                        @if($review->review_date)
                        <span class="text-sm text-gray-500">{{ __('Deadline') }}: {{ \Carbon\Carbon::parse($review->review_date)->format('M d, Y') }}</span>
                        @endif
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $review->submission->article->title ?? __('Untitled Article') }}</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            <span>{{ $review->submission->article->journal->name ?? __('Unknown Journal') }}</span>
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
                            <h3 class="text-lg font-bold text-gray-900">{{ __('Review Format Document') }}</h3>
                            <p class="text-sm text-gray-600">{{ __('Download the review format guide') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('review.format.download', ['file' => basename($review->reviewer->review_format_file)]) }}" 
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-colors">
                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                        {{ __('Download Format') }}
                    </a>
                </div>
            </div>
            @endif

            <!-- Article Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Article Information') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Title') }}</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $review->submission->article->title ?? __('Untitled Article') }}</p>
                    </div>
                    @if($review->submission->article->abstract)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Abstract') }}</label>
                        <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $review->submission->article->abstract }}</p>
                    </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Journal') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->article->journal->name ?? __('Unknown Journal') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Category') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->article->category->name ?? __('Uncategorized') }}</p>
                        </div>
                    </div>
                    @if($review->submission->article->word_count)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Word Count') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ number_format($review->submission->article->word_count) }}</p>
                        </div>
                        @if($review->submission->article->number_of_tables)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Tables') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->article->number_of_tables }}</p>
                        </div>
                        @endif
                        @if($review->submission->article->number_of_figures)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Figures') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->article->number_of_figures }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Submission Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Submission Information') }}</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Submission Date') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->submission_date?->format('M d, Y') ?? __('N/A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Version') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->submission->version_number ?? __('N/A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Status') }}</label>
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
                        <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Manuscript File') }}</label>
                        <a href="{{ asset('storage/' . $review->submission->file_path) }}" target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                            {{ __('View File') }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Previous Review Comments -->
            @if(isset($previousReviews) && $previousReviews->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Previous Review Comments') }}</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i data-lucide="history" class="w-4 h-4 mr-1"></i>
                        {{ $previousReviews->count() }} {{ __('Previous Review(s)') }}
                    </span>
                </div>
                <div class="space-y-4">
                    @foreach($previousReviews as $prevReview)
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200 bg-white">
                        <!-- Version Header (Collapsible) -->
                        <button type="button" 
                                onclick="togglePreviousReviewDetails({{ $prevReview->id }})"
                                class="w-full p-4 text-left hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gray-400 rounded-lg flex items-center justify-center">
                                        <span class="text-lg font-bold text-white">V{{ $prevReview->submission->version_number ?? __('N/A') }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="text-base font-semibold text-gray-900">{{ __('Version') }} {{ $prevReview->submission->version_number ?? __('N/A') }}</h4>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ __('Submitted on') }} {{ $prevReview->submission->submission_date?->format('F d, Y \a\t h:i A') ?? __('N/A') }}
                                        </p>
                                        <div class="mt-2">
                                            @php
                                                $statusColors = [
                                                    'submitted' => 'bg-blue-100 text-blue-800',
                                                    'under_review' => 'bg-yellow-100 text-yellow-800',
                                                    'revision_required' => 'bg-orange-100 text-orange-800',
                                                    'pending_verify' => 'bg-purple-100 text-purple-800',
                                                    'verified' => 'bg-emerald-100 text-emerald-800',
                                                    'accepted' => 'bg-green-100 text-green-800',
                                                    'published' => 'bg-purple-100 text-purple-800',
                                                    'rejected' => 'bg-red-100 text-red-800',
                                                ];
                                                $statusColor = $statusColors[$prevReview->submission->status ?? 'submitted'] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $prevReview->submission->status ?? 'unknown')) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                                    @if($prevReview->submission->file_path)
                                    <a href="{{ asset('storage/' . $prevReview->submission->file_path) }}" target="_blank"
                                        onclick="event.stopPropagation();"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                        {{ __('Download') }}
                                    </a>
                                    @endif
                                    <i data-lucide="chevron-down" id="prev-review-icon-{{ $prevReview->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                </div>
                            </div>
                        </button>

                        <!-- Review Details (Collapsible Content) -->
                        <div id="prev-review-details-{{ $prevReview->id }}" class="hidden border-t border-gray-200">
                            <!-- Reviewer Comments Header -->
                            <div class="bg-gray-50 px-4 py-3">
                                <h5 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2 text-indigo-600"></i>
                                    {{ __('Reviewer Comments') }} (1)
                                </h5>
                            </div>
                            
                            <div class="px-4 pb-4 space-y-3">
                                <!-- Review Header -->
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                    <button type="button" 
                                            onclick="togglePrevReviewContent({{ $prevReview->id }})"
                                            class="w-full px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors text-left">
                                        <div class="flex items-center space-x-3 flex-1">
                                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i data-lucide="user-check" class="w-5 h-5 text-white"></i>
                                            </div>
                                            <div class="flex-1 text-left">
                                                <p class="text-sm font-semibold text-gray-900">{{ __('Reviewer') }}</p>
                                                <p class="text-xs text-gray-500">{{ $prevReview->updated_at?->format('F d, Y \a\t h:i A') ?? __('N/A') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            @if($prevReview->recommendation)
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                                                $prevReview->recommendation === 'acceptance' ? 'bg-green-100 text-green-800' : 
                                                ($prevReview->recommendation === 'minor_revision' ? 'bg-blue-100 text-blue-800' : 
                                                ($prevReview->recommendation === 'major_revision' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')) 
                                            }}">
                                                {{ ucfirst(str_replace('_', ' ', $prevReview->recommendation)) }}
                                            </span>
                                            @endif
                                            @if($prevReview->rating)
                                            <div class="flex items-center space-x-1">
                                                <span class="text-sm font-bold text-gray-900">{{ $prevReview->rating }}/10</span>
                                                <div class="flex space-x-0.5">
                                                    @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= ($prevReview->rating / 2) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endif
                                            <i data-lucide="chevron-down" id="prev-review-content-icon-{{ $prevReview->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                        </div>
                                    </button>
                                    
                                    <!-- Review Content (Collapsible) -->
                                    <div id="prev-review-content-{{ $prevReview->id }}" class="hidden px-4 pb-4 space-y-3">
                                        <!-- Quick Summary Cards -->
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                            @if($prevReview->final_evaluation)
                                            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-2">
                                                <p class="text-xs text-gray-600 mb-1">{{ __('Evaluation') }}</p>
                                                <p class="text-sm font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $prevReview->final_evaluation) }}</p>
                                            </div>
                                            @endif
                                            @if($prevReview->total_score !== null)
                                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-2">
                                                <p class="text-xs text-gray-600 mb-1">{{ __('Total Score') }}</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($prevReview->total_score, 1) }}/60</p>
                                            </div>
                                            @endif
                                            @if($prevReview->recommendation)
                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-2">
                                                <p class="text-xs text-gray-600 mb-1">{{ __('Recommendation') }}</p>
                                                <p class="text-sm font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $prevReview->recommendation) }}</p>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- General Comments (6 Questions) -->
                                        @if($prevReview->originality_comment || $prevReview->relationship_to_literature_comment || $prevReview->methodology_comment || $prevReview->results_comment || $prevReview->implications_comment || $prevReview->quality_of_communication_comment)
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                            <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                <i data-lucide="file-text" class="w-3 h-3 mr-1"></i>
                                                {{ __('General Comments') }}
                                            </h6>
                                            <div class="space-y-2 text-xs">
                                                @if($prevReview->originality_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">1. {{ __('Originality') }}</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $prevReview->originality_comment }}</p>
                                                </div>
                                                @endif
                                                @if($prevReview->relationship_to_literature_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">2. {{ __('Relationship to Literature') }}</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $prevReview->relationship_to_literature_comment }}</p>
                                                </div>
                                                @endif
                                                @if($prevReview->methodology_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">3. {{ __('Methodology') }}</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $prevReview->methodology_comment }}</p>
                                                </div>
                                                @endif
                                                @if($prevReview->results_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">4. {{ __('Results') }}</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $prevReview->results_comment }}</p>
                                                </div>
                                                @endif
                                                @if($prevReview->implications_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">5. {{ __('Implications') }}</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $prevReview->implications_comment }}</p>
                                                </div>
                                                @endif
                                                @if($prevReview->quality_of_communication_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">6. {{ __('Quality of Communication') }}</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $prevReview->quality_of_communication_comment }}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Strengths and Weaknesses -->
                                        @if($prevReview->strengths || $prevReview->weaknesses)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            @if($prevReview->strengths)
                                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                                <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                    <i data-lucide="thumbs-up" class="w-3 h-3 mr-1 text-green-600"></i>
                                                    {{ __('Strengths') }}
                                                </h6>
                                                <p class="text-xs text-gray-700 whitespace-pre-wrap">{{ $prevReview->strengths }}</p>
                                            </div>
                                            @endif
                                            @if($prevReview->weaknesses)
                                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                                <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                    <i data-lucide="thumbs-down" class="w-3 h-3 mr-1 text-red-600"></i>
                                                    {{ __('Weaknesses') }}
                                                </h6>
                                                <p class="text-xs text-gray-700 whitespace-pre-wrap">{{ $prevReview->weaknesses }}</p>
                                            </div>
                                            @endif
                                        </div>
                                        @endif

                                        <!-- Suggestions for Improvement -->
                                        @if($prevReview->suggestions_for_improvement)
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                            <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                <i data-lucide="lightbulb" class="w-3 h-3 mr-1 text-yellow-600"></i>
                                                {{ __('Suggestions for Improvement') }}
                                            </h6>
                                            <p class="text-xs text-gray-700 whitespace-pre-wrap">{{ $prevReview->suggestions_for_improvement }}</p>
                                        </div>
                                        @endif

                                        <!-- Paper Score -->
                                        @if($prevReview->relevance_score !== null || $prevReview->originality_score !== null || $prevReview->significance_score !== null || $prevReview->technical_soundness_score !== null || $prevReview->clarity_score !== null || $prevReview->documentation_score !== null)
                                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                                            <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                <i data-lucide="award" class="w-3 h-3 mr-1 text-purple-600"></i>
                                                {{ __('Paper Score') }}
                                            </h6>
                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs">
                                                @if($prevReview->relevance_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">{{ __('Relevance') }}</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($prevReview->relevance_score, 1) }}/5</p>
                                                </div>
                                                @endif
                                                @if($prevReview->originality_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">{{ __('Originality') }}</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($prevReview->originality_score, 1) }}/10</p>
                                                </div>
                                                @endif
                                                @if($prevReview->significance_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">{{ __('Significance') }}</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($prevReview->significance_score, 1) }}/15</p>
                                                </div>
                                                @endif
                                                @if($prevReview->technical_soundness_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">{{ __('Technical Soundness') }}</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($prevReview->technical_soundness_score, 1) }}/15</p>
                                                </div>
                                                @endif
                                                @if($prevReview->clarity_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">{{ __('Clarity') }}</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($prevReview->clarity_score, 1) }}/10</p>
                                                </div>
                                                @endif
                                                @if($prevReview->documentation_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">{{ __('Documentation') }}</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($prevReview->documentation_score, 1) }}/5</p>
                                                </div>
                                                @endif
                                            </div>
                                            @if($prevReview->total_score !== null)
                                            <div class="mt-2 pt-2 border-t border-purple-300 bg-white rounded p-2">
                                                <div class="flex justify-between items-center">
                                                    <p class="text-xs font-semibold text-gray-900">{{ __('Total Score') }}</p>
                                                    <p class="text-sm font-bold text-purple-600">{{ number_format($prevReview->total_score, 1) }}/60</p>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        @endif

                                        <!-- General Review Comments -->
                                        @if($prevReview->comments)
                                        <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3">
                                            <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                <i data-lucide="message-square" class="w-3 h-3 mr-1"></i>
                                                {{ __('General Review Comments') }}
                                            </h6>
                                            <div class="text-xs text-gray-700 leading-relaxed ql-editor" style="padding: 0;">
                                                {!! $prevReview->comments !!}
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Review File Attachment -->
                                        @if($prevReview->review_file)
                                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                                            <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                <i data-lucide="paperclip" class="w-3 h-3 mr-1 text-purple-600"></i>
                                                {{ __('Attached File') }}
                                            </h6>
                                            <div class="flex items-center justify-between bg-white rounded-lg p-2 border border-purple-200">
                                                <div class="flex items-center space-x-2">
                                                    <i data-lucide="file-text" class="w-4 h-4 text-purple-600"></i>
                                                    <span class="text-xs font-medium text-gray-900">{{ basename($prevReview->review_file) }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $prevReview->review_file) }}" target="_blank"
                                                   class="inline-flex items-center px-2 py-1 bg-purple-600 text-white text-xs font-medium rounded-lg hover:bg-purple-700 transition-colors">
                                                    <i data-lucide="download" class="w-3 h-3 mr-1"></i>
                                                    {{ __('Download') }}
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Author Reply Section -->
                                        @php
                                            $authorReply = $prevReview->author_reply ?? null;
                                            $hasAuthorReply = $authorReply && trim($authorReply) !== '';
                                        @endphp
                                        @if($hasAuthorReply)
                                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-3">
                                            <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                <i data-lucide="message-square" class="w-3 h-3 mr-1 text-green-600"></i>
                                                {{ __('Author\'s Reply') }}
                                            </h6>
                                            <p class="text-xs text-gray-700 whitespace-pre-wrap leading-relaxed">{{ trim($authorReply) }}</p>
                                        </div>
                                        @else
                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                            <p class="text-xs text-gray-500 italic">
                                                <i data-lucide="info" class="w-3 h-3 inline mr-1"></i>
                                                {{ __('You can send a reply to reviewers when you resubmit your article.') }}
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('Write Your Review') }}</h3>
                    <div class="flex items-start space-x-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-sm text-blue-800 font-medium">{{ __('Review Visibility') }}</p>
                            <p class="text-xs text-blue-700 mt-1">{{ __('Your review comments will be visible to the author and editor. Once submitted, the article status will be updated to "Under Review".') }}</p>
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

                <form action="{{ route('reviewer.reviews.update', $review->id) }}" method="POST" id="reviewForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Detailed Review Format -->
                        <div id="detailed_review_format">
                        <!-- General Comments Section -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-blue-50 to-purple-50">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i data-lucide="file-text" class="w-5 h-5 mr-2 text-purple-600"></i>
                                {{ __('General Comments') }}
                            </h4>
                            <p class="text-sm text-gray-600 mb-6">{{ __('Please provide detailed comments for each of the following criteria:') }}</p>
                            
                            <div class="space-y-6">
                                <!-- Question 1: Originality -->
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <label for="originality_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                                        1. {{ __('Originality') }}
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
                                        2. {{ __('Relationship to Literature') }}
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
                                        3. {{ __('Methodology') }}
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
                                        4. {{ __('Results') }}
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
                                        5. {{ __('Implications for research, practice and society') }}
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
                                        6. {{ __('Quality of Communication') }}
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
                                {{ __('Strengths and Weaknesses') }}
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="strengths" class="block text-sm font-semibold text-gray-900 mb-2">
                                        {{ __('Strengths') }}
                                    </label>
                                    <textarea name="strengths" 
                                              id="strengths" 
                                              rows="5"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('strengths', $review->strengths) }}</textarea>
                                </div>
                                <div>
                                    <label for="weaknesses" class="block text-sm font-semibold text-gray-900 mb-2">
                                        {{ __('Weaknesses') }}
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
                                {{ __('Suggestions for Improvement') }}
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
                                {{ __('Paper Score (Ten-point System)') }}
                            </h4>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="relevance_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                            {{ __('Relevance') }} <span class="text-gray-500 font-normal">({{ __('Out of 5') }})</span>
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
                                            {{ __('Originality') }} <span class="text-gray-500 font-normal">({{ __('Out of 10') }})</span>
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
                                            {{ __('Significance') }} <span class="text-gray-500 font-normal">({{ __('Out of 15') }})</span>
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
                                            {{ __('Technical Soundness') }} <span class="text-gray-500 font-normal">({{ __('Out of 15') }})</span>
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
                                            {{ __('Clarity of Presentation/Language') }} <span class="text-gray-500 font-normal">({{ __('Out of 10') }})</span>
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
                                            {{ __('Overall Documentation and APA/Chicago') }} <span class="text-gray-500 font-normal">({{ __('Out of 5') }})</span>
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
                                        {{ __('Total Score') }} <span class="text-gray-500 font-normal">({{ __('Out of 60') }})</span>
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
                                    <p class="mt-1 text-xs text-gray-500">{{ __('This will be automatically calculated based on the scores above.') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Final Evaluation Section -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-indigo-50 to-blue-50">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i data-lucide="star" class="w-5 h-5 mr-2 text-indigo-600"></i>
                                {{ __('Final Evaluation') }}
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="final_evaluation" value="excellent" {{ old('final_evaluation', $review->final_evaluation) === 'excellent' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">{{ __('Excellent') }}</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="final_evaluation" value="very_good" {{ old('final_evaluation', $review->final_evaluation) === 'very_good' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">{{ __('Very Good') }}</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="final_evaluation" value="fair" {{ old('final_evaluation', $review->final_evaluation) === 'fair' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">{{ __('Fair') }}</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="final_evaluation" value="poor" {{ old('final_evaluation', $review->final_evaluation) === 'poor' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">{{ __('Poor') }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Recommendation Section -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-red-50 to-pink-50">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i data-lucide="check-circle" class="w-5 h-5 mr-2 text-red-600"></i>
                                {{ __('Recommendation') }}
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="recommendation" value="acceptance" {{ old('recommendation', $review->recommendation) === 'acceptance' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">{{ __('Acceptance') }}</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="recommendation" value="minor_revision" {{ old('recommendation', $review->recommendation) === 'minor_revision' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">{{ __('Minor Revision') }}</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="recommendation" value="major_revision" {{ old('recommendation', $review->recommendation) === 'major_revision' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">{{ __('Major Revision') }}</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                                    <input type="radio" name="recommendation" value="rejection" {{ old('recommendation', $review->recommendation) === 'rejection' ? 'checked' : '' }} class="mr-2">
                                    <span class="text-sm font-medium text-gray-900">{{ __('Rejection') }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- General Comments Field (Optional) -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-white">
                            <label for="comments" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('General Review Comments') }} <span class="text-gray-500">({{ __('Optional') }})</span>
                            </label>
                            <!-- Rich Text Editor Container -->
                            <div id="editor-container" class="bg-white border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-purple-500 focus-within:border-purple-500" style="min-height: 300px;"></div>
                            <!-- Hidden textarea to store HTML content -->
                            <textarea name="comments" 
                                      id="comments" 
                                      style="display: none;">{{ old('comments', $review->comments) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">{{ __('Additional general comments (optional). Use the formatting toolbar to style your text.') }}</p>
                        </div>

                        <!-- Review File Attachment (Optional) -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-white">
                            <label for="review_file" class="block text-sm font-medium text-gray-700 mb-2">
                                <i data-lucide="paperclip" class="w-4 h-4 inline mr-2"></i>
                                {{ __('Attach File') }} <span class="text-gray-500">({{ __('Optional') }})</span>
                            </label>
                            <div class="space-y-3">
                                @if($review->review_file)
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ basename($review->review_file) }}</p>
                                            <p class="text-xs text-gray-500">{{ __('Current file') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $review->review_file) }}" target="_blank"
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                        <i data-lucide="download" class="w-4 h-4 mr-1"></i>
                                        {{ __('View') }}
                                    </a>
                                </div>
                                <p class="text-xs text-gray-500">{{ __('Upload a new file to replace the existing one.') }}</p>
                                @endif
                                <input type="file" 
                                       name="review_file" 
                                       id="review_file" 
                                       accept=".pdf,.doc,.docx,.txt,.rtf"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                <p class="text-xs text-gray-500 mt-1">{{ __('Supported formats: PDF, DOC, DOCX, TXT, RTF. Maximum file size: 10MB') }}</p>
                            </div>
                        </div>

                        </div>
                        <!-- End Detailed Review Format -->

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('reviewer.reviews.index') }}" 
                               class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors font-medium">
                                <i data-lucide="send" class="w-4 h-4 mr-2 inline"></i>
                                {{ __('Submit Review') }}
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
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Review Details') }}</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                            {{ __('Review Completed') }}
                        </span>
                    </div>
                </div>

                <!-- General Comments Section -->
                @if($review->originality_comment || $review->relationship_to_literature_comment || $review->methodology_comment || $review->results_comment || $review->implications_comment || $review->quality_of_communication_comment)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i data-lucide="file-text" class="w-5 h-5 mr-2 text-purple-600"></i>
                        {{ __('General Comments') }}
                    </h4>
                    <div class="space-y-4">
                        @if($review->originality_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">1. {{ __('Originality') }}</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->originality_comment }}</p>
                        </div>
                        @endif
                        @if($review->relationship_to_literature_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">2. {{ __('Relationship to Literature') }}</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->relationship_to_literature_comment }}</p>
                        </div>
                        @endif
                        @if($review->methodology_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">3. {{ __('Methodology') }}</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->methodology_comment }}</p>
                        </div>
                        @endif
                        @if($review->results_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">4. {{ __('Results') }}</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->results_comment }}</p>
                        </div>
                        @endif
                        @if($review->implications_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">5. {{ __('Implications for research, practice and society') }}</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->implications_comment }}</p>
                        </div>
                        @endif
                        @if($review->quality_of_communication_comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">6. {{ __('Quality of Communication') }}</h5>
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
                        {{ __('Strengths and Weaknesses') }}
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($review->strengths)
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">{{ __('Strengths') }}</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->strengths }}</p>
                        </div>
                        @endif
                        @if($review->weaknesses)
                        <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                            <h5 class="text-sm font-semibold text-gray-900 mb-2">{{ __('Weaknesses') }}</h5>
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
                        {{ __('Suggestions for Improvement') }}
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
                        {{ __('Paper Score') }}
                    </h4>
                    <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                            @if($review->relevance_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">{{ __('Relevance') }}</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->relevance_score, 1) }}/5</p>
                            </div>
                            @endif
                            @if($review->originality_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">{{ __('Originality') }}</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->originality_score, 1) }}/10</p>
                            </div>
                            @endif
                            @if($review->significance_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">{{ __('Significance') }}</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->significance_score, 1) }}/15</p>
                            </div>
                            @endif
                            @if($review->technical_soundness_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">{{ __('Technical Soundness') }}</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->technical_soundness_score, 1) }}/15</p>
                            </div>
                            @endif
                            @if($review->clarity_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">{{ __('Clarity') }}</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->clarity_score, 1) }}/10</p>
                            </div>
                            @endif
                            @if($review->documentation_score !== null)
                            <div>
                                <span class="text-xs text-gray-600">{{ __('Documentation') }}</span>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($review->documentation_score, 1) }}/5</p>
                            </div>
                            @endif
                        </div>
                        @if($review->total_score !== null)
                        <div class="border-t border-purple-300 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-900">{{ __('Total Score') }}</span>
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
                        {{ __('Evaluation & Recommendation') }}
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($review->final_evaluation)
                        <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-200">
                            <span class="text-xs text-gray-600">{{ __('Final Evaluation') }}</span>
                            <p class="text-lg font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $review->final_evaluation) }}</p>
                        </div>
                        @endif
                        @if($review->recommendation)
                        <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                            <span class="text-xs text-gray-600">{{ __('Recommendation') }}</span>
                            <p class="text-lg font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $review->recommendation) }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- General Comments -->
                @if($review->comments)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">{{ __('General Review Comments') }}</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-700 ql-editor" style="padding: 0;">
                            {!! $review->comments !!}
                        </div>
                    </div>
                </div>
                @endif


                <!-- Author Reply -->
                @if($review->author_reply)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center space-x-2 mb-2">
                            <i data-lucide="message-square" class="w-5 h-5 text-green-600"></i>
                            <h4 class="text-sm font-semibold text-green-800">{{ __('Author\'s Reply') }}</h4>
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
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Review Status') }}</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Status') }}</span>
                        @if($review->rating)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ __('Completed') }}
                            </span>
                        @elseif($review->comments)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ __('In Progress') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ __('Pending') }}
                            </span>
                        @endif
                    </div>
                    @if($review->rating)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Rating') }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $review->rating }}/10</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Assigned') }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $review->created_at?->format('M d, Y') ?? __('N/A') }}</span>
                    </div>
                    @if($review->review_date)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Deadline') }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($review->review_date)->format('M d, Y') }}</span>
                    </div>
                    @endif
                    @if($review->updated_at)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Last Updated') }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $review->updated_at?->format('M d, Y') ?? __('N/A') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Actions') }}</h3>
                <div class="space-y-3">
                    <a href="{{ route('reviewer.reviews.index') }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        {{ __('Back to Reviews') }}
                    </a>
                    @if(!$review->rating)
                    <div class="text-xs text-gray-500 text-center mt-2">
                        <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                        {{ __('Scroll down to write your review') }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Review Timeline -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Timeline') }}</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                            <i data-lucide="file-text" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ __('Review Assigned') }}</p>
                            <p class="text-xs text-gray-500">{{ $review->created_at?->format('M d, Y H:i') ?? __('N/A') }}</p>
                        </div>
                    </div>
                    @if($review->comments && $review->updated_at && $review->updated_at->ne($review->created_at))
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
                            <i data-lucide="edit" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ __('Comments Added') }}</p>
                            <p class="text-xs text-gray-500">{{ $review->updated_at?->format('M d, Y H:i') ?? __('N/A') }}</p>
                        </div>
                    </div>
                    @endif
                    @if($review->rating)
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ __('Review Completed') }}</p>
                            <p class="text-xs text-gray-500">{{ $review->updated_at?->format('M d, Y H:i') ?? __('N/A') }}</p>
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
        // Store Quill instance globally for form submission
        let quillDetailed = null;

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

        // Form submission handler
        const form = document.getElementById('reviewForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const hiddenTextarea = document.getElementById('comments');
                
                // Sync content from Quill editor
                if (quillDetailed) {
                    // Detailed format is active - comments are optional
                    const html = quillDetailed.root.innerHTML;
                    const text = quillDetailed.getText().trim();
                    
                    // Only set value if there's actual content (not just empty HTML)
                    if (text.length > 0) {
                        if (hiddenTextarea) {
                            hiddenTextarea.value = html;
                        }
                    } else {
                        // Empty content - set empty string
                        if (hiddenTextarea) {
                            hiddenTextarea.value = '';
                        }
                    }
                } else {
                    // No Quill editor initialized - ensure textarea has existing values
                    // This shouldn't happen, but handle it gracefully
                    console.warn('No Quill editor found');
                }
            });
        }
    });

    // Toggle previous review details (global function for onclick handlers)
    function togglePreviousReviewDetails(reviewId) {
        const details = document.getElementById('prev-review-details-' + reviewId);
        const icon = document.getElementById('prev-review-icon-' + reviewId);
        
        if (details && icon) {
            const isHidden = details.classList.contains('hidden');
            
            if (isHidden) {
                details.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                details.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    }

    // Toggle previous review content (global function for onclick handlers)
    function togglePrevReviewContent(reviewId) {
        const content = document.getElementById('prev-review-content-' + reviewId);
        const icon = document.getElementById('prev-review-content-icon-' + reviewId);
        
        if (content && icon) {
            const isHidden = content.classList.contains('hidden');
            
            if (isHidden) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    }
</script>

<!-- Editor Messages Section -->
@if(isset($editorMessages) && $editorMessages->count() > 0)
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
        <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <i data-lucide="message-square" class="w-5 h-5 mr-2 text-green-600"></i>
            {{ __('Messages from Editor') }}
        </h3>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            @foreach($editorMessages as $message)
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 {{ $message->sender_type === 'admin' ? 'bg-indigo-600' : 'bg-green-600' }} rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold text-white">{{ substr($message->sender_type === 'admin' ? ($message->editor->name ?? 'A') : ($message->editor->name ?? 'E'), 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $message->sender_type === 'admin' ? ($message->editor->name ?? 'Admin') : ($message->editor->name ?? 'Editor') }}
                                @if($message->sender_type === 'admin')
                                    <span class="ml-2 px-2 py-0.5 bg-indigo-100 text-indigo-800 text-xs rounded-full">Admin</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">{{ $message->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $message->message }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

