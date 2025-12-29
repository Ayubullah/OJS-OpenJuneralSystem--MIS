@extends('layout.app_editor')

@section('title', 'Pending Review Approvals')
@section('page-title', 'Pending Review Approvals')
@section('page-description', 'Review and approve reviewer comments')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Pending Approvals</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-orange-50 to-amber-50">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Pending Review Approvals</h1>
                    <p class="text-sm text-gray-600">Review and approve reviewer comments before they are shown to authors</p>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i data-lucide="clock" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $pendingReviews->total() }}</div>
                        <div class="text-xs text-gray-600">Pending Reviews</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-3"></i>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mr-3"></i>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Pending Reviews List -->
    @if($pendingReviews->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="space-y-4">
                @foreach($pendingReviews as $review)
                <div class="border-2 border-orange-200 rounded-xl p-6 bg-gradient-to-r from-orange-50 to-amber-50 hover:shadow-lg transition-all duration-200">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-blue-500 rounded-lg flex items-center justify-center shadow-md">
                                    <span class="text-lg font-bold text-white">{{ substr($review->reviewer->user->name ?? 'R', 0, 1) }}</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $review->reviewer->user->name ?? 'Unknown Reviewer' }}</h3>
                                    <p class="text-sm text-gray-600">{{ $review->review_date?->format('F d, Y \a\t h:i A') ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <!-- Article Information -->
                            <div class="mb-4 p-3 bg-white rounded-lg border border-gray-200">
                                <div class="flex items-center space-x-2 mb-2">
                                    <i data-lucide="file-text" class="w-4 h-4 text-blue-600"></i>
                                    <span class="text-sm font-semibold text-gray-700">Article:</span>
                                </div>
                                <p class="text-sm font-bold text-gray-900">{{ $review->submission->article->title ?? 'Untitled Article' }}</p>
                                <div class="flex items-center space-x-4 mt-2 text-xs text-gray-600">
                                    <span class="flex items-center">
                                        <i data-lucide="book" class="w-3 h-3 mr-1"></i>
                                        {{ $review->submission->article->journal->name ?? 'Unknown Journal' }}
                                    </span>
                                    <span class="flex items-center">
                                        <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                                        {{ $review->submission->author->name ?? 'Unknown Author' }}
                                    </span>
                                    <span class="flex items-center">
                                        <i data-lucide="hash" class="w-3 h-3 mr-1"></i>
                                        Version {{ $review->submission->version_number }}
                                    </span>
                                </div>
                            </div>

                            <!-- Rating -->
                            @if($review->rating)
                            <div class="mb-4 flex items-center space-x-3">
                                <span class="text-sm font-semibold text-gray-700">Rating:</span>
                                <span class="text-lg font-bold text-gray-900">{{ $review->rating }}/10</span>
                                <div class="flex space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i data-lucide="star" class="w-4 h-4 {{ $i <= ($review->rating / 2) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            @endif

                            <!-- Reviewer Comment -->
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Reviewer's Comment:</label>
                                <div class="bg-white border border-gray-200 rounded-lg p-4">
                                    <div class="text-sm text-gray-700 leading-relaxed ql-editor" style="padding: 0;">
                                        {!! $review->comments !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-3 pt-4 border-t border-orange-200">
                        <a href="{{ route('editor.reviews.edit', $review) }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                            Edit & Approve
                        </a>
                        <form action="{{ route('editor.reviews.approve', $review) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-md hover:shadow-lg"
                                    onclick="return confirm('Are you sure you want to approve this review without editing?')">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                                Approve Without Editing
                            </button>
                        </form>
                        <a href="{{ route('editor.submissions.show', $review->submission) }}" 
                           class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                            View Submission
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $pendingReviews->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12">
        <div class="text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="check-circle" class="w-10 h-10 text-green-600"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">All Caught Up!</h3>
            <p class="text-gray-600 mb-6">There are no pending reviews waiting for approval.</p>
            <a href="{{ route('editor.submissions.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Back to Submissions
            </a>
        </div>
    </div>
    @endif
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

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endsection

