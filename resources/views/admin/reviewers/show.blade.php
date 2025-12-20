@extends('layout.app_admin')

@section('title', 'Reviewer Details')
@section('page-title', 'Reviewer Details')
@section('page-description', 'View reviewer information and reviews')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('admin.reviewers.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Reviewers</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-900">{{ $reviewer->user->name ?? 'Reviewer' }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Reviewer Info Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-indigo-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-semibold text-lg">{{ strtoupper(substr($reviewer->user->name ?? 'R', 0, 2)) }}</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $reviewer->user->name ?? 'N/A' }}</h2>
                        <p class="text-sm text-gray-600">Reviewer Information</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.reviewers.edit', $reviewer) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $reviewer->user->name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reviewer->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Expertise</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reviewer->expertise ?? 'Not specified' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Specialization</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reviewer->specialization ?? 'Not specified' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $reviewer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($reviewer->status) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Reviews</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $reviewer->reviews->count() }} reviews
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Joined Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reviewer->created_at->format('F d, Y h:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reviewer->updated_at->format('F d, Y h:i A') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Reviews by this Reviewer -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Reviews Completed</h3>
        </div>

        <div class="overflow-x-auto">
            @if($reviewer->reviews->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comments</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reviewer->reviews as $review)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $review->submission->article->title ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($review->rating)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($review->rating >= 8) bg-green-100 text-green-800
                                        @elseif($review->rating >= 5) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $review->rating }}/10
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">Not rated</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-md truncate">{{ $review->comments ?? 'No comments' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $review->review_date ? \Carbon\Carbon::parse($review->review_date)->format('M d, Y') : 'N/A' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="px-6 py-12 text-center">
                <i data-lucide="file-text" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No reviews yet</h3>
                <p class="text-gray-500">This reviewer hasn't completed any reviews.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection

