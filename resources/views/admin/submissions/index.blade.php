@extends('layout.app_admin')

@section('title', 'Submissions Management')
@section('page-title', 'Submissions')
@section('page-description', 'Manage all article submissions')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Submissions</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Submissions Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage all article submissions and reviews</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <!-- Filter Dropdown -->
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option>All Status</option>
                    <option>Submitted</option>
                    <option>Under Review</option>
                    <option>Accepted</option>
                    <option>Published</option>
                    <option>Rejected</option>
                </select>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
            </div>
            <a href="{{ route('admin.submissions.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-600 to-red-600 text-white text-sm font-medium rounded-lg hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Add New Submission
            </a>
        </div>
    </div>

    <!-- Success Message -->
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

    <!-- Submissions Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($submissions as $submission)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
            <!-- Submission Header -->
            <div class="p-6 pb-4">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors duration-200">
                            {{ $submission->article->title ?? 'Untitled Article' }}
                        </h3>
                        <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            <span class="truncate">{{ $submission->article->journal->name ?? 'Unknown Journal' }}</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>{{ $submission->author->name ?? 'Unknown Author' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $submission->status === 'published' ? 'bg-green-100 text-green-800' : 
                               ($submission->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                               ($submission->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                               ($submission->status === 'accepted' ? 'bg-emerald-100 text-emerald-800' : 
                               ($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))) }}">
                            {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Submission Info -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-lg font-bold text-gray-900">v{{ $submission->version_number }}</p>
                        <p class="text-xs text-gray-500">Version</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-lg font-bold text-gray-900">{{ $submission->reviews->count() }}</p>
                        <p class="text-xs text-gray-500">Reviews</p>
                    </div>
                </div>

                <!-- Review Progress -->
                @if($submission->reviews->count() > 0)
                <div class="mb-4">
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                        <span>Review Progress</span>
                        <span>{{ $submission->reviews->whereNotNull('rating')->count() }}/{{ $submission->reviews->count() }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 h-2 rounded-full" 
                             style="width: {{ ($submission->reviews->whereNotNull('rating')->count() / max($submission->reviews->count(), 1)) * 100 }}%"></div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Submission Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <div class="flex items-center space-x-1">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>{{ $submission->submission_date->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>{{ $submission->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.submissions.show', $submission) }}" 
                           class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('admin.submissions.edit', $submission) }}" 
                           class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors duration-200">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.submissions.destroy', $submission) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this submission?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="inbox" class="w-8 h-8 text-orange-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No submissions found</h3>
                <p class="text-gray-500 mb-6">Get started by creating your first submission.</p>
                <a href="{{ route('admin.submissions.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white text-sm font-medium rounded-lg hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Add New Submission
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($submissions->hasPages())
    <div class="flex items-center justify-center">
        {{ $submissions->links() }}
    </div>
    @endif
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
