@extends('layout.app_admin')

@section('title', __('Active Submissions'))
@section('page-title', __('Active Submissions'))
@section('page-description', __('Manage active article submissions'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ __('Active Submissions') }}</span>
</li>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm">
    <!-- Header Section -->
    <div class="bg-gray-50 px-6 py-4 rounded-t-lg">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ __('Active submissions (:count)', ['count' => $articles->count()]) }}</h1>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                <!-- Filters Button -->
                <button class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
                    Filters
                </button>
                <!-- More Options -->
                <button class="p-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                    </svg>
                </button>
                <!-- Search Bar -->
            <div class="relative">
                    <input type="text" placeholder="{{ __('Search submissions, ID, authors, k...') }}" 
                           class="w-80 pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mx-6 mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            </div>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Table Section -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <!-- Table Header -->
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <span>{{ __('ID') }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                            </svg>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ __('Submissions') }}
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ __('Stage') }}
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <span>{{ __('Days') }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                            </svg>
                    </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ __('Editorial Activity') }}
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($articles as $article)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <!-- ID Column -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                        {{ $article->id }}
                    </td>
                    
                    <!-- Submissions Column -->
                    <td class="px-6 py-4 text-sm text-gray-800">
                        <div class="max-w-xs">
                            <div class="font-medium truncate">
                                {{ $article->author->name ?? __('Unknown Author') }} {{ __('et al.') }} — {{ Str::limit($article->title, 50) }}
                    </div>
                </div>
                    </td>

                    <!-- Stage Column -->
                    <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-2">
                            @php
                                $latestSubmission = $article->submissions->sortByDesc('created_at')->first();
                                $reviewRounds = $article->submissions->count();
                                $currentRound = $latestSubmission ? $latestSubmission->version_number : 1;
                            @endphp
                            
                            @if($article->status === 'under_review')
                                <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                                <span class="text-sm text-gray-800">
                                    {{ __('Review (Round :round)', ['round' => $currentRound]) }}
                                </span>
                            @elseif($article->status === 'revision_required')
                                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                <span class="text-sm text-gray-800">
                                    {{ __('Revision Required (Round :round)', ['round' => $currentRound]) }}
                                </span>
                            @elseif($article->status === 'accepted')
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-sm text-gray-800">
                                    {{ __('Accepted (Round :round)', ['round' => $currentRound]) }}
                                </span>
                            @elseif($article->status === 'submitted')
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span class="text-sm text-gray-800">
                                    {{ __('Submitted (Round :round)', ['round' => $currentRound]) }}
                                </span>
                            @elseif($article->status === 'published')
                                <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                                <span class="text-sm text-gray-800">
                                    {{ __('Published') }}
                                </span>
                            @elseif($article->status === 'rejected')
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <span class="text-sm text-gray-800">
                                    {{ __('Rejected (Round :round)', ['round' => $currentRound]) }}
                                </span>
                            @else
                                <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                                <span class="text-sm text-gray-800">
                                    {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                                </span>
                            @endif
                        </div>
                    </td>
                    
                    <!-- Days Column -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                        @php
                            $latestSubmission = $article->submissions->sortByDesc('created_at')->first();
                            $daysInCurrentStage = $latestSubmission ? floor($latestSubmission->created_at->diffInDays(now())) : floor($article->created_at->diffInDays(now()));
                        @endphp
                        {{ $daysInCurrentStage }}
                    </td>
                    
                    <!-- Editorial Activity Column -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-1">
                            @php
                                $latestSubmission = $article->submissions->sortByDesc('created_at')->first();
                                $reviews = $latestSubmission ? $latestSubmission->reviews : collect();
                                $completedReviews = $reviews->whereNotNull('rating');
                                $pendingReviews = $reviews->whereNull('rating');
                                $totalReviews = $reviews->count();
                                $completedCount = $completedReviews->count();
                                $pendingCount = $pendingReviews->count();
                            @endphp
                            
                            @if($totalReviews > 0)
                                <!-- Completed Reviews -->
                                @if($completedCount > 0)
                            <div class="w-6 h-6 bg-green-100 border-2 border-green-300 rounded-full flex items-center justify-center" title="{{ __('Completed Reviews') }}">
                                        <span class="text-xs font-medium text-green-700">{{ $completedCount }}</span>
                                    </div>
                                @endif
                                
                                <!-- Pending Reviews -->
                                @if($pendingCount > 0)
                            <div class="w-6 h-6 bg-yellow-100 border-2 border-yellow-300 rounded-full flex items-center justify-center" title="{{ __('Pending Reviews') }}">
                                        <span class="text-xs font-medium text-yellow-700">{{ $pendingCount }}</span>
                                    </div>
                                @endif
                                
                                <!-- Rejected Reviews -->
                                @if($completedReviews->where('rating', '<', 3)->count() > 0)
                            <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center" title="{{ __('Rejected Reviews') }}">
                                        <span class="text-xs font-bold text-white">{{ $completedReviews->where('rating', '<', 3)->count() }}</span>
                                    </div>
                                @endif
                                
                                <!-- High Rating Reviews -->
                                @if($completedReviews->where('rating', '>=', 4)->count() > 0)
                            <div class="w-6 h-6 bg-blue-100 border-2 border-blue-300 rounded-full flex items-center justify-center" title="{{ __('High Rating Reviews') }}">
                                        <span class="text-xs font-medium text-blue-700">{{ $completedReviews->where('rating', '>=', 4)->count() }}</span>
                                    </div>
                                @endif
                                
                                <!-- Average Rating -->
                                @if($completedCount > 0)
                                    @php $avgRating = round($completedReviews->avg('rating'), 1); @endphp
                                    <div class="w-6 h-6 bg-purple-100 border-2 border-purple-300 rounded-full flex items-center justify-center" title="{{ __('Average Rating: :rating', ['rating' => $avgRating]) }}">
                                        <span class="text-xs font-medium text-purple-700">{{ $avgRating }}</span>
                                    </div>
                                @endif
                            @else
                                <!-- No Reviews Yet -->
                                <div class="w-6 h-6 bg-gray-100 border-2 border-gray-300 rounded-full flex items-center justify-center" title="{{ __('No Reviews Yet') }}">
                                    <span class="text-xs font-medium text-gray-500">0</span>
                                </div>
                            @endif
                            
                            <!-- Show review round indicator if multiple submissions -->
                            @if($article->submissions->count() > 1)
                                <div class="w-6 h-6 bg-indigo-100 border-2 border-indigo-300 rounded-full flex items-center justify-center" title="{{ __('Review Round: :round', ['round' => $currentRound]) }}">
                                    <span class="text-xs font-medium text-indigo-700">R{{ $currentRound }}</span>
                                </div>
                            @endif
                        </div>
                    </td>
                    
                    <!-- Actions Column -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.articles.show', $article) }}" 
                           class="text-blue-600 hover:text-blue-900 transition-colors duration-150">
                            {{ __('View') }}
                        </a>
                    </td>
                </tr>
        @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="file-text" class="w-8 h-8 text-gray-400"></i>
                </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No submissions found') }}</h3>
                            <p class="text-gray-500 mb-4">{{ __('Get started by creating your first article submission.') }}</p>
                            <a href="{{ route('admin.articles.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    {{ __('Add New Article') }}
                </a>
            </div>
                    </td>
                </tr>
        @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $articles->links() }}
    </div>
    @endif
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
