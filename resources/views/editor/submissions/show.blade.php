@extends('layout.app_editor')

@section('title', __('Submission Details'))
@section('page-title', __('Submission Details'))
@section('page-description', __('View submission information and reviews'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('editor.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Submissions') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ __('Details') }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Submission Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-orange-50 to-red-50">
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
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $submission->article->title ?? __('Untitled Article') }}</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            <span>{{ $submission->article->journal->name ?? __('Unknown Journal') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('editor.submissions.edit', $submission) }}" 
                       class="px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2 inline"></i>
                        {{ __('Edit') }}
                    </a>
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
                        <p class="text-sm font-semibold text-gray-900">{{ $submission->article->title ?? __('Untitled Article') }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Journal') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $submission->article->journal->name ?? __('Unknown Journal') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Category') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $submission->article->category->name ?? __('Uncategorized') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submitted File -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Submitted File') }}</h3>
                    <a href="{{ route('editor.submissions.edit', $submission) }}" 
                       class="inline-flex items-center px-3 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        {{ __('Edit File') }}
                    </a>
                </div>
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
                    <i data-lucide="file-search" class="w-5 h-5 mr-2 text-orange-600"></i>
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
                    <i data-lucide="message-square" class="w-5 h-5 mr-2 text-orange-600"></i>
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
                                onclick="toggleVersionDetailsEditor({{ $versionSubmission->id }})"
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
                                    @if($versionSubmission->id !== $submission->id)
                                    <a href="{{ route('editor.submissions.show', $versionSubmission) }}"
                                        onclick="event.stopPropagation();"
                                        class="inline-flex items-center px-3 py-1.5 bg-gray-600 text-white text-xs font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200">
                                        {{ __('View Details') }}
                                    </a>
                                    @endif
                                    <i data-lucide="chevron-down" id="version-icon-editor-{{ $versionSubmission->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                </div>
                            </div>
                        </button>

                        <!-- Version Details (Collapsible Content) -->
                        <div id="version-details-editor-{{ $versionSubmission->id }}" class="hidden border-t border-gray-200">
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
                                // Helper function to check if review has any data
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
                                
                                // Get reviews with data
                                $versionReviews = $versionSubmission->reviews->filter(function($review) use ($hasReviewDataVersion) {
                                    return $hasReviewDataVersion($review);
                                });
                            @endphp
                            @if($versionReviews->count() > 0)
                            <div class="bg-gray-50 px-4 py-4 border-t border-gray-200">
                                <h5 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Reviewer Comments ({{ $versionReviews->count() }})
                                </h5>
                                <div class="space-y-3">
                                    @foreach($versionReviews as $review)
                                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                        <!-- Review Header (Collapsible) -->
                                        <button type="button" 
                                                onclick="toggleReviewDetailsEditor({{ $review->id }})"
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
                                                @if($review->editor_approved)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                    <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                                                    {{ __('Approved') }}
                                                </span>
                                                @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                                    <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                                    {{ __('Pending') }}
                                                </span>
                                                @endif
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
                                                <i data-lucide="chevron-down" id="review-icon-editor-{{ $review->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                            </div>
                                        </button>
                                        
                                        <!-- Review Details (Collapsible Content) - Same structure as before -->
                                        <div id="review-details-editor-{{ $review->id }}" class="hidden px-4 pb-4 space-y-3 border-t border-gray-200">
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
                                            @else
                                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                                <p class="text-xs text-gray-500 italic">
                                                    <i data-lucide="info" class="w-3 h-3 inline mr-1"></i>
                                                    {{ __('No author reply yet for this review') }}
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    <i data-lucide="clock" class="w-3 h-3 inline mr-1"></i>
                                                    {{ __('Reviewed on') }} {{ $review->updated_at?->format('M d, Y \a\t h:i A') ?? __('N/A') }}
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
                            <div class="bg-gray-50 px-4 py-4 border-t border-gray-200">
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

            <!-- Pending Verification Files -->
            @if($submission->approval_status === 'pending' && $submission->approval_pending_file)
            <div class="bg-white rounded-2xl shadow-lg border-2 border-purple-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-purple-900 flex items-center">
                        <i data-lucide="clock" class="w-5 h-5 mr-2"></i>
                        {{ __('Pending Verification Files') }}
                    </h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        {{ __('Pending Review') }}
                    </span>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="file-check" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ basename($submission->approval_pending_file) }}</p>
                                <p class="text-xs text-gray-500">{{ __('Uploaded for verification') }}</p>
                                @if($submission->updated_at)
                                <p class="text-xs text-gray-400 mt-1">{{ __('Uploaded') }}: {{ $submission->updated_at->format('M d, Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $submission->approval_pending_file) }}" target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200 shadow-sm">
                            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                            {{ __('Download') }}
                        </a>
                    </div>
                    
                    <!-- Verification Actions -->
                    <div class="flex items-center space-x-3 pt-4 border-t border-purple-200">
                        <form action="{{ route('editor.submissions.approve-article', $submission) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('{{ __('Are you sure you want to verify this article? This will change the status to verified.') }}')"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                                {{ __('Verify Article') }}
                            </button>
                        </form>
                        <form action="{{ route('editor.submissions.reject-approval', $submission) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('{{ __('Are you sure you want to reject this verification request? The author will be notified.') }}')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                                <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>
                                {{ __('Reject / Request Changes') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Reviews -->
            @if($submission->reviews->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Reviews') }} ({{ $submission->reviews->count() }})</h3>
                <div class="space-y-4">
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
                        
                        // Get pending reviews (not approved but have data)
                        $pendingReviews = $submission->reviews->filter(function($review) use ($hasReviewData) {
                            return ($review->editor_approved === false || $review->editor_approved === null) && $hasReviewData($review);
                        });
                        
                        // Get approved reviews (approved and have data)
                        $approvedReviews = $submission->reviews->filter(function($review) use ($hasReviewData) {
                            return ($review->editor_approved === true || $review->editor_approved === 1) && $hasReviewData($review);
                        });
                    @endphp
                    
                    @if($pendingReviews->count() > 0)
                    <div class="mb-6">
                        <h4 class="text-md font-semibold text-orange-700 mb-3 flex items-center">
                            <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                            {{ __('Pending Approval') }} ({{ $pendingReviews->count() }})
                        </h4>
                        <div class="space-y-4">
                            @foreach($pendingReviews as $review)
                            <div class="border-2 border-orange-200 rounded-xl p-4 bg-orange-50">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-500 rounded-lg flex items-center justify-center">
                                            <span class="text-xs font-bold text-white">{{ substr($review->reviewer->user->name ?? 'R', 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $review->reviewer->user->name ?? 'Unknown Reviewer' }}</p>
                                            <p class="text-xs text-gray-500">{{ $review->review_date?->format('M d, Y') ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    @if($review->rating)
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-bold text-gray-900">{{ $review->rating }}/10</span>
                                        <div class="flex space-x-1">
                                            @for($i = 1; $i <= 5; $i++)
                                            <i data-lucide="star" class="w-4 h-4 {{ $i <= ($review->rating / 2) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @if($review->comments)
                                <div class="mb-4">
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">{{ __('Reviewer\'s Original Comment:') }}</label>
                                    <div class="text-sm text-gray-700 bg-white border border-gray-200 p-3 rounded-lg ql-editor" style="padding: 12px;">
                                        {!! $review->comments !!}
                                    </div>
                                </div>
                                @endif
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('editor.reviews.edit', $review) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                                        {{ __('Edit & Approve') }}
                                    </a>
                                    <form action="{{ route('editor.reviews.approve', $review) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                            <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                                            {{ __('Approve Without Editing') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($approvedReviews->count() > 0)
                    <div>
                        <h4 class="text-md font-semibold text-green-700 mb-3 flex items-center">
                            <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                            {{ __('Approved Reviews') }} ({{ $approvedReviews->count() }})
                        </h4>
                        <div class="space-y-4">
                            @foreach($approvedReviews as $review)
                            <div class="border border-gray-200 rounded-xl overflow-hidden bg-white">
                                <!-- Review Header (Collapsible) -->
                                <button type="button" 
                                        onclick="toggleReviewDetailsEditor({{ $review->id }})"
                                        class="w-full p-4 flex items-center justify-between hover:bg-gray-50 transition-colors text-left">
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
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
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
                                        <i data-lucide="chevron-down" id="review-icon-editor-{{ $review->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                    </div>
                                </button>
                                
                                <!-- Review Details (Collapsible Content) -->
                                <div id="review-details-editor-{{ $review->id }}" class="hidden px-4 pb-4 space-y-3 border-t border-gray-200">
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
                    @endif

                    @if($submission->reviews->whereNull('comments')->count() > 0)
                    <div>
                        <h4 class="text-md font-semibold text-gray-700 mb-3">{{ __('Reviews Without Comments') }} ({{ $submission->reviews->whereNull('comments')->count() }})</h4>
                        <div class="space-y-2">
                            @foreach($submission->reviews->whereNull('comments') as $review)
                            <div class="border border-gray-200 rounded-xl p-3 bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-500 rounded-lg flex items-center justify-center">
                                            <span class="text-xs font-bold text-white">{{ substr($review->reviewer->user->name ?? 'R', 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $review->reviewer->user->name ?? __('Unknown Reviewer') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('No comment submitted yet') }}</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('editor.reviews.remind-reviewer', $review) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                                title="{{ __('Send Reminder') }}">
                                            <i data-lucide="mail" class="w-4 h-4"></i>
                                        </button>
                                    </form>
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
                        <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center">
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

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Actions') }}</h3>
                <div class="space-y-3">
                    <a href="{{ route('editor.submissions.edit', $submission) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        {{ __('Edit Submission') }}
                    </a>
                    <button onclick="openMessageModal()" class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i data-lucide="message-square" class="w-4 h-4 mr-2"></i>
                        {{ __('Send Message') }}
                    </button>
                    <form action="{{ route('editor.submissions.destroy', $submission) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this submission?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                            {{ __('Delete Submission') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quill.js CSS for rendering formatted content -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    /* Quill editor content styling */
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

<!-- Message Modal -->
<div id="messageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">{{ __('Send Message') }}</h3>
                <button onclick="closeMessageModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="messageForm" method="POST" action="{{ route('editor.submissions.send-message', $submission) }}">
                @csrf
                @if(request('from') === 'reminders')
                    <input type="hidden" name="redirect_to" value="reminders">
                @endif
                <div class="mb-4">
                    <label for="recipientType" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Send To') }} *</label>
                    <select id="recipientType" name="recipient_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="both">{{ __('Both Author and Reviewers') }}</option>
                        <option value="author">{{ __('Author Only') }}</option>
                        <option value="reviewer">{{ __('Reviewers Only') }}</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="messageText" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Message') }} *</label>
                    <textarea id="messageText" name="message" rows="6" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="{{ __('Enter your message here...') }}"></textarea>
                    <p class="text-xs text-gray-500 mt-1">{{ __('This message will be visible to the selected recipients') }}</p>
                </div>
                
                <!-- Send for Verification Option - Only show when status IS accepted or verified -->
                @if($submission->status === 'accepted' || $submission->status === 'verified' || $submission->article->status === 'accepted' || $submission->article->status === 'verified')
                <div class="mb-4">
                    <div class="flex items-start space-x-3 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                        <input type="checkbox" id="sendForApproval" name="send_for_approval" value="1" 
                               class="mt-1 w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500"
                               @if($submission->approval_status === 'pending' || $submission->approval_status === 'verified') disabled @endif>
                        <div class="flex-1">
                            <label for="sendForApproval" class="block text-sm font-medium text-gray-900 cursor-pointer">
                                {{ __('Send for Verification') }}
                            </label>
                            <p class="text-xs text-gray-600 mt-1">
                                {{ __('When checked, this will change the article status to "Pending Verify" and request the author to upload a revised file for verification.') }}
                            </p>
                            @if($submission->approval_status === 'pending')
                                <p class="text-xs text-orange-600 mt-1 font-semibold">
                                    ⚠️ {{ __('A verification request is already pending. Please wait for the author to upload a file.') }}
                                </p>
                            @elseif($submission->approval_status === 'verified')
                                <p class="text-xs text-green-600 mt-1 font-semibold">
                                    ✓ {{ __('This article has already been verified.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <p class="text-xs text-blue-800">
                        <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                        <strong>{{ __('Article') }}:</strong> {{ $submission->article->title }}
                    </p>
                </div>
                
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeMessageModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i data-lucide="send" class="w-4 h-4 inline mr-2"></i>
                        {{ __('Send Message') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle review details for editor view
    function toggleReviewDetailsEditor(reviewId) {
        const details = document.getElementById('review-details-editor-' + reviewId);
        const icon = document.getElementById('review-icon-editor-' + reviewId);
        
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

    // Toggle version details for editor view
    function toggleVersionDetailsEditor(submissionId) {
        const details = document.getElementById('version-details-editor-' + submissionId);
        const icon = document.getElementById('version-icon-editor-' + submissionId);
        
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

    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    function openMessageModal() {
        const modal = document.getElementById('messageModal');
        modal.classList.remove('hidden');
        lucide.createIcons();
    }

    function closeMessageModal() {
        const modal = document.getElementById('messageModal');
        const form = document.getElementById('messageForm');
        modal.classList.add('hidden');
        form.reset();
    }

    // Close modal when clicking outside
    document.getElementById('messageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeMessageModal();
        }
    });
</script>
@endsection
