@extends('layout.app_editor')

@section('title', 'Submission Details')
@section('page-title', 'Submission Details')
@section('page-description', 'View submission information and reviews')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('editor.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Submissions</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Details</span>
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
                        <span class="text-sm text-gray-500">Version {{ $submission->version_number }}</span>
                        <span class="text-sm text-gray-500">{{ $submission->submission_date?->format('M d, Y') ?? 'N/A' }}</span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $submission->article->title ?? 'Untitled Article' }}</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            <span>{{ $submission->article->journal->name ?? 'Unknown Journal' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>{{ $submission->author->name ?? 'Unknown Author' }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('editor.submissions.edit', $submission) }}" 
                       class="px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2 inline"></i>
                        Edit
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
                <h3 class="text-lg font-bold text-gray-900 mb-4">Article Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Title</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $submission->article->title ?? 'Untitled Article' }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Journal</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $submission->article->journal->name ?? 'Unknown Journal' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Category</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $submission->article->category->name ?? 'Uncategorized' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submitted File -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Submitted File</h3>
                    <a href="{{ route('editor.submissions.edit', $submission) }}" 
                       class="inline-flex items-center px-3 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        Edit File
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
                                <p class="text-xs text-gray-500">Version {{ $submission->version_number }}</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                            Download
                        </a>
                    </div>
                </div>
                @else
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl">
                    <p class="text-sm text-gray-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-2 text-gray-400"></i>
                        No file uploaded yet
                    </p>
                </div>
                @endif
            </div>

            <!-- Pending Verification Files -->
            @if($submission->approval_status === 'pending' && $submission->approval_pending_file)
            <div class="bg-white rounded-2xl shadow-lg border-2 border-purple-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-purple-900 flex items-center">
                        <i data-lucide="clock" class="w-5 h-5 mr-2"></i>
                        Pending Verification Files
                    </h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        Pending Review
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
                                <p class="text-xs text-gray-500">Uploaded for verification</p>
                                @if($submission->updated_at)
                                <p class="text-xs text-gray-400 mt-1">Uploaded: {{ $submission->updated_at->format('M d, Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $submission->approval_pending_file) }}" target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200 shadow-sm">
                            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                            Download
                        </a>
                    </div>
                    
                    <!-- Verification Actions -->
                    <div class="flex items-center space-x-3 pt-4 border-t border-purple-200">
                        <form action="{{ route('editor.submissions.approve-article', $submission) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to verify this article? This will change the status to verified.')"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                                Verify Article
                            </button>
                        </form>
                        <form action="{{ route('editor.submissions.reject-approval', $submission) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to reject this verification request? The author will be notified.')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                                <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>
                                Reject / Request Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Author Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Author Information</h3>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center">
                        <span class="text-lg font-bold text-white">{{ substr($submission->author->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $submission->author->name ?? 'Unknown Author' }}</h4>
                        <p class="text-sm text-gray-600">{{ $submission->author->email ?? 'No email' }}</p>
                        <p class="text-sm text-gray-500">{{ $submission->author->affiliation ?? 'No affiliation' }}</p>
                    </div>
                </div>
            </div>

            <!-- Reviews -->
            @if($submission->reviews->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Reviews ({{ $submission->reviews->count() }})</h3>
                <div class="space-y-4">
                    @php
                        $pendingReviews = $submission->reviews->whereNotNull('comments')->where('editor_approved', false);
                        $approvedReviews = $submission->reviews->whereNotNull('comments')->where('editor_approved', true);
                    @endphp
                    
                    @if($pendingReviews->count() > 0)
                    <div class="mb-6">
                        <h4 class="text-md font-semibold text-orange-700 mb-3 flex items-center">
                            <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                            Pending Approval ({{ $pendingReviews->count() }})
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
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">Reviewer's Original Comment:</label>
                                    <div class="text-sm text-gray-700 bg-white border border-gray-200 p-3 rounded-lg ql-editor" style="padding: 12px;">
                                        {!! $review->comments !!}
                                    </div>
                                </div>
                                @endif
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('editor.reviews.edit', $review) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                                        Edit & Approve
                                    </a>
                                    <form action="{{ route('editor.reviews.approve', $review) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                            <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                                            Approve Without Editing
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
                            Approved Reviews ({{ $approvedReviews->count() }})
                        </h4>
                        <div class="space-y-4">
                            @foreach($approvedReviews as $review)
                            <div class="border border-gray-200 rounded-xl p-4">
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
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                                        Approved
                                    </span>
                                </div>
                                @if($review->editor_edited_comments || $review->comments)
                                <div class="mb-2">
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">Comment ({{ $review->editor_edited_comments ? 'Edited by Editor' : 'Original' }}):</label>
                                    <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg ql-editor" style="padding: 12px;">
                                        {!! $review->editor_edited_comments ?? $review->comments !!}
                                    </div>
                                </div>
                                @if($review->editor_edited_comments && $review->comments !== $review->editor_edited_comments)
                                <details class="mt-2">
                                    <summary class="text-xs text-gray-500 cursor-pointer hover:text-gray-700">Show Original Comment</summary>
                                    <div class="text-xs text-gray-600 bg-gray-100 p-2 rounded mt-1 ql-editor" style="padding: 8px;">
                                        {!! $review->comments !!}
                                    </div>
                                </details>
                                @endif
                                @endif
                                @if($review->rating)
                                <div class="flex items-center space-x-2 mt-3">
                                    <span class="text-sm font-bold text-gray-900">Rating: {{ $review->rating }}/10</span>
                                    <div class="flex space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                        <i data-lucide="star" class="w-4 h-4 {{ $i <= ($review->rating / 2) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                @endif
                                @if($review->plagiarism_percentage !== null)
                                <div class="flex items-center space-x-2 mt-3 p-2 bg-gradient-to-r from-orange-50 to-red-50 border border-orange-200 rounded-lg">
                                    <i data-lucide="file-search" class="w-4 h-4 text-orange-600"></i>
                                    <span class="text-sm text-gray-700">Plagiarism Percentage:</span>
                                    <span class="text-sm font-bold {{ $review->plagiarism_percentage > 20 ? 'text-red-600' : ($review->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                        {{ number_format($review->plagiarism_percentage, 2) }}%
                                    </span>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($submission->reviews->whereNull('comments')->count() > 0)
                    <div>
                        <h4 class="text-md font-semibold text-gray-700 mb-3">Reviews Without Comments ({{ $submission->reviews->whereNull('comments')->count() }})</h4>
                        <div class="space-y-2">
                            @foreach($submission->reviews->whereNull('comments') as $review)
                            <div class="border border-gray-200 rounded-xl p-3 bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-500 rounded-lg flex items-center justify-center">
                                            <span class="text-xs font-bold text-white">{{ substr($review->reviewer->user->name ?? 'R', 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $review->reviewer->user->name ?? 'Unknown Reviewer' }}</p>
                                            <p class="text-xs text-gray-500">No comment submitted yet</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('editor.reviews.remind-reviewer', $review) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                                title="Send Reminder">
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
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Stats</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Version</span>
                        <span class="text-sm font-bold text-gray-900">{{ $submission->version_number }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Reviews</span>
                        <span class="text-sm font-bold text-gray-900">{{ $submission->reviews->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Completed Reviews</span>
                        <span class="text-sm font-bold text-gray-900">{{ $submission->reviews->whereNotNull('rating')->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Days Since Submission</span>
                        <span class="text-sm font-bold text-gray-900">{{ $submission->submission_date ? floor($submission->submission_date->diffInDays(now())) : 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Submission Timeline -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center">
                            <i data-lucide="file-text" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Submitted</p>
                            <p class="text-xs text-gray-500">{{ $submission->submission_date?->format('M d, Y H:i') ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @if($submission->reviews->count() > 0 && $submission->reviews->first()?->created_at)
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                            <i data-lucide="eye" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Under Review</p>
                            <p class="text-xs text-gray-500">{{ $submission->reviews->first()->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center">
                            <i data-lucide="clock" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Last Updated</p>
                            <p class="text-xs text-gray-500">{{ $submission->updated_at?->format('M d, Y H:i') ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('editor.submissions.edit', $submission) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        Edit Submission
                    </a>
                    <button onclick="openMessageModal()" class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i data-lucide="message-square" class="w-4 h-4 mr-2"></i>
                        Send Message
                    </button>
                    <form action="{{ route('editor.submissions.destroy', $submission) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this submission?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                            Delete Submission
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
                <h3 class="text-xl font-bold text-gray-900">Send Message</h3>
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
                    <label for="recipientType" class="block text-sm font-medium text-gray-700 mb-2">Send To *</label>
                    <select id="recipientType" name="recipient_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="both">Both Author and Reviewers</option>
                        <option value="author">Author Only</option>
                        <option value="reviewer">Reviewers Only</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="messageText" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                    <textarea id="messageText" name="message" rows="6" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Enter your message here..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">This message will be visible to the selected recipients</p>
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
                                Send for Verification
                            </label>
                            <p class="text-xs text-gray-600 mt-1">
                                When checked, this will change the article status to "Pending Verify" and request the author to upload a revised file for verification.
                            </p>
                            @if($submission->approval_status === 'pending')
                                <p class="text-xs text-orange-600 mt-1 font-semibold">
                                    ⚠️ A verification request is already pending. Please wait for the author to upload a file.
                                </p>
                            @elseif($submission->approval_status === 'verified')
                                <p class="text-xs text-green-600 mt-1 font-semibold">
                                    ✓ This article has already been verified.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <p class="text-xs text-blue-800">
                        <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                        <strong>Article:</strong> {{ $submission->article->title }}
                    </p>
                </div>
                
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeMessageModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i data-lucide="send" class="w-4 h-4 inline mr-2"></i>
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
