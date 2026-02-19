@extends('layout.app_editorial_assistant')

@section('title', __('Article Details'))
@section('page-title', __('Article Details'))
@section('page-description', __('View accepted article information and reviews'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <a href="{{ route('editorial_assistant.dashboard') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Dashboard') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('editorial_assistant.articles.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Accepted Articles') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ Str::limit($article->title, 30) }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    @if($submission)
    <!-- Submission Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-teal-50 to-cyan-50">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $submission->status === 'published' ? 'bg-green-100 text-green-800' : 
                               ($submission->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                               ($submission->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                               ($submission->status === 'verified' ? 'bg-emerald-100 text-emerald-800' :
                               ($submission->status === 'accepted' ? 'bg-emerald-100 text-emerald-800' : 
                               ($submission->status === 'pending_verify' ? 'bg-purple-100 text-purple-800' :
                               ($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))))) }}">
                            {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                        </span>
                        <span class="text-sm text-gray-500">{{ __('Version') }} {{ $submission->version_number }}</span>
                        <span class="text-sm text-gray-500">{{ $submission->submission_date?->format('M d, Y') ?? __('N/A') }}</span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $submission->article->title ?? $article->title }}</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            <span>{{ $submission->article->journal->name ?? $article->journal->name ?? __('Unknown Journal') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submission Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Article Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Article Information') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Title') }}</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $submission->article->title ?? $article->title }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Journal') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $submission->article->journal->name ?? $article->journal->name ?? __('Unknown Journal') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Category') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $submission->article->category->name ?? $article->category->name ?? __('Uncategorized') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Manuscript Type') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $article->manuscript_type ?? __('N/A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Word Count') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ number_format($article->word_count ?? 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abstract -->
            @if($article->abstract)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Abstract') }}</h3>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-gray-700 leading-relaxed">{{ $article->abstract }}</p>
                </div>
            </div>
            @endif

            <!-- Keywords -->
            @if($article->keywords && $article->keywords->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Keywords') }}</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->keywords as $keyword)
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-teal-100 text-teal-800 text-sm font-medium">
                        {{ $keyword->keyword }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Submitted File -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Submitted File') }}</h3>
                @if($submission->file_path)
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="file-text" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ basename($submission->file_path) }}</p>
                                <p class="text-xs text-gray-500">{{ __('Version') }} {{ $submission->version_number }}</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                            {{ __('Download') }}
                        </a>
                    </div>
                </div>
                @else
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl">
                    <p class="text-sm text-gray-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-2 text-gray-400"></i>
                        {{ __('No file uploaded yet') }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Plagiarism Check & Reports Section -->
            @if($submission->plagiarism_percentage !== null || $submission->ai_report_file || $submission->other_resources_report_file)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="file-search" class="w-5 h-5 mr-2 text-teal-600"></i>
                    {{ __('Plagiarism Check & Reports') }}
                </h3>
                
                <div class="space-y-6">
                    <!-- Plagiarism Percentage -->
                    @if($submission->plagiarism_percentage !== null)
                    <div class="bg-gradient-to-r {{ $submission->plagiarism_percentage > 20 ? 'from-red-50 to-pink-50 border-red-300' : ($submission->plagiarism_percentage > 10 ? 'from-yellow-50 to-amber-50 border-yellow-300' : 'from-green-50 to-emerald-50 border-green-300') }} border-2 rounded-lg p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 {{ $submission->plagiarism_percentage > 20 ? 'bg-red-600' : ($submission->plagiarism_percentage > 10 ? 'bg-yellow-600' : 'bg-green-600') }} rounded-lg flex items-center justify-center">
                                    <i data-lucide="file-search" class="w-6 h-6 text-white"></i>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Plagiarism Percentage') }}</label>
                                    <p class="text-3xl font-bold {{ $submission->plagiarism_percentage > 20 ? 'text-red-600' : ($submission->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                        {{ number_format($submission->plagiarism_percentage, 2) }}%
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1">
                                        @if($submission->plagiarism_percentage > 20)
                                            {{ __('High plagiarism detected - Revision required') }}
                                        @elseif($submission->plagiarism_percentage > 10)
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
                    @if($submission->ai_report_file || $submission->other_resources_report_file)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- AI Report File -->
                        @if($submission->ai_report_file)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <i data-lucide="file-text" class="w-5 h-5 text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-semibold text-gray-900">{{ __('AI Report') }}</label>
                                    <p class="text-xs text-gray-600">{{ __('Plagiarism check report from AI system') }}</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $submission->ai_report_file) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 w-full justify-center">
                                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                {{ __('Download AI Report') }}
                            </a>
                        </div>
                        @endif

                        <!-- Other Resources Report File -->
                        @if($submission->other_resources_report_file)
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                    <i data-lucide="file-text" class="w-5 h-5 text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-semibold text-gray-900">{{ __('Other Resources Report') }}</label>
                                    <p class="text-xs text-gray-600">{{ __('Plagiarism check report from other resources') }}</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $submission->other_resources_report_file) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200 w-full justify-center">
                                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                {{ __('Download Other Report') }}
                            </a>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Disc Review Messages Section -->
            @if(isset($editorMessages) && $editorMessages->where('recipient_type', 'author')->where('is_approval_request', false)->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="message-square" class="w-5 h-5 mr-2 text-teal-600"></i>
                    {{ __('Disc Review Messages') }}
                </h3>
                <div class="space-y-4">
                    @foreach($editorMessages->where('recipient_type', 'author')->where('is_approval_request', false) as $message)
                    <div class="bg-gradient-to-r from-orange-50 to-red-50 border-2 border-orange-300 rounded-lg p-4">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center">
                                    <i data-lucide="message-circle" class="w-4 h-4 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ __('Editor') }}
                                        <span class="ml-2 px-2 py-0.5 bg-orange-600 text-white text-xs rounded-full font-bold">DISC REVIEW</span>
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
            @endif

            <!-- Version Control Flow Section -->
            @if(isset($allSubmissions) && $allSubmissions->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="git-branch" class="w-5 h-5 mr-2 text-purple-600"></i>
                    {{ __('Version Control Flow') }}
                    <span class="ml-auto text-sm font-normal text-gray-500">{{ $allSubmissions->count() }} {{ $allSubmissions->count() == 1 ? __('Version') : __('Versions') }}</span>
                </h3>
                
                <div class="space-y-4">
                    @foreach($allSubmissions as $versionSubmission)
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200 {{ $versionSubmission->id === $submission->id ? 'bg-blue-50 border-blue-300' : 'bg-white' }}">
                        <!-- Version Header (Collapsible) -->
                        <button type="button" 
                                onclick="toggleVersionDetailsEA({{ $versionSubmission->id }})"
                                class="w-full p-4 text-left hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="flex-shrink-0 w-12 h-12 {{ $versionSubmission->id === $submission->id ? 'bg-blue-600' : 'bg-gray-400' }} rounded-lg flex items-center justify-center">
                                        <span class="text-lg font-bold text-white">V{{ $versionSubmission->version_number }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="text-base font-semibold text-gray-900">{{ __('Version') }} {{ $versionSubmission->version_number }}</h4>
                                            @if($versionSubmission->id === $submission->id)
                                            <span class="px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded-full">CURRENT</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ __('Submitted on') }} {{ $versionSubmission->submission_date->format('F d, Y \a\t h:i A') }}
                                        </p>
                                        <div class="mt-2">
                                            @php
                                                $statusColors = [
                                                    'submitted' => 'bg-blue-100 text-blue-800',
                                                    'under_review' => 'bg-yellow-100 text-yellow-800',
                                                    'revision_required' => 'bg-orange-100 text-orange-800',
                                                    'disc_review' => 'bg-orange-100 text-orange-800',
                                                    'pending_verify' => 'bg-purple-100 text-purple-800',
                                                    'verified' => 'bg-emerald-100 text-emerald-800',
                                                    'accepted' => 'bg-green-100 text-green-800',
                                                    'published' => 'bg-purple-100 text-purple-800',
                                                    'rejected' => 'bg-red-100 text-red-800',
                                                ];
                                                $statusColor = $statusColors[$versionSubmission->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $versionSubmission->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                                    @if($versionSubmission->file_path)
                                    <a href="{{ asset('storage/' . $versionSubmission->file_path) }}" target="_blank"
                                        onclick="event.stopPropagation();"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                        {{ __('Download') }}
                                    </a>
                                    @endif
                                    <i data-lucide="chevron-down" id="version-icon-ea-{{ $versionSubmission->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                </div>
                            </div>
                        </button>

                        <!-- Version Details (Collapsible Content) -->
                        <div id="version-details-ea-{{ $versionSubmission->id }}" class="hidden border-t border-gray-200">
                            <!-- Version Summary -->
                            <div class="bg-gray-50 px-4 py-3">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-600">{{ __('Reviews') }}:</span>
                                        <span class="font-semibold text-gray-900 ml-1">{{ $versionSubmission->reviews->count() }}</span>
                                    </div>
                                    @if($versionSubmission->plagiarism_percentage !== null)
                                    <div>
                                        <span class="text-gray-600">{{ __('Plagiarism') }}:</span>
                                        <span class="font-semibold {{ $versionSubmission->plagiarism_percentage > 20 ? 'text-red-600' : ($versionSubmission->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600') }} ml-1">
                                            {{ number_format($versionSubmission->plagiarism_percentage, 2) }}%
                                        </span>
                                    </div>
                                    @endif
                                    @if($versionSubmission->approval_status)
                                    <div>
                                        <span class="text-gray-600">{{ __('Approval') }}:</span>
                                        <span class="font-semibold {{ $versionSubmission->approval_status === 'verified' ? 'text-green-600' : ($versionSubmission->approval_status === 'pending' ? 'text-yellow-600' : 'text-red-600') }} ml-1">
                                            {{ ucfirst($versionSubmission->approval_status) }}
                                        </span>
                                    </div>
                                    @endif
                                    <div>
                                        <span class="text-gray-600">{{ __('Updated') }}:</span>
                                        <span class="font-semibold text-gray-900 ml-1">{{ $versionSubmission->updated_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews for this version -->
                            @php
                                $hasReviewDataVersion = function($review) {
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
                                
                                $versionReviews = $versionSubmission->reviews->filter(function($review) use ($hasReviewDataVersion) {
                                    return $hasReviewDataVersion($review);
                                });
                            @endphp
                            @if($versionReviews->count() > 0)
                            <div class="bg-gray-50 px-4 py-4 border-t border-gray-200">
                                <h5 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2 text-indigo-600"></i>
                                    Reviewer Comments ({{ $versionReviews->count() }})
                                </h5>
                                <div class="space-y-3">
                                    @foreach($versionReviews as $review)
                                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                        <!-- Review Header (Collapsible) -->
                                        <button type="button" 
                                                onclick="toggleReviewDetailsEA({{ $review->id }})"
                                                class="w-full px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors text-left">
                                            <div class="flex items-center space-x-3 flex-1">
                                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <i data-lucide="user-check" class="w-5 h-5 text-white"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer->user->name ?? __('Unknown Reviewer') }}</p>
                                                    <p class="text-xs text-gray-500">{{ $review->updated_at?->format('F d, Y \a\t h:i A') ?? __('N/A') }}</p>
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
                                                <i data-lucide="chevron-down" id="review-icon-ea-{{ $review->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                            </div>
                                        </button>
                                        
                                        <!-- Review Details (Collapsible Content) -->
                                        <div id="review-details-ea-{{ $review->id }}" class="hidden px-4 pb-4 space-y-3 border-t border-gray-200">
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
                                                    General Review Comments {{ $review->editor_edited_comments ? '(Edited by Editor)' : '(Original)' }}
                                                </h6>
                                                <div class="text-xs text-gray-700 leading-relaxed ql-editor" style="padding: 0;">
                                                    {!! $review->editor_edited_comments ?? $review->comments !!}
                                                </div>
                                                @if($review->editor_edited_comments && $review->comments && $review->editor_edited_comments !== $review->comments)
                                                <details class="mt-2">
                                                    <summary class="text-xs text-gray-500 cursor-pointer hover:text-gray-700">Show Original Comment</summary>
                                                    <div class="text-xs text-gray-600 bg-gray-100 p-2 rounded mt-1 ql-editor" style="padding: 8px;">
                                                        {!! $review->comments !!}
                                                    </div>
                                                </details>
                                                @endif
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
                                                    <p class="text-xs font-semibold text-green-800">{{ __('Author\'s Reply') }}</p>
                                                </div>
                                                <p class="text-xs text-gray-700 whitespace-pre-wrap leading-relaxed">{{ trim($review->author_reply) }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Reviews Section -->
            @if($submission->reviews->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Current Version Reviews') }} ({{ $submission->reviews->count() }})</h3>
                <div class="space-y-4">
                    @php
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
                        
                        $approvedReviews = $submission->reviews->filter(function($review) use ($hasReviewData) {
                            return ($review->editor_approved === true || $review->editor_approved === 1) && $hasReviewData($review);
                        });
                    @endphp
                    
                    @if($approvedReviews->count() > 0)
                    <div>
                        <h4 class="text-md font-semibold text-green-700 mb-3 flex items-center">
                            <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                            {{ __('Approved Reviews') }} ({{ $approvedReviews->count() }})
                        </h4>
                        <div class="space-y-3">
                            @foreach($approvedReviews as $review)
                            <div class="bg-white border border-green-200 rounded-lg overflow-hidden">
                                <button type="button" 
                                        onclick="toggleReviewDetailsEA({{ $review->id }})"
                                        class="w-full px-4 py-3 flex items-center justify-between hover:bg-green-50 transition-colors text-left">
                                    <div class="flex items-center space-x-3 flex-1">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="user-check" class="w-5 h-5 text-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer->user->name ?? __('Unknown Reviewer') }}</p>
                                            <p class="text-xs text-gray-500">{{ $review->updated_at?->format('F d, Y \a\t h:i A') ?? __('N/A') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                                            {{ __('Approved') }}
                                        </span>
                                        @if($review->recommendation)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                                            $review->recommendation === 'acceptance' ? 'bg-green-100 text-green-800' : 
                                            ($review->recommendation === 'minor_revision' ? 'bg-blue-100 text-blue-800' : 
                                            ($review->recommendation === 'major_revision' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')) 
                                        }}">
                                            {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                                        </span>
                                        @endif
                                        <i data-lucide="chevron-down" id="review-icon-ea-{{ $review->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                    </div>
                                </button>
                                
                                <!-- Review Details (Same structure as version reviews above) -->
                                <div id="review-details-ea-{{ $review->id }}" class="hidden px-4 pb-4 space-y-3 border-t border-green-200">
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

                                    <!-- General Comments -->
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
                                            General Review Comments {{ $review->editor_edited_comments ? '(Edited by Editor)' : '(Original)' }}
                                        </h6>
                                        <div class="text-xs text-gray-700 leading-relaxed ql-editor" style="padding: 0;">
                                            {!! $review->editor_edited_comments ?? $review->comments !!}
                                        </div>
                                        @if($review->editor_edited_comments && $review->comments && $review->editor_edited_comments !== $review->comments)
                                        <details class="mt-2">
                                            <summary class="text-xs text-gray-500 cursor-pointer hover:text-gray-700">Show Original Comment</summary>
                                            <div class="text-xs text-gray-600 bg-gray-100 p-2 rounded mt-1 ql-editor" style="padding: 8px;">
                                                {!! $review->comments !!}
                                            </div>
                                        </details>
                                        @endif
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
                                            <p class="text-xs font-semibold text-green-800">{{ __('Author\'s Reply') }}</p>
                                        </div>
                                        <p class="text-xs text-gray-700 whitespace-pre-wrap leading-relaxed">{{ trim($review->author_reply) }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
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
                        <span class="text-sm text-gray-600">{{ __('Version') }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $submission->version_number }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Reviews') }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $submission->reviews->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Completed Reviews') }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $submission->reviews->whereNotNull('rating')->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Days Since Submission') }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $submission->submission_date ? floor($submission->submission_date->diffInDays(now())) : __('N/A') }}</span>
                    </div>
                </div>
            </div>

            <!-- Submission Timeline -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Timeline') }}</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-full flex items-center justify-center">
                            <i data-lucide="file-text" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ __('Submitted') }}</p>
                            <p class="text-xs text-gray-500">{{ $submission->submission_date?->format('M d, Y H:i') ?? __('N/A') }}</p>
                        </div>
                    </div>
                    @if($submission->reviews->count() > 0 && $submission->reviews->first()?->created_at)
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                            <i data-lucide="eye" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ __('Under Review') }}</p>
                            <p class="text-xs text-gray-500">{{ $submission->reviews->first()->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center">
                            <i data-lucide="clock" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ __('Last Updated') }}</p>
                            <p class="text-xs text-gray-500">{{ $submission->updated_at?->format('M d, Y H:i') ?? __('N/A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Author Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Author Information') }}</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Name') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $article->author->name ?? __('N/A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ __('Email') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $article->author->email ?? __('N/A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- No Submission Available -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <div class="text-center">
            <i data-lucide="file-text" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No Submission Available') }}</h3>
            <p class="text-gray-600 mb-6">{{ __('This article has been accepted but no submission details are available yet.') }}</p>
            
            <!-- Article Basic Information -->
            <div class="bg-gray-50 rounded-lg p-6 text-left max-w-2xl mx-auto">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Article Information') }}</h4>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Title') }}</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $article->title }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Journal') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $article->journal->name ?? __('Unknown Journal') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Category') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $article->category->name ?? __('Uncategorized') }}</p>
                        </div>
                    </div>
                    @if($article->abstract)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Abstract') }}</label>
                        <p class="text-sm text-gray-700">{{ $article->abstract }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Back Button -->
    <div class="flex justify-end">
        <a href="{{ route('editorial_assistant.articles.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            {{ __('Back to Articles') }}
        </a>
    </div>
</div>

<!-- Quill.js CSS for rendering formatted content -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
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
    // Toggle review details for editorial assistant view
    function toggleReviewDetailsEA(reviewId) {
        const details = document.getElementById('review-details-ea-' + reviewId);
        const icon = document.getElementById('review-icon-ea-' + reviewId);
        
        if (!details) {
            console.error('Review details element not found for ID:', reviewId);
            return;
        }
        
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
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

    // Toggle version details for editorial assistant view
    function toggleVersionDetailsEA(submissionId) {
        const details = document.getElementById('version-details-ea-' + submissionId);
        const icon = document.getElementById('version-icon-ea-' + submissionId);
        
        if (!details) {
            console.error('Version details element not found for ID:', submissionId);
            return;
        }
        
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
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

    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endsection
