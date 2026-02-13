@extends('layout.app_author')

@section('title', __('Article Details'))
@section('page-title', __('Article Details'))
@section('page-description', __('View your article submission details'))

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('Article Details') }}</h1>
                    <p class="mt-2 text-gray-600">{{ __('Review your submitted article information') }}</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                     @if(in_array($article->status, ['submitted', 'under_review', 'revision_required']))
                    <a href="{{ route('author.articles.resubmit', $article) }}" 
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-600 to-amber-600 text-white text-sm font-medium rounded-lg hover:from-orange-700 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        {{ __('Resubmit Article') }}
                    </a>
                    @endif
                    @if(in_array($article->status, ['submitted', 'under_review', 'revision_required']))
                    <a href="{{ route('author.articles.edit', $article) }}" 
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-teal-600 text-white text-sm font-medium rounded-lg hover:from-green-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ __('Edit Article') }}
                    </a>
                    @endif
                    @if(in_array($article->status, ['submitted', 'under_review']))
                    <form action="{{ route('author.articles.reject', $article) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to reject this article? This action cannot be undone and no further reviewers will be assigned.') }}')" class="inline">
                        @csrf
                        @method('POST')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-rose-600 text-white text-sm font-medium rounded-lg hover:from-red-700 hover:to-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            {{ __('Reject Article') }}
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('author.articles.index') }}" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Back to List') }}
                    </a>
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

        <!-- Article Details Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Status Banner -->
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $article->title }}</h2>
                            <p class="text-sm text-gray-600 mt-1">Submitted on {{ $article->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                    <div>
                        @php
                            $statusColors = [
                                'submitted' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'under_review' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'revision_required' => 'bg-orange-100 text-orange-800 border-orange-200',
                                'pending_verify' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'verified' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                'accepted' => 'bg-green-100 text-green-800 border-green-200',
                                'published' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'rejected' => 'bg-red-100 text-red-800 border-red-200',
                            ];
                            $statusColor = $statusColors[$article->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                        @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold border-2 {{ $statusColor }}">
                            {{ __(ucfirst(str_replace('_', ' ', $article->status))) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-8">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b pb-2">
                        <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-blue-600 font-bold">1</span>
                        </span>
                        {{ __('Basic Information') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Journal') }}</label>
                            <p class="text-base text-gray-900">{{ $article->journal->name ?? __('N/A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Category') }}</label>
                            <p class="text-base text-gray-900">{{ $article->category->name ?? __('N/A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Manuscript Type') }}</label>
                            <p class="text-base text-gray-900">{{ $article->manuscript_type }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Word Count') }}</label>
                            <p class="text-base text-gray-900">{{ number_format($article->word_count) }} {{ __('words') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Number of Tables') }}</label>
                            <p class="text-base text-gray-900">{{ $article->number_of_tables }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Number of Figures') }}</label>
                            <p class="text-base text-gray-900">{{ $article->number_of_figures }}</p>
                        </div>
                    </div>
                </div>

                <!-- Abstract -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b pb-2">
                        <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-green-600 font-bold">2</span>
                        </span>
                        {{ __('Abstract') }}
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $article->abstract }}</p>
                    </div>
                </div>

                <!-- Manuscript File -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b pb-2">
                        <span class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-purple-600 font-bold">3</span>
                        </span>
                        {{ __('Manuscript File') }}
                    </h3>
                    @if($article->manuscript_file)
                    <a href="{{ asset('storage/' . $article->manuscript_file) }}" target="_blank"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ __('Download Manuscript') }}
                    </a>
                    @else
                    <p class="text-gray-500">{{ __('No file uploaded') }}</p>
                    @endif
                </div>

                <!-- Keywords -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b pb-2">
                        <span class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-indigo-600 font-bold">4</span>
                        </span>
                        {{ __('Keywords') }}
                    </h3>
                    @if($article->keywords->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($article->keywords as $keyword)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            {{ $keyword->keyword }}
                        </span>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500">{{ __('No keywords added') }}</p>
                    @endif
                </div>

                <!-- Submission Details -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b pb-2">
                        <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-orange-600 font-bold">5</span>
                        </span>
                        {{ __('Submission Details') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Previously Submitted Elsewhere?') }}</label>
                            <p class="text-base text-gray-900">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $article->previously_submitted == 'Yes' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $article->previously_submitted }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Funded by Outside Source?') }}</label>
                            <p class="text-base text-gray-900">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $article->funded_by_outside_source == 'Yes' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $article->funded_by_outside_source }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="space-y-2">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-sm text-gray-700">
                                    <strong>Confirmed:</strong> This manuscript has not been published elsewhere and is not under consideration by another journal.
                                </p>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-sm text-gray-700">
                                    <strong>Confirmed:</strong> This manuscript has been prepared according to the journal's guidelines for authors.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b pb-2">
                        <span class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-pink-600 font-bold">6</span>
                        </span>
                        Timeline
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Created</p>
                                <p class="text-sm text-gray-500">{{ $article->created_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                <p class="text-sm text-gray-500">{{ $article->updated_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submission History -->
                @php
                    $submissions = $article->submissions()->orderBy('version_number', 'desc')->get();
                @endphp
                
                @if($submissions->count() > 0)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b pb-2">
                        <span class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-purple-600 font-bold">7</span>
                        </span>
                        Submission History
                        <span class="ml-auto text-sm font-normal text-gray-500">{{ $submissions->count() }} {{ $submissions->count() == 1 ? 'Version' : 'Versions' }}</span>
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($submissions as $submission)
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200 {{ $loop->first ? 'bg-blue-50 border-blue-300' : 'bg-white' }}">
                            <!-- Submission Header -->
                            <div class="p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0 w-12 h-12 {{ $loop->first ? 'bg-blue-600' : 'bg-gray-400' }} rounded-lg flex items-center justify-center">
                                            <span class="text-lg font-bold text-white">V{{ $submission->version_number }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2">
                                                <h4 class="text-base font-semibold text-gray-900">Version {{ $submission->version_number }}</h4>
                                                @if($loop->first)
                                                <span class="px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded-full">LATEST</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">
                                                Submitted on {{ $submission->submission_date->format('F d, Y \a\t h:i A') }}
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
                                                    $statusColor = $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                                    {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ml-4">
                                        @if($submission->file_path)
                                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews for this version (only editor-approved reviews) -->
                            @php
                                $approvedReviews = $submission->reviews->whereNotNull('comments')->where('editor_approved', true);
                            @endphp
                            @if($approvedReviews->count() > 0)
                            <div class="border-t border-gray-200 bg-gray-50 px-4 py-4">
                                <h5 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Reviewer Comments ({{ $approvedReviews->count() }})
                                </h5>
                                <div class="space-y-3">
                                    @foreach($approvedReviews as $review)
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <span class="text-sm font-bold text-white">{{ substr($review->reviewer->user->name ?? 'R', 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer->user->name ?? 'Unknown Reviewer' }}</p>
                                                    <p class="text-xs text-gray-500">{{ $review->updated_at?->format('F d, Y \a\t h:i A') ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            @if($review->rating)
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm font-bold text-gray-900">{{ $review->rating }}/10</span>
                                                <div class="flex space-x-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= ($review->rating / 2) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
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
                                        </div>
                                        @if($review->plagiarism_percentage !== null)
                                        <div class="bg-gradient-to-r from-orange-50 to-red-50 border border-orange-200 rounded-lg p-3 mb-3">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <i data-lucide="file-search" class="w-4 h-4 text-orange-600"></i>
                                                <p class="text-xs font-semibold text-orange-800">Plagiarism Percentage</p>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <span class="text-xl font-bold {{ $review->plagiarism_percentage > 20 ? 'text-red-600' : ($review->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                                    {{ number_format($review->plagiarism_percentage, 2) }}%
                                                </span>
                                                <span class="text-sm text-gray-600">detected by reviewer</span>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3 mb-3">
                                            <div class="text-sm text-gray-700 leading-relaxed ql-editor" style="padding: 0;">
                                                {!! $review->editor_edited_comments ?? $review->comments !!}
                                            </div>
                                        </div>
                                        
                                        <!-- Author Reply Section -->
                                        @if($review->author_reply && trim($review->author_reply) !== '')
                                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-3 mb-3">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <i data-lucide="message-square" class="w-4 h-4 text-green-600"></i>
                                                <p class="text-xs font-semibold text-green-800">Your Reply</p>
                                            </div>
                                            <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ trim($review->author_reply) }}</p>
                                        </div>
                                        @else
                                        <div class="mt-3 bg-gray-50 border border-gray-200 rounded-lg p-3">
                                            <p class="text-xs text-gray-500 italic">
                                                <i data-lucide="info" class="w-3 h-3 inline mr-1"></i>
                                                You can send a reply to reviewers when you resubmit your article.
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Editor Messages Section -->
            @if(isset($editorMessages) && $editorMessages->count() > 0)
            <div class="mt-8 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <i data-lucide="message-square" class="w-5 h-5 mr-2 text-blue-600"></i>
                            Messages from Editor
                        </h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-600 text-white">
                            Article ID: {{ $article->id }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @php
                            $latestSubmission = $article->submissions()->orderBy('version_number', 'desc')->first();
                            $hasApprovalRequest = $editorMessages->where('is_approval_request', true)->count() > 0;
                            $canUploadApproval = $article->status === 'pending_verify' && 
                                                (!$latestSubmission || $latestSubmission->approval_status !== 'verified') &&
                                                (!$latestSubmission || $latestSubmission->approval_status !== 'pending');
                            $hasPendingFile = $latestSubmission && $latestSubmission->approval_status === 'pending' && $latestSubmission->approval_pending_file;
                        @endphp
                        
                        @foreach($editorMessages as $message)
                        <div class="bg-gradient-to-r {{ $message->is_approval_request ? 'from-purple-50 to-pink-50 border-purple-300' : 'from-blue-50 to-indigo-50 border-blue-200' }} border-2 rounded-lg p-4">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 {{ $message->is_approval_request ? 'bg-purple-600' : ($message->sender_type === 'admin' ? 'bg-indigo-600' : 'bg-blue-600') }} rounded-full flex items-center justify-center">
                                        <span class="text-xs font-bold text-white">{{ substr($message->sender_type === 'admin' ? ($message->editor->name ?? 'A') : ($message->editor->name ?? 'E'), 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $message->sender_type === 'admin' ? ($message->editor->name ?? 'Admin') : ($message->editor->name ?? 'Editor') }}
                                            @if($message->sender_type === 'admin')
                                                <span class="ml-2 px-2 py-0.5 bg-indigo-100 text-indigo-800 text-xs rounded-full">Admin</span>
                                            @endif
                                            @if($message->is_approval_request)
                                                <span class="ml-2 px-2 py-0.5 bg-purple-600 text-white text-xs rounded-full font-bold">VERIFICATION REQUEST</span>
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
                        
                        <!-- Approval File Upload Form -->
                        @if($hasApprovalRequest && $canUploadApproval && !$hasPendingFile)
                        <div class="mt-6 bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-300 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center mr-3">
                                    <i data-lucide="upload" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">Upload Revised File for Verification</h4>
                                    <p class="text-sm text-gray-600">Please upload your revised file for editor verification</p>
                                </div>
                            </div>
                            
                            <form action="{{ route('author.articles.upload-approval-file', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="approval_file" class="block text-sm font-medium text-gray-700 mb-2">
                                        File (PDF, DOC, DOCX) *
                                    </label>
                                    <input type="file" id="approval_file" name="approval_file" required
                                           accept=".pdf,.doc,.docx"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700">
                                    <p class="text-xs text-gray-500 mt-1">Maximum file size: 10MB</p>
                                </div>
                                
                                <div>
                                    <label for="approval_message" class="block text-sm font-medium text-gray-700 mb-2">
                                        Message/Notes (Optional)
                                    </label>
                                    <textarea id="approval_message" name="approval_message" rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                              placeholder="Add any notes or comments for the editor..."></textarea>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <button type="submit"
                                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-sm font-medium rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-200 transform hover:scale-105">
                                        <i data-lucide="upload" class="w-5 h-5 mr-2"></i>
                                        Submit for Verification
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif
                        
                        <!-- Pending File Status -->
                        @if($hasPendingFile)
                        <div class="mt-6 bg-gradient-to-r from-yellow-50 to-amber-50 border-2 border-yellow-300 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-yellow-600 rounded-full flex items-center justify-center mr-3">
                                    <i data-lucide="clock" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">File Already Uploaded</h4>
                                    <p class="text-sm text-gray-600">Your file is pending editor review. You cannot upload another file until the editor reviews this one.</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 p-4 bg-white border border-yellow-200 rounded-lg">
                                <p class="text-sm font-semibold text-gray-900 mb-2">Uploaded File:</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ basename($latestSubmission->approval_pending_file) }}</span>
                                    <a href="{{ asset('storage/' . $latestSubmission->approval_pending_file) }}" target="_blank"
                                       class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                                        Download
                                    </a>
                                </div>
                                <p class="text-xs text-yellow-600 mt-2 font-semibold flex items-center">
                                    <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                    ⏳ Waiting for editor review - Uploaded on {{ $latestSubmission->updated_at->format('M d, Y H:i') }}
                                </p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Previously Uploaded File (if rejected or approved) -->
                        @if($latestSubmission && $latestSubmission->approval_pending_file && !$hasPendingFile)
                        <div class="mt-4 p-4 bg-white border border-purple-200 rounded-lg">
                            <p class="text-sm font-semibold text-gray-900 mb-2">Previously Uploaded File:</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">{{ basename($latestSubmission->approval_pending_file) }}</span>
                                <a href="{{ asset('storage/' . $latestSubmission->approval_pending_file) }}" target="_blank"
                                   class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                                    Download
                                </a>
                            </div>
                                @if($latestSubmission->approval_status === 'rejected')
                                <p class="text-xs text-red-600 mt-2 font-semibold">❌ Verification rejected. Please upload a new file.</p>
                                @elseif($latestSubmission->approval_status === 'verified')
                                <p class="text-xs text-green-600 mt-2 font-semibold">✓ Verified on {{ $latestSubmission->updated_at->format('M d, Y') }}</p>
                                @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
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

