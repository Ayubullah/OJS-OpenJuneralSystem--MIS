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
                     @if(in_array($article->status, ['submitted', 'under_review', 'revision_required']) && $article->status !== 'rejected')
                    <a href="{{ route('author.articles.resubmit', $article) }}" 
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-600 to-amber-600 text-white text-sm font-medium rounded-lg hover:from-orange-700 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        {{ __('Resubmit Article') }}
                    </a>
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

                <!-- Plagiarism & Reports Section -->
                @php
                    $latestSubmission = $article->submissions->sortByDesc('version_number')->first();
                @endphp
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b pb-2">
                        <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-orange-600 font-bold">6</span>
                        </span>
                        {{ __('Plagiarism Check & Reports') }}
                    </h3>
                    
                    <div class="space-y-6">
                        @if($latestSubmission && ($latestSubmission->plagiarism_percentage !== null || $latestSubmission->ai_report_file || $latestSubmission->other_resources_report_file))
                        <!-- Plagiarism Percentage -->
                        @if($latestSubmission && $latestSubmission->plagiarism_percentage !== null)
                        <div class="bg-gradient-to-r {{ $latestSubmission->plagiarism_percentage > 20 ? 'from-red-50 to-pink-50 border-red-300' : ($latestSubmission->plagiarism_percentage > 10 ? 'from-yellow-50 to-amber-50 border-yellow-300' : 'from-green-50 to-emerald-50 border-green-300') }} border-2 rounded-lg p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 {{ $latestSubmission->plagiarism_percentage > 20 ? 'bg-red-600' : ($latestSubmission->plagiarism_percentage > 10 ? 'bg-yellow-600' : 'bg-green-600') }} rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Plagiarism Percentage') }}</label>
                                        <p class="text-3xl font-bold {{ $latestSubmission->plagiarism_percentage > 20 ? 'text-red-600' : ($latestSubmission->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                            {{ number_format($latestSubmission->plagiarism_percentage, 2) }}%
                                        </p>
                                        <p class="text-xs text-gray-600 mt-1">
                                            @if($latestSubmission->plagiarism_percentage > 20)
                                                {{ __('High plagiarism detected - Revision required') }}
                                            @elseif($latestSubmission->plagiarism_percentage > 10)
                                                {{ __('Moderate plagiarism detected - Review recommended') }}
                                            @else
                                                {{ __('Low plagiarism - Within acceptable range') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Report Files -->
                        @if($latestSubmission->ai_report_file || $latestSubmission->other_resources_report_file)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- AI Report File -->
                            @if($latestSubmission->ai_report_file)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm font-semibold text-gray-900">{{ __('AI Report') }}</label>
                                        <p class="text-xs text-gray-600">{{ __('Plagiarism check report from AI system') }}</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $latestSubmission->ai_report_file) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 w-full justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ __('Download AI Report') }}
                                </a>
                            </div>
                            @endif

                            <!-- Other Resources Report File -->
                            @if($latestSubmission->other_resources_report_file)
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm font-semibold text-gray-900">{{ __('Other Resources Report') }}</label>
                                        <p class="text-xs text-gray-600">{{ __('Plagiarism check report from other resources') }}</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $latestSubmission->other_resources_report_file) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200 w-full justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ __('Download Other Report') }}
                                </a>
                            </div>
                            @endif
                        </div>
                        @endif
                        @else
                        <!-- No Data Message -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-sm text-gray-600">{{ __('No plagiarism check data or reports available yet.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ __('This information will appear here once the editor completes the plagiarism check.') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Timeline -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b pb-2">
                        <span class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-pink-600 font-bold">{{ $latestSubmission && ($latestSubmission->plagiarism_percentage !== null || $latestSubmission->ai_report_file || $latestSubmission->other_resources_report_file) ? '7' : '6' }}</span>
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
                            <span class="text-purple-600 font-bold">{{ $latestSubmission && ($latestSubmission->plagiarism_percentage !== null || $latestSubmission->ai_report_file || $latestSubmission->other_resources_report_file) ? '8' : '7' }}</span>
                        </span>
                        Submission History
                        <span class="ml-auto text-sm font-normal text-gray-500">{{ $submissions->count() }} {{ $submissions->count() == 1 ? 'Version' : 'Versions' }}</span>
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($submissions as $submission)
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200 {{ $loop->first ? 'bg-blue-50 border-blue-300' : 'bg-white' }}">
                            <!-- Submission Header (Collapsible) -->
                            <button type="button" 
                                    onclick="toggleVersionDetails({{ $submission->id }})"
                                    class="w-full p-4 text-left hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4 flex-1">
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
                                    <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                                        @if($submission->file_path)
                                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank"
                                            onclick="event.stopPropagation();"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download
                                        </a>
                                        @endif
                                        <i data-lucide="chevron-down" id="version-icon-{{ $submission->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                    </div>
                                </div>
                            </button>

                            <!-- Version Details (Collapsible Content) -->
                            <div id="version-details-{{ $submission->id }}" class="hidden border-t border-gray-200">
                                <!-- Reviews for this version (only editor-approved reviews) -->
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
                                            $review->rating !== null ||
                                            !empty($review->review_file);
                                    };
                                    
                                    // Only show reviews that are APPROVED by editor AND have review data
                                    // Do NOT show reviews that are not approved
                                    $approvedReviews = $submission->reviews->filter(function($review) use ($hasReviewData) {
                                        // Review must be explicitly approved (true or 1) AND have review data
                                        return ($review->editor_approved === true || $review->editor_approved === 1) && $hasReviewData($review);
                                    });
                                @endphp
                                @if($approvedReviews->count() > 0)
                                <div class="bg-gray-50 px-4 py-4">
                                <h5 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Reviewer Comments ({{ $approvedReviews->count() }})
                                </h5>
                                <div class="space-y-3">
                                    @foreach($approvedReviews as $review)
                                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                        <!-- Review Header (Collapsible) -->
                                        <button type="button" 
                                                onclick="toggleReviewDetails({{ $review->id }})"
                                                class="w-full px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                            <div class="flex items-center space-x-3 flex-1">
                                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <i data-lucide="user-check" class="w-5 h-5 text-white"></i>
                                                </div>
                                                <div class="flex-1 text-left">
                                                    <p class="text-sm font-semibold text-gray-900">{{ __('Reviewer') }}</p>
                                                    <p class="text-xs text-gray-500">{{ $review->updated_at?->format('F d, Y \a\t h:i A') ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-3">
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
                                                <i data-lucide="chevron-down" id="review-icon-{{ $review->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                            </div>
                                        </button>
                                        
                                        <!-- Review Details (Collapsible Content) -->
                                        <div id="review-details-{{ $review->id }}" class="hidden px-4 pb-4 space-y-3">
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
                                            @if($review->comments)
                                            <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3">
                                                <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center">
                                                    <i data-lucide="message-square" class="w-3 h-3 mr-1"></i>
                                                    General Review Comments
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
                                                    <p class="text-xs font-semibold text-green-800">Your Reply</p>
                                                </div>
                                                <p class="text-xs text-gray-700 whitespace-pre-wrap leading-relaxed">{{ trim($review->author_reply) }}</p>
                                            </div>
                                            @else
                                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-2">
                                                <p class="text-xs text-gray-500 italic">
                                                    <i data-lucide="info" class="w-3 h-3 inline mr-1"></i>
                                                    You can send a reply to reviewers when you resubmit your article.
                                                </p>
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
                                    <p class="text-xs text-gray-500 mt-1">Reviews will appear here once they are approved by the editor.</p>
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
            
            <!-- Editor Messages & Disc Review Section -->
            @if(isset($editorMessages) && $editorMessages->count() > 0)
            <div class="mt-8 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <i data-lucide="message-square" class="w-5 h-5 mr-2 text-blue-600"></i>
                            {{ __('Messages from Editor & Disc Review') }}
                        </h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-600 text-white">
                            {{ $editorMessages->count() }} {{ $editorMessages->count() == 1 ? __('Message') : __('Messages') }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @php
                            $latestSubmission = $article->submissions->sortByDesc('version_number')->first();
                            $hasApprovalRequest = $editorMessages->where('is_approval_request', true)->count() > 0;
                            $canUploadApproval = $article->status === 'pending_verify' && 
                                                (!$latestSubmission || $latestSubmission->approval_status !== 'verified') &&
                                                (!$latestSubmission || $latestSubmission->approval_status !== 'pending');
                            $hasPendingFile = $latestSubmission && $latestSubmission->approval_status === 'pending' && $latestSubmission->approval_pending_file;
                        @endphp
                        
                        @foreach($editorMessages as $message)
                        <div class="bg-gradient-to-r {{ $message->is_approval_request ? 'from-purple-50 to-pink-50 border-purple-300' : ($message->recipient_type === 'author' && !$message->is_approval_request ? 'from-orange-50 to-red-50 border-orange-300' : 'from-blue-50 to-indigo-50 border-blue-200') }} border-2 rounded-lg p-4">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 {{ $message->is_approval_request ? 'bg-purple-600' : ($message->recipient_type === 'author' && !$message->is_approval_request ? 'bg-orange-600' : ($message->sender_type === 'admin' ? 'bg-indigo-600' : 'bg-blue-600')) }} rounded-full flex items-center justify-center">
                                        <i data-lucide="{{ $message->sender_type === 'admin' ? 'shield' : ($message->recipient_type === 'author' && !$message->is_approval_request ? 'message-circle' : 'user-check') }}" class="w-4 h-4 text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $message->sender_type === 'admin' ? __('Admin') : __('Editor') }}
                                            @if($message->sender_type === 'admin')
                                                <span class="ml-2 px-2 py-0.5 bg-indigo-100 text-indigo-800 text-xs rounded-full">Admin</span>
                                            @endif
                                            @if($message->is_approval_request)
                                                <span class="ml-2 px-2 py-0.5 bg-purple-600 text-white text-xs rounded-full font-bold">VERIFICATION REQUEST</span>
                                            @elseif($message->recipient_type === 'author')
                                                <span class="ml-2 px-2 py-0.5 bg-orange-600 text-white text-xs rounded-full font-bold">DISC REVIEW</span>
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

<style>
    /* Quill editor content styling for display */
    .ql-editor {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 12px;
    }
    .ql-editor ol, .ql-editor ul {
        padding-left: 1.5em;
        margin: 0.5em 0;
    }
    .ql-editor ol li, .ql-editor ul li {
        padding-left: 0.5em;
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
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Toggle review details
    function toggleReviewDetails(reviewIndex) {
        const details = document.getElementById('review-details-' + reviewIndex);
        const icon = document.getElementById('review-icon-' + reviewIndex);
        
        if (!details) {
            console.error('Review details element not found for ID:', reviewIndex);
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

    // Toggle version details - Make sure it's globally accessible
    window.toggleVersionDetails = function(submissionId) {
        console.log('Toggle version details called for ID:', submissionId);
        const detailsId = 'version-details-' + submissionId;
        const iconId = 'version-icon-' + submissionId;
        const details = document.getElementById(detailsId);
        const icon = document.getElementById(iconId);
        
        if (!details) {
            console.error('Version details element not found. Looking for:', detailsId);
            console.log('Available elements:', document.querySelectorAll('[id^="version-details-"]'));
            return;
        }
        
        console.log('Details element found:', details);
        console.log('Current classes:', details.className);
        console.log('Has hidden class:', details.classList.contains('hidden'));
        
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            details.style.display = 'block';
            console.log('Showing details - classes after:', details.className);
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
            // Reinitialize Lucide icons after showing content
            setTimeout(function() {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }, 100);
        } else {
            details.classList.add('hidden');
            details.style.display = 'none';
            console.log('Hiding details');
            if (icon) {
                icon.style.transform = 'rotate(0deg)';
            }
        }
    };
</script>
@endsection

