@extends('layout.app_chief_editor')

@section('title', __('Review Article'))
@section('page-title', __('Review Article'))
@section('page-description', __('Accept or reject with comment'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <a href="{{ route('chief_editor.dashboard') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Dashboard') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('chief_editor.articles') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Articles') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ Str::limit($article->title, 30) }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            </div>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
            </div>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if($submission)
    <!-- Article Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-amber-50 to-orange-50">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                            {{ __('Chief Editor Review') }}
                        </span>
                        <span class="text-sm text-gray-500">{{ __('Version') }} {{ $submission->version_number }}</span>
                        <span class="text-sm text-gray-500">{{ $submission->submission_date?->format('M d, Y') ?? __('N/A') }}</span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $article->title }}</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            <span>{{ $article->journal->name ?? __('Unknown Journal') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Article Information -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Article Information') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Title') }}</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $article->title }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Author') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $article->author->name ?? __('N/A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Journal') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $article->journal->name ?? __('N/A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Category') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $article->category->name ?? __('N/A') }}</p>
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

            @if($article->abstract)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Abstract') }}</h3>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-gray-700 leading-relaxed">{{ $article->abstract }}</p>
                </div>
            </div>
            @endif

            @if($article->keywords && $article->keywords->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Keywords') }}</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->keywords as $keyword)
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-sm font-medium">
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
                @else
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl">
                    <p class="text-sm text-gray-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-2 text-gray-400"></i>
                        {{ __('No file uploaded yet') }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Pending Verification File (if author uploaded for verification) -->
            @if($submission->approval_status === 'pending' && $submission->approval_pending_file)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="file-check" class="w-5 h-5 mr-2 text-amber-600"></i>
                    {{ __('Pending Verification File') }}
                </h3>
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <i data-lucide="file-text" class="w-5 h-5 text-purple-600"></i>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ basename($submission->approval_pending_file) }}</p>
                            <p class="text-xs text-gray-500">{{ __('Uploaded by author for verification') }}</p>
                        </div>
                    </div>
                    <a href="{{ asset('storage/' . $submission->approval_pending_file) }}" target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                        {{ __('Download') }}
                    </a>
                </div>
            </div>
            @endif

            <!-- Plagiarism Check & Reports -->
            @if($submission->plagiarism_percentage !== null || $submission->ai_report_file || $submission->other_resources_report_file)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="file-search" class="w-5 h-5 mr-2 text-amber-600"></i>
                    {{ __('Plagiarism Check & Reports') }}
                </h3>
                <div class="space-y-6">
                    @if($submission->plagiarism_percentage !== null)
                    @php
                        $plagGradient = $submission->plagiarism_percentage > 20 ? 'from-red-50 to-pink-50 border-red-300' : ($submission->plagiarism_percentage > 10 ? 'from-yellow-50 to-amber-50 border-yellow-300' : 'from-green-50 to-emerald-50 border-green-300');
                        $plagIconBg = $submission->plagiarism_percentage > 20 ? 'bg-red-600' : ($submission->plagiarism_percentage > 10 ? 'bg-yellow-600' : 'bg-green-600');
                        $plagText = $submission->plagiarism_percentage > 20 ? 'text-red-600' : ($submission->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600');
                    @endphp
                    <div class="bg-gradient-to-r {{ $plagGradient }} border-2 rounded-lg p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 {{ $plagIconBg }} rounded-lg flex items-center justify-center">
                                    <i data-lucide="file-search" class="w-6 h-6 text-white"></i>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Plagiarism Percentage') }}</label>
                                    <p class="text-3xl font-bold {{ $plagText }}">{{ number_format($submission->plagiarism_percentage, 2) }}%</p>
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
                    @if($submission->ai_report_file || $submission->other_resources_report_file)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

            <!-- Disc Review Messages -->
            @if(isset($editorMessages) && $editorMessages->whereIn('recipient_type', ['author', 'both'])->where('is_approval_request', false)->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="message-square" class="w-5 h-5 mr-2 text-amber-600"></i>
                    {{ __('Disc Review Messages') }}
                </h3>
                <div class="space-y-4">
                    @foreach($editorMessages->whereIn('recipient_type', ['author', 'both'])->where('is_approval_request', false) as $message)
                    <div class="rounded-lg p-4 border-2 {{ $message->is_rejection ?? false ? 'bg-red-50 border-red-300' : 'bg-gradient-to-r from-orange-50 to-red-50 border-orange-300' }}">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $message->is_rejection ?? false ? 'bg-red-600' : 'bg-orange-600' }}">
                                    <i data-lucide="{{ ($message->is_rejection ?? false) ? 'x-circle' : 'message-circle' }}" class="w-4 h-4 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $message->sender_type === 'editorial_assistant' ? __('Editorial Assistant') : __('Editor') }}
                                        @if($message->is_rejection ?? false)
                                            <span class="ml-2 px-2 py-0.5 bg-red-600 text-white text-xs rounded-full font-bold">{{ __('REJECTION') }}</span>
                                        @else
                                            <span class="ml-2 px-2 py-0.5 bg-orange-600 text-white text-xs rounded-full font-bold">{{ __('DISC REVIEW') }}</span>
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
            @endif

            <!-- Version Control Flow -->
            @if(isset($allSubmissions) && $allSubmissions->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="git-branch" class="w-5 h-5 mr-2 text-amber-600"></i>
                    {{ __('Version Control Flow') }}
                    <span class="ml-auto text-sm font-normal text-gray-500">{{ $allSubmissions->count() }} {{ $allSubmissions->count() == 1 ? __('Version') : __('Versions') }}</span>
                </h3>
                <div class="space-y-4">
                    @foreach($allSubmissions as $versionSubmission)
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200 {{ $versionSubmission->id === $submission->id ? 'bg-amber-50 border-amber-300' : 'bg-white' }}">
                        <button type="button" onclick="toggleVersionDetailsCE({{ $versionSubmission->id }})"
                                class="w-full p-4 text-left hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="flex-shrink-0 w-12 h-12 {{ $versionSubmission->id === $submission->id ? 'bg-amber-600' : 'bg-gray-400' }} rounded-lg flex items-center justify-center">
                                        <span class="text-lg font-bold text-white">V{{ $versionSubmission->version_number }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="text-base font-semibold text-gray-900">{{ __('Version') }} {{ $versionSubmission->version_number }}</h4>
                                            @if($versionSubmission->id === $submission->id)
                                            <span class="px-2 py-1 bg-amber-600 text-white text-xs font-bold rounded-full">{{ __('CURRENT') }}</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ __('Submitted on') }} {{ $versionSubmission->submission_date?->format('F d, Y \a\t h:i A') ?? __('N/A') }}</p>
                                        <div class="mt-2">
                                            @php
                                                $statusColors = ['submitted'=>'bg-blue-100 text-blue-800','under_review'=>'bg-yellow-100 text-yellow-800','revision_required'=>'bg-orange-100 text-orange-800','disc_review'=>'bg-orange-100 text-orange-800','pending_verify'=>'bg-purple-100 text-purple-800','verified'=>'bg-emerald-100 text-emerald-800','accepted'=>'bg-green-100 text-green-800','chief_editor_review'=>'bg-amber-100 text-amber-800','approved_chief_editor'=>'bg-lime-100 text-lime-800','published'=>'bg-purple-100 text-purple-800','rejected'=>'bg-red-100 text-red-800'];
                                                $statusColor = $statusColors[$versionSubmission->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">{{ ucfirst(str_replace('_', ' ', $versionSubmission->status)) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                                    @if($versionSubmission->file_path)
                                    <a href="{{ asset('storage/' . $versionSubmission->file_path) }}" target="_blank" onclick="event.stopPropagation();"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>{{ __('Download') }}
                                    </a>
                                    @endif
                                    <i data-lucide="chevron-down" id="version-icon-ce-{{ $versionSubmission->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                </div>
                            </div>
                        </button>
                        <div id="version-details-ce-{{ $versionSubmission->id }}" class="hidden border-t border-gray-200">
                            <div class="bg-gray-50 px-4 py-3">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div><span class="text-gray-600">{{ __('Reviews') }}:</span> <span class="font-semibold text-gray-900 ml-1">{{ $versionSubmission->reviews->count() }}</span></div>
                                    @if($versionSubmission->plagiarism_percentage !== null)
                                    <div><span class="text-gray-600">{{ __('Plagiarism') }}:</span> <span class="font-semibold {{ $versionSubmission->plagiarism_percentage > 20 ? 'text-red-600' : ($versionSubmission->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600') }} ml-1">{{ number_format($versionSubmission->plagiarism_percentage, 2) }}%</span></div>
                                    @endif
                                    @if($versionSubmission->approval_status)
                                    <div><span class="text-gray-600">{{ __('Approval') }}:</span> <span class="font-semibold {{ $versionSubmission->approval_status === 'verified' ? 'text-green-600' : ($versionSubmission->approval_status === 'pending' ? 'text-yellow-600' : 'text-red-600') }} ml-1">{{ ucfirst($versionSubmission->approval_status) }}</span></div>
                                    @endif
                                    <div><span class="text-gray-600">{{ __('Updated') }}:</span> <span class="font-semibold text-gray-900 ml-1">{{ $versionSubmission->updated_at->format('M d, Y') }}</span></div>
                                </div>
                            </div>
                            @php
                                $hasReviewDataVersion = function($r) { return !empty($r->comments) || !empty($r->originality_comment) || !empty($r->relationship_to_literature_comment) || !empty($r->methodology_comment) || !empty($r->results_comment) || !empty($r->implications_comment) || !empty($r->quality_of_communication_comment) || !empty($r->strengths) || !empty($r->weaknesses) || !empty($r->suggestions_for_improvement) || $r->relevance_score !== null || $r->originality_score !== null || $r->significance_score !== null || $r->technical_soundness_score !== null || $r->clarity_score !== null || $r->documentation_score !== null || $r->total_score !== null || !empty($r->final_evaluation) || !empty($r->recommendation) || $r->rating !== null; };
                                $versionReviews = $versionSubmission->reviews->filter(fn($r) => $hasReviewDataVersion($r));
                            @endphp
                            @if($versionReviews->count() > 0)
                            <div class="bg-gray-50 px-4 py-4 border-t border-gray-200">
                                <h5 class="text-sm font-semibold text-gray-900 mb-3 flex items-center"><i data-lucide="file-text" class="w-4 h-4 mr-2 text-amber-600"></i> {{ __('Reviewer Comments') }} ({{ $versionReviews->count() }})</h5>
                                <div class="space-y-3">
                                    @foreach($versionReviews as $review)
                                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                        <button type="button" onclick="toggleReviewDetailsCE({{ $review->id }})" class="w-full px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors text-left">
                                            <div class="flex items-center space-x-3 flex-1">
                                                <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <i data-lucide="user-check" class="w-5 h-5 text-white"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer->user->name ?? __('Unknown Reviewer') }}</p>
                                                    <p class="text-xs text-gray-500">{{ $review->updated_at?->format('F d, Y \a\t h:i A') ?? __('N/A') }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                                                @if($review->recommendation)
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $review->recommendation === 'acceptance' ? 'bg-green-100 text-green-800' : ($review->recommendation === 'minor_revision' ? 'bg-blue-100 text-blue-800' : ($review->recommendation === 'major_revision' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')) }}">{{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}</span>
                                                @endif
                                                @if($review->rating)
                                                <div class="flex items-center space-x-1">
                                                    <span class="text-sm font-bold text-gray-900">{{ $review->rating }}/10</span>
                                                    <div class="flex space-x-0.5">
                                                        @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-3 h-3 {{ $i <= ($review->rating / 2) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                        @endfor
                                                    </div>
                                                </div>
                                                @endif
                                                <i data-lucide="chevron-down" id="review-icon-ce-{{ $review->id }}" class="w-5 h-5 text-gray-400 transition-transform"></i>
                                            </div>
                                        </button>
                                        <div id="review-details-ce-{{ $review->id }}" class="hidden px-4 pb-4 space-y-3 border-t border-gray-200">
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                @if($review->final_evaluation)<div class="bg-amber-50 border border-amber-200 rounded-lg p-2"><p class="text-xs text-gray-600 mb-1">{{ __('Evaluation') }}</p><p class="text-sm font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $review->final_evaluation) }}</p></div>@endif
                                                @if($review->total_score !== null)<div class="bg-amber-50 border border-amber-200 rounded-lg p-2"><p class="text-xs text-gray-600 mb-1">{{ __('Total Score') }}</p><p class="text-sm font-semibold text-gray-900">{{ number_format($review->total_score, 1) }}/60</p></div>@endif
                                                @if($review->plagiarism_percentage !== null)<div class="bg-orange-50 border border-orange-200 rounded-lg p-2"><p class="text-xs text-gray-600 mb-1">{{ __('Plagiarism') }}</p><p class="text-sm font-semibold {{ $review->plagiarism_percentage > 20 ? 'text-red-600' : ($review->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600') }}">{{ number_format($review->plagiarism_percentage, 2) }}%</p></div>@endif
                                                @if($review->recommendation)<div class="bg-amber-50 border border-amber-200 rounded-lg p-2"><p class="text-xs text-gray-600 mb-1">{{ __('Recommendation') }}</p><p class="text-sm font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $review->recommendation) }}</p></div>@endif
                                            </div>
                                            @if($review->originality_comment || $review->relationship_to_literature_comment || $review->methodology_comment || $review->results_comment || $review->implications_comment || $review->quality_of_communication_comment)
                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                                <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center"><i data-lucide="file-text" class="w-3 h-3 mr-1"></i> {{ __('General Comments') }}</h6>
                                                <div class="space-y-2 text-xs">
                                                    @if($review->originality_comment)<div class="bg-white rounded p-2"><p class="font-semibold text-gray-700 mb-1">1. {{ __('Originality') }}</p><p class="text-gray-600 whitespace-pre-wrap">{{ $review->originality_comment }}</p></div>@endif
                                                    @if($review->relationship_to_literature_comment)<div class="bg-white rounded p-2"><p class="font-semibold text-gray-700 mb-1">2. {{ __('Relationship to Literature') }}</p><p class="text-gray-600 whitespace-pre-wrap">{{ $review->relationship_to_literature_comment }}</p></div>@endif
                                                    @if($review->methodology_comment)<div class="bg-white rounded p-2"><p class="font-semibold text-gray-700 mb-1">3. {{ __('Methodology') }}</p><p class="text-gray-600 whitespace-pre-wrap">{{ $review->methodology_comment }}</p></div>@endif
                                                    @if($review->results_comment)<div class="bg-white rounded p-2"><p class="font-semibold text-gray-700 mb-1">4. {{ __('Results') }}</p><p class="text-gray-600 whitespace-pre-wrap">{{ $review->results_comment }}</p></div>@endif
                                                    @if($review->implications_comment)<div class="bg-white rounded p-2"><p class="font-semibold text-gray-700 mb-1">5. {{ __('Implications') }}</p><p class="text-gray-600 whitespace-pre-wrap">{{ $review->implications_comment }}</p></div>@endif
                                                    @if($review->quality_of_communication_comment)<div class="bg-white rounded p-2"><p class="font-semibold text-gray-700 mb-1">6. {{ __('Quality of Communication') }}</p><p class="text-gray-600 whitespace-pre-wrap">{{ $review->quality_of_communication_comment }}</p></div>@endif
                                                </div>
                                            </div>
                                            @endif
                                            @if($review->strengths || $review->weaknesses)
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                @if($review->strengths)<div class="bg-green-50 border border-green-200 rounded-lg p-3"><h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center"><i data-lucide="thumbs-up" class="w-3 h-3 mr-1 text-green-600"></i> {{ __('Strengths') }}</h6><p class="text-xs text-gray-700 whitespace-pre-wrap">{{ $review->strengths }}</p></div>@endif
                                                @if($review->weaknesses)<div class="bg-red-50 border border-red-200 rounded-lg p-3"><h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center"><i data-lucide="thumbs-down" class="w-3 h-3 mr-1 text-red-600"></i> {{ __('Weaknesses') }}</h6><p class="text-xs text-gray-700 whitespace-pre-wrap">{{ $review->weaknesses }}</p></div>@endif
                                            </div>
                                            @endif
                                            @if($review->suggestions_for_improvement)<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3"><h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center"><i data-lucide="lightbulb" class="w-3 h-3 mr-1 text-yellow-600"></i> {{ __('Suggestions for Improvement') }}</h6><p class="text-xs text-gray-700 whitespace-pre-wrap">{{ $review->suggestions_for_improvement }}</p></div>@endif
                                            @if($review->relevance_score !== null || $review->originality_score !== null || $review->significance_score !== null || $review->technical_soundness_score !== null || $review->clarity_score !== null || $review->documentation_score !== null)
                                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                                                <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center"><i data-lucide="award" class="w-3 h-3 mr-1 text-purple-600"></i> {{ __('Paper Score') }}</h6>
                                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs">
                                                    @if($review->relevance_score !== null)<div class="bg-white rounded p-2"><p class="text-gray-600">{{ __('Relevance') }}</p><p class="font-semibold text-gray-900">{{ number_format($review->relevance_score, 1) }}/5</p></div>@endif
                                                    @if($review->originality_score !== null)<div class="bg-white rounded p-2"><p class="text-gray-600">{{ __('Originality') }}</p><p class="font-semibold text-gray-900">{{ number_format($review->originality_score, 1) }}/10</p></div>@endif
                                                    @if($review->significance_score !== null)<div class="bg-white rounded p-2"><p class="text-gray-600">{{ __('Significance') }}</p><p class="font-semibold text-gray-900">{{ number_format($review->significance_score, 1) }}/15</p></div>@endif
                                                    @if($review->technical_soundness_score !== null)<div class="bg-white rounded p-2"><p class="text-gray-600">{{ __('Technical Soundness') }}</p><p class="font-semibold text-gray-900">{{ number_format($review->technical_soundness_score, 1) }}/15</p></div>@endif
                                                    @if($review->clarity_score !== null)<div class="bg-white rounded p-2"><p class="text-gray-600">{{ __('Clarity') }}</p><p class="font-semibold text-gray-900">{{ number_format($review->clarity_score, 1) }}/10</p></div>@endif
                                                    @if($review->documentation_score !== null)<div class="bg-white rounded p-2"><p class="text-gray-600">{{ __('Documentation') }}</p><p class="font-semibold text-gray-900">{{ number_format($review->documentation_score, 1) }}/5</p></div>@endif
                                                </div>
                                                @if($review->total_score !== null)<div class="mt-2 pt-2 border-t border-purple-300 bg-white rounded p-2"><div class="flex justify-between items-center"><p class="text-xs font-semibold text-gray-900">{{ __('Total Score') }}</p><p class="text-sm font-bold text-purple-600">{{ number_format($review->total_score, 1) }}/60</p></div></div>@endif
                                            </div>
                                            @endif
                                            @if($review->editor_edited_comments || $review->comments)
                                            <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3">
                                                <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center"><i data-lucide="message-square" class="w-3 h-3 mr-1"></i> {{ __('General Review Comments') }} {{ $review->editor_edited_comments ? '('.__('Edited by Editor').')' : '('.__('Original').')' }}</h6>
                                                <div class="text-xs text-gray-700 leading-relaxed ql-editor" style="padding: 0;">{!! $review->editor_edited_comments ?? $review->comments !!}</div>
                                                @if($review->editor_edited_comments && $review->comments && $review->editor_edited_comments !== $review->comments)
                                                <details class="mt-2"><summary class="text-xs text-gray-500 cursor-pointer hover:text-gray-700">{{ __('Show Original Comment') }}</summary><div class="text-xs text-gray-600 bg-gray-100 p-2 rounded mt-1 ql-editor" style="padding: 8px;">{!! $review->comments !!}</div></details>
                                                @endif
                                            </div>
                                            @endif
                                            @if($review->review_file)
                                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                                                <h6 class="text-xs font-bold text-gray-900 mb-2 flex items-center"><i data-lucide="paperclip" class="w-3 h-3 mr-1 text-purple-600"></i> {{ __('Attached File') }}</h6>
                                                <div class="flex items-center justify-between bg-white rounded-lg p-2 border border-purple-200">
                                                    <div class="flex items-center space-x-2"><i data-lucide="file-text" class="w-4 h-4 text-purple-600"></i><span class="text-xs font-medium text-gray-900">{{ basename($review->review_file) }}</span></div>
                                                    <a href="{{ asset('storage/' . $review->review_file) }}" target="_blank" class="inline-flex items-center px-2 py-1 bg-purple-600 text-white text-xs font-medium rounded-lg hover:bg-purple-700 transition-colors"><i data-lucide="download" class="w-3 h-3 mr-1"></i> {{ __('Download') }}</a>
                                                </div>
                                            </div>
                                            @endif
                                            @if($review->author_reply && trim($review->author_reply) !== '')
                                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-3">
                                                <div class="flex items-center space-x-2 mb-2"><i data-lucide="message-square" class="w-3 h-3 text-green-600"></i><p class="text-xs font-semibold text-green-800">{{ __("Author's Reply") }}</p></div>
                                                <p class="text-xs text-gray-700 whitespace-pre-wrap leading-relaxed">{{ trim($review->author_reply) }}</p>
                                            </div>
                                            @else
                                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                                <p class="text-xs text-gray-500 italic"><i data-lucide="info" class="w-3 h-3 inline mr-1"></i> {{ __('No author reply yet for this review') }}</p>
                                                <p class="text-xs text-gray-400 mt-1"><i data-lucide="clock" class="w-3 h-3 inline mr-1"></i> {{ __('Reviewed on') }} {{ $review->updated_at?->format('M d, Y \a\t h:i A') ?? __('N/A') }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="bg-gray-50 px-4 py-4 border-t border-gray-200">
                                <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
                                    <i data-lucide="file-text" class="w-8 h-8 text-gray-400 mx-auto mb-2"></i>
                                    <p class="text-sm text-gray-600">{{ __('No reviewer comments available yet.') }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ __('Reviews will appear here once they are submitted.') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Current Version Reviews -->
            @if($submission->reviews->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Current Version Reviews') }} ({{ $submission->reviews->count() }})</h3>
                <div class="space-y-4">
                    @foreach($submission->reviews as $review)
                    @php $hasReviewData = !empty($review->comments) || !empty($review->originality_comment) || !empty($review->relationship_to_literature_comment) || !empty($review->methodology_comment) || !empty($review->results_comment) || !empty($review->implications_comment) || !empty($review->quality_of_communication_comment) || !empty($review->strengths) || !empty($review->weaknesses) || !empty($review->suggestions_for_improvement) || $review->relevance_score !== null || $review->originality_score !== null || $review->significance_score !== null || $review->technical_soundness_score !== null || $review->clarity_score !== null || $review->documentation_score !== null || $review->total_score !== null || !empty($review->final_evaluation) || !empty($review->recommendation) || $review->rating !== null; @endphp
                    @if($hasReviewData)
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="p-4 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg flex items-center justify-center">
                                        <i data-lucide="user-check" class="w-5 h-5 text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer->user->name ?? __('Unknown Reviewer') }}</p>
                                        <p class="text-xs text-gray-500">{{ $review->updated_at?->format('F d, Y h:i A') ?? __('N/A') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($review->recommendation)<span class="px-2 py-1 text-xs font-medium rounded-full {{ $review->recommendation === 'acceptance' ? 'bg-green-100 text-green-800' : ($review->recommendation === 'minor_revision' ? 'bg-blue-100 text-blue-800' : ($review->recommendation === 'major_revision' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')) }}">{{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}</span>@endif
                                    @if($review->rating)<span class="text-sm font-bold text-gray-900">{{ $review->rating }}/10</span>@endif
                                </div>
                            </div>
                        </div>
                        <div class="p-4 space-y-3">
                            @if($review->comments || $review->editor_edited_comments)
                            <div class="bg-gray-50 rounded-lg p-3">
                                <h6 class="text-xs font-bold text-gray-900 mb-2">{{ __('Review Comments') }}</h6>
                                <div class="text-sm text-gray-700 leading-relaxed ql-editor">{!! $review->editor_edited_comments ?? $review->comments !!}</div>
                            </div>
                            @endif
                            @if($review->total_score !== null)<p class="text-sm"><span class="font-semibold text-gray-700">{{ __('Total Score') }}:</span> {{ number_format($review->total_score, 1) }}/60</p>@endif
                            @if($review->strengths)<div class="bg-green-50 border border-green-200 rounded-lg p-3"><h6 class="text-xs font-bold text-gray-900 mb-1">{{ __('Strengths') }}</h6><p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->strengths }}</p></div>@endif
                            @if($review->weaknesses)<div class="bg-red-50 border border-red-200 rounded-lg p-3"><h6 class="text-xs font-bold text-gray-900 mb-1">{{ __('Weaknesses') }}</h6><p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->weaknesses }}</p></div>@endif
                            @if($review->suggestions_for_improvement)<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3"><h6 class="text-xs font-bold text-gray-900 mb-1">{{ __('Suggestions') }}</h6><p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->suggestions_for_improvement }}</p></div>@endif
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar: Accept / Reject -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Your Decision') }}</h3>
                <p class="text-sm text-gray-600 mb-6">{{ __('Accept: status will change to approved. Reject: status stays accepted, your comment will be visible to the Editor only.') }}</p>

                <div class="space-y-6">
                    <!-- Accept Form -->
                    <form action="{{ route('chief_editor.articles.accept', $article) }}" method="POST" class="space-y-3">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700">{{ __('Comment (optional)') }}</label>
                        <textarea name="comment" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="{{ __('Optional comment for Editor...') }}"></textarea>
                        <button type="submit" onclick="return confirm(this.dataset.confirm)"
                                data-confirm="{{ __('Approve this article?') }}"
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 font-medium transition-all duration-200 shadow-sm">
                            <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                            {{ __('Accept') }}
                        </button>
                    </form>

                    <div class="border-t border-gray-200 pt-6">
                        <!-- Reject Form -->
                        <form action="{{ route('chief_editor.articles.reject', $article) }}" method="POST" class="space-y-3">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700">{{ __('Rejection Comment (required)') }}</label>
                            <textarea name="comment" rows="3" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="{{ __('Explain what needs to be changed...') }}"></textarea>
                            <button type="submit" onclick="return confirm(this.dataset.confirm)"
                                    data-confirm="{{ __('Reject with comment? Editor will see your feedback.') }}"
                                    class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-lg hover:from-red-700 hover:to-rose-700 font-medium transition-all duration-200 shadow-sm">
                                <i data-lucide="x-circle" class="w-5 h-5 mr-2"></i>
                                {{ __('Reject') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">{{ $article->title }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div><span class="text-gray-500">{{ __('Author') }}:</span> {{ $article->author->name ?? __('N/A') }}</div>
            <div><span class="text-gray-500">{{ __('Journal') }}:</span> {{ $article->journal->name ?? __('N/A') }}</div>
            <div><span class="text-gray-500">{{ __('Category') }}:</span> {{ $article->category->name ?? __('N/A') }}</div>
        </div>
        @if($article->abstract)
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Abstract') }}</label>
            <p class="text-sm text-gray-700">{{ $article->abstract }}</p>
        </div>
        @endif
        <p class="mt-4 text-sm text-amber-600">{{ __('No submission data found.') }}</p>
    </div>
    @endif
</div>
<script>
    function toggleReviewDetailsCE(reviewId) {
        const details = document.getElementById('review-details-ce-' + reviewId);
        const icon = document.getElementById('review-icon-ce-' + reviewId);
        if (!details) return;
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            if (icon) icon.style.transform = 'rotate(180deg)';
        } else {
            details.classList.add('hidden');
            if (icon) icon.style.transform = 'rotate(0deg)';
        }
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
    function toggleVersionDetailsCE(submissionId) {
        const details = document.getElementById('version-details-ce-' + submissionId);
        const icon = document.getElementById('version-icon-ce-' + submissionId);
        if (!details) return;
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            if (icon) icon.style.transform = 'rotate(180deg)';
        } else {
            details.classList.add('hidden');
            if (icon) icon.style.transform = 'rotate(0deg)';
        }
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
@endsection
