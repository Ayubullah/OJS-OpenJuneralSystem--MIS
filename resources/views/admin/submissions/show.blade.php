@extends('layout.app_admin')

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
    <a href="{{ route('admin.submissions.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Submissions</a>
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
                               ($submission->status === 'accepted' ? 'bg-emerald-100 text-emerald-800' : 
                               ($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))) }}">
                            {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                        </span>
                        <span class="text-sm text-gray-500">Version {{ $submission->version_number }}</span>
                        <span class="text-sm text-gray-500">{{ $submission->submission_date->format('M d, Y') }}</span>
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
                    <a href="{{ route('admin.submissions.edit', $submission) }}" 
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
                    @foreach($submission->reviews as $review)
                    <div class="border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-500 rounded-lg flex items-center justify-center">
                                    <span class="text-xs font-bold text-white">{{ substr($review->reviewer->user->name ?? 'R', 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $review->reviewer->user->name ?? 'Unknown Reviewer' }}</p>
                                    <p class="text-xs text-gray-500">{{ $review->review_date->format('M d, Y') }}</p>
                                </div>
                            </div>
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
                        </div>
                        @if($review->comments)
                        <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $review->comments }}</p>
                        @endif
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
                        <span class="text-sm font-bold text-gray-900">{{ $submission->submission_date->diffInDays(now()) }}</span>
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
                            <p class="text-xs text-gray-500">{{ $submission->submission_date->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    @if($submission->reviews->count() > 0)
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
                            <p class="text-xs text-gray-500">{{ $submission->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.submissions.edit', $submission) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        Edit Submission
                    </a>
                    <button class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                        Send Notification
                    </button>
                    <form action="{{ route('admin.submissions.destroy', $submission) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this submission?')">
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

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
