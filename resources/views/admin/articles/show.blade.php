@extends('layout.app_admin')

@section('title', __('Article Details'))
@section('page-title', __('Article Details'))
@section('page-description', __('View article information and details'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('admin.articles.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Articles') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ Str::limit($article->title, 30) }}</span>
</li>
@endsection

@section('content')
@php
    $totalReviews = 0;
    foreach($article->submissions as $submission) {
        $totalReviews += $submission->reviews->count();
    }
@endphp

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
    <div class="flex items-center">
        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-3"></i>
        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
    <div class="flex items-center">
        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mr-3"></i>
        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
    </div>
</div>
@endif

<div class="space-y-6">
    <!-- Article Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-purple-50 to-blue-50">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 
                               ($article->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                               ($article->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                               ($article->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                            {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $article->created_at->format('M d, Y') }}</span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $article->title }}</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            <span>{{ $article->journal->name ?? __('Unknown Journal') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i data-lucide="tag" class="w-4 h-4"></i>
                            <span>{{ $article->category->name ?? __('Uncategorized') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.articles.edit', $article) }}" 
                       class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2 inline"></i>
                        {{ __('Edit') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Article Details -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Article Details') }}</h3>
                <div class="space-y-4">
                    @if($article->abstract)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">{{ __('Abstract') }}</label>
                        <p class="text-sm text-gray-700 bg-gray-50 p-4 rounded-lg whitespace-pre-line">{{ $article->abstract }}</p>
                    </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if($article->word_count)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Word Count') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ number_format($article->word_count) }}</p>
                        </div>
                        @endif
                        @if($article->number_of_tables !== null)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Number of Tables') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $article->number_of_tables }}</p>
                        </div>
                        @endif
                        @if($article->number_of_figures !== null)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Number of Figures') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $article->number_of_figures }}</p>
                        </div>
                        @endif
                    </div>
                    @if($article->manuscript_type)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Manuscript Type') }}</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $article->manuscript_type }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Keywords -->
            @if($article->keywords->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Keywords') }}</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->keywords as $keyword)
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full">
                        {{ $keyword->keyword }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Submissions History with Reviews -->
            @if($article->submissions->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="file-text" class="w-5 h-5 mr-2 text-purple-600"></i>
                    {{ __('Submission History & Reviews') }}
                </h3>
                <div class="space-y-6">
                    @foreach($article->submissions as $submission)
                    <div class="border border-gray-200 rounded-xl overflow-hidden bg-gradient-to-r from-gray-50 to-blue-50">
                        <!-- Submission Header (Collapsible) -->
                        <button type="button" 
                                onclick="toggleVersionDetailsAdmin({{ $submission->id }})"
                                class="w-full p-6 text-left hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 flex-1">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-lg font-bold text-white">V{{ $submission->version_number }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <p class="text-base font-bold text-gray-900">{{ __('Version :number', ['number' => $submission->version_number]) }}</p>
                                            @if($loop->first)
                                            <span class="px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded-full">LATEST</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Submitted on {{ $submission->submission_date->format('F d, Y \a\t h:i A') }}
                                        </p>
                                        <div class="mt-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                {{ $submission->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($submission->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                                                   ($submission->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                                   ($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                                                {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                                    @if($submission->file_path)
                                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" 
                                       onclick="event.stopPropagation();"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                        Download
                                    </a>
                                    @endif
                                    <i data-lucide="chevron-down" id="version-icon-admin-{{ $submission->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                </div>
                            </div>
                        </button>

                        <!-- Version Details (Collapsible Content) -->
                        <div id="version-details-admin-{{ $submission->id }}" class="hidden border-t border-gray-200 px-6 pb-6">
                            <!-- Reviews for this Submission -->
                            @php
                            // Helper function to check if review has any data
                            $hasReviewData = function($review) {
                                return !empty($review->comments) ||
                                    !empty($review->originality_comment) ||
                                    !empty($review->relationship_to_literature_comment) ||
                                    !empty($review->methodology_comment) ||
                                    !empty($review->results_comment) ||
                                    !empty($review->implications_comment) ||
                                    !empty($review->quality_of_communication_comment) ||
                                    !empty($review->strengths) ||
                                    !empty($review->weaknesses) ||
                                    !empty($review->suggestions_for_improvement) ||
                                    $review->relevance_score !== null ||
                                    $review->originality_score !== null ||
                                    $review->significance_score !== null ||
                                    $review->technical_soundness_score !== null ||
                                    $review->clarity_score !== null ||
                                    $review->documentation_score !== null ||
                                    $review->total_score !== null ||
                                    !empty($review->final_evaluation) ||
                                    !empty($review->recommendation) ||
                                    $review->rating !== null;
                            };
                            
                            // Get reviews with data
                            $reviewsWithData = $submission->reviews->filter(function($review) use ($hasReviewData) {
                                return $hasReviewData($review);
                            });
                            @endphp
                            @if($reviewsWithData->count() > 0)
                            <div class="mt-4">
                                <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                                    <i data-lucide="message-square" class="w-4 h-4 mr-2 text-purple-600"></i>
                                    Reviews ({{ $reviewsWithData->count() }})
                                </h4>
                                <div class="space-y-4">
                                @foreach($reviewsWithData as $review)
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                    <!-- Review Header (Collapsible) -->
                                    <button type="button" 
                                            onclick="toggleReviewDetailsAdmin({{ $review->id }})"
                                            class="w-full p-4 flex items-center justify-between hover:bg-gray-50 transition-colors text-left">
                                        <div class="flex items-center space-x-3 flex-1">
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i data-lucide="user-check" class="w-5 h-5 text-white"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer->user->name ?? 'Unknown Reviewer' }}</p>
                                                <p class="text-xs text-gray-500">{{ $review->reviewer->email ?? 'No email' }} • {{ $review->updated_at?->format('F d, Y \a\t h:i A') ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                                            @if($review->recommendation)
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                                                $review->recommendation === 'acceptance' ? 'bg-green-100 text-green-800' : 
                                                ($review->recommendation === 'minor_revision' ? 'bg-blue-100 text-blue-800' : 
                                                ($review->recommendation === 'major_revision' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')) 
                                            }}">
                                                {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                                            </span>
                                            @endif
                                            @if($review->rating)
                                            <div class="flex items-center space-x-1">
                                                <span class="text-sm font-bold text-gray-900">{{ $review->rating }}/10</span>
                                                <div class="flex space-x-0.5">
                                                    @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= ($review->rating / 2) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endif
                                            @if($review->total_score !== null)
                                            <span class="text-xs font-semibold text-gray-600">{{ number_format($review->total_score, 1) }}/60</span>
                                            @endif
                                            <i data-lucide="chevron-down" id="review-icon-admin-{{ $review->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                        </div>
                                    </button>
                                    
                                    <!-- Review Details (Collapsible Content) -->
                                    <div id="review-details-admin-{{ $review->id }}" class="hidden px-4 pb-4 space-y-3 border-t border-gray-200">
                                        <!-- Quick Summary Cards -->
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                            @if($review->final_evaluation)
                                            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-2">
                                                <p class="text-xs text-gray-600 mb-1">Evaluation</p>
                                                <p class="text-sm font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $review->final_evaluation) }}</p>
                                            </div>
                                            @endif
                                            @if($review->total_score !== null)
                                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-2">
                                                <p class="text-xs text-gray-600 mb-1">Total Score</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($review->total_score, 1) }}/60</p>
                                            </div>
                                            @endif
                                            @if($review->plagiarism_percentage !== null)
                                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-2">
                                                <p class="text-xs text-gray-600 mb-1">Plagiarism</p>
                                                <p class="text-sm font-semibold {{ $review->plagiarism_percentage > 20 ? 'text-red-600' : ($review->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                                    {{ number_format($review->plagiarism_percentage, 2) }}%
                                                </p>
                                            </div>
                                            @endif
                                            @if($review->recommendation)
                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-2">
                                                <p class="text-xs text-gray-600 mb-1">Recommendation</p>
                                                <p class="text-sm font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $review->recommendation) }}</p>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- General Comments (6 Questions) -->
                                        @if($review->originality_comment || $review->relationship_to_literature_comment || $review->methodology_comment || $review->results_comment || $review->implications_comment || $review->quality_of_communication_comment)
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                            <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                <i data-lucide="file-text" class="w-3 h-3 mr-1"></i>
                                                General Comments
                                            </h6>
                                            <div class="space-y-2 text-xs">
                                                @if($review->originality_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">1. Originality</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $review->originality_comment }}</p>
                                                </div>
                                                @endif
                                                @if($review->relationship_to_literature_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">2. Relationship to Literature</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $review->relationship_to_literature_comment }}</p>
                                                </div>
                                                @endif
                                                @if($review->methodology_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">3. Methodology</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $review->methodology_comment }}</p>
                                                </div>
                                                @endif
                                                @if($review->results_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">4. Results</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $review->results_comment }}</p>
                                                </div>
                                                @endif
                                                @if($review->implications_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">5. Implications</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $review->implications_comment }}</p>
                                                </div>
                                                @endif
                                                @if($review->quality_of_communication_comment)
                                                <div class="bg-white rounded p-2">
                                                    <p class="font-semibold text-gray-700 mb-1">6. Quality of Communication</p>
                                                    <p class="text-gray-600 whitespace-pre-wrap">{{ $review->quality_of_communication_comment }}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Strengths and Weaknesses -->
                                        @if($review->strengths || $review->weaknesses)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            @if($review->strengths)
                                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                                <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                    <i data-lucide="thumbs-up" class="w-3 h-3 mr-1 text-green-600"></i>
                                                    Strengths
                                                </h6>
                                                <p class="text-xs text-gray-700 whitespace-pre-wrap">{{ $review->strengths }}</p>
                                            </div>
                                            @endif
                                            @if($review->weaknesses)
                                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                                <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                    <i data-lucide="thumbs-down" class="w-3 h-3 mr-1 text-red-600"></i>
                                                    Weaknesses
                                                </h6>
                                                <p class="text-xs text-gray-700 whitespace-pre-wrap">{{ $review->weaknesses }}</p>
                                            </div>
                                            @endif
                                        </div>
                                        @endif

                                        <!-- Suggestions for Improvement -->
                                        @if($review->suggestions_for_improvement)
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                            <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                <i data-lucide="lightbulb" class="w-3 h-3 mr-1 text-yellow-600"></i>
                                                Suggestions for Improvement
                                            </h6>
                                            <p class="text-xs text-gray-700 whitespace-pre-wrap">{{ $review->suggestions_for_improvement }}</p>
                                        </div>
                                        @endif

                                        <!-- Paper Score -->
                                        @if($review->relevance_score !== null || $review->originality_score !== null || $review->significance_score !== null || $review->technical_soundness_score !== null || $review->clarity_score !== null || $review->documentation_score !== null)
                                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                                            <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                <i data-lucide="award" class="w-3 h-3 mr-1 text-purple-600"></i>
                                                Paper Score
                                            </h6>
                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs">
                                                @if($review->relevance_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">Relevance</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($review->relevance_score, 1) }}/5</p>
                                                </div>
                                                @endif
                                                @if($review->originality_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">Originality</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($review->originality_score, 1) }}/10</p>
                                                </div>
                                                @endif
                                                @if($review->significance_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">Significance</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($review->significance_score, 1) }}/15</p>
                                                </div>
                                                @endif
                                                @if($review->technical_soundness_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">Technical Soundness</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($review->technical_soundness_score, 1) }}/15</p>
                                                </div>
                                                @endif
                                                @if($review->clarity_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">Clarity</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($review->clarity_score, 1) }}/10</p>
                                                </div>
                                                @endif
                                                @if($review->documentation_score !== null)
                                                <div class="bg-white rounded p-2">
                                                    <p class="text-gray-600">Documentation</p>
                                                    <p class="font-semibold text-gray-900">{{ number_format($review->documentation_score, 1) }}/5</p>
                                                </div>
                                                @endif
                                            </div>
                                            @if($review->total_score !== null)
                                            <div class="mt-2 pt-2 border-t border-purple-300 bg-white rounded p-2">
                                                <div class="flex justify-between items-center">
                                                    <p class="text-xs font-semibold text-gray-900">Total Score</p>
                                                    <p class="text-sm font-bold text-purple-600">{{ number_format($review->total_score, 1) }}/60</p>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        @endif

                                        <!-- General Review Comments -->
                                        @if($review->editor_edited_comments || $review->comments)
                                        <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3">
                                            <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                <i data-lucide="message-square" class="w-3 h-3 mr-1"></i>
                                                General Review Comments {{ $review->editor_edited_comments ? '(Edited by Editor)' : '' }}
                                            </h6>
                                            <div class="text-xs text-gray-700 leading-relaxed ql-editor" style="padding: 0;">
                                                {!! $review->editor_edited_comments ?? $review->comments !!}
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Review File Attachment -->
                                        @if($review->review_file)
                                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                                            <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                <i data-lucide="paperclip" class="w-3 h-3 mr-1 text-purple-600"></i>
                                                Attached File
                                            </h6>
                                            <div class="flex items-center justify-between bg-white rounded-lg p-2 border border-purple-200">
                                                <div class="flex items-center space-x-2">
                                                    <i data-lucide="file-text" class="w-4 h-4 text-purple-600"></i>
                                                    <span class="text-xs font-medium text-gray-900">{{ basename($review->review_file) }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $review->review_file) }}" target="_blank"
                                                   class="inline-flex items-center px-2 py-1 bg-purple-600 text-white text-xs font-medium rounded-lg hover:bg-purple-700 transition-colors">
                                                    <i data-lucide="download" class="w-3 h-3 mr-1"></i>
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Author Reply Section -->
                                        @if($review->author_reply && trim($review->author_reply) !== '')
                                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-3">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <i data-lucide="message-square" class="w-3 h-3 text-green-600"></i>
                                                <p class="text-xs font-semibold text-green-800">Author's Reply</p>
                                            </div>
                                            <p class="text-xs text-gray-700 whitespace-pre-wrap leading-relaxed">{{ trim($review->author_reply) }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                </div>
                            </div>
                            @else
                            <!-- No Reviews Message -->
                            <div class="bg-gray-50 px-4 py-4">
                                <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
                                    <i data-lucide="file-text" class="w-8 h-8 text-gray-400 mx-auto mb-2"></i>
                                    <p class="text-sm text-gray-600">No reviewer comments available yet.</p>
                                    <p class="text-xs text-gray-500 mt-1">Reviews will appear here once they are submitted.</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Quick Stats') }}</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Submissions') }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $article->submissions->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Reviews') }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $totalReviews }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Keywords') }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $article->keywords->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Journal Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Journal Details') }}</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $article->journal->name ?? __('Unknown Journal') }}</p>
                        <p class="text-xs text-gray-500">{{ __('ISSN: :issn', ['issn' => $article->journal->issn ?? 'N/A']) }}</p>
                    </div>
                    @if($article->journal->description)
                    <p class="text-sm text-gray-600">{{ Str::limit($article->journal->description, 100) }}</p>
                    @endif
                </div>
            </div>

            <!-- Send Reminder -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="send" class="w-5 h-5 mr-2 text-purple-600"></i>
                    {{ __('Send Reminder') }}
                </h3>
                <form action="{{ route('admin.articles.send-reminder', $article) }}" method="POST" id="reminderForm">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Recipient') }}</label>
                            <select name="recipient_type" id="recipient_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                                <option value="">{{ __('Select recipient...') }}</option>
                                <option value="author">{{ __('Author') }} ({{ $article->author->name ?? 'Unknown' }})</option>
                                @if($article->submissions->count() > 0)
                                    @php
                                        $allReviewers = collect();
                                        foreach($article->submissions as $submission) {
                                            foreach($submission->reviews as $review) {
                                                if($review->reviewer && !$allReviewers->contains('id', $review->reviewer->id)) {
                                                    $allReviewers->push($review->reviewer);
                                                }
                                            }
                                        }
                                    @endphp
                                    @if($allReviewers->count() > 0)
                                        <optgroup label="{{ __('Reviewers') }}">
                                            @foreach($allReviewers as $reviewer)
                                            <option value="reviewer_{{ $reviewer->id }}">{{ __('Reviewer') }}: {{ $reviewer->user->name ?? 'Unknown' }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endif
                                @if(isset($editors) && $editors->count() > 0)
                                    <optgroup label="{{ __('Editors') }}">
                                        @foreach($editors as $editor)
                                        <option value="editor_{{ $editor->user_id }}">{{ __('Editor') }}: {{ $editor->user->name ?? 'Unknown' }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Message') }}</label>
                            <textarea name="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="{{ __('Enter your reminder message...') }}" required minlength="10" maxlength="2000"></textarea>
                            <p class="mt-1 text-xs text-gray-500">{{ __('Minimum 10 characters, maximum 2000 characters') }}</p>
                        </div>
                        <input type="hidden" name="submission_id" value="{{ $article->submissions->first()->id ?? '' }}">
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                            <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                            {{ __('Send Reminder') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Actions') }}</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.articles.edit', $article) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        {{ __('Edit Article') }}
                    </a>
                    <a href="{{ route('admin.submissions.create') }}?article_id={{ $article->id }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        {{ __('New Submission') }}
                    </a>
                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this article?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                            {{ __('Delete Article') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Toggle review details for admin view
    function toggleReviewDetailsAdmin(reviewId) {
        const details = document.getElementById('review-details-admin-' + reviewId);
        const icon = document.getElementById('review-icon-admin-' + reviewId);
        
        if (!details) {
            console.error('Review details element not found for ID:', reviewId);
            return;
        }
        
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
            // Reinitialize Lucide icons after showing content
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        } else {
            details.classList.add('hidden');
            if (icon) {
                icon.style.transform = 'rotate(0deg)';
            }
        }
    }

    // Toggle version details for admin view
    function toggleVersionDetailsAdmin(submissionId) {
        const details = document.getElementById('version-details-admin-' + submissionId);
        const icon = document.getElementById('version-icon-admin-' + submissionId);
        
        if (!details) {
            console.error('Version details element not found for ID:', submissionId);
            return;
        }
        
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
            // Reinitialize Lucide icons after showing content
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        } else {
            details.classList.add('hidden');
            if (icon) {
                icon.style.transform = 'rotate(0deg)';
            }
        }
    }
</script>
@endsection
