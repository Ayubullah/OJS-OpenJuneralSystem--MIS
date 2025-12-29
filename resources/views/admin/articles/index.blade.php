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
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.articles.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    {{ __('Add New Article') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white border-b border-gray-200 px-6 py-4">
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               placeholder="Search by title, author name, or ID..." 
                               class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                    </div>
                </div>

                <!-- Journal Filter -->
                <div>
                    <label for="journal_id" class="block text-sm font-medium text-gray-700 mb-2">Journal</label>
                    <select id="journal_id" 
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="all">All Journals</option>
                        @foreach($journals as $journal)
                        <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="category_id" 
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="all">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status" 
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="all">All Status</option>
                        <option value="submitted">Submitted</option>
                        <option value="under_review">Under Review</option>
                        <option value="revision_required">Revision Required</option>
                        <option value="accepted">Accepted</option>
                        <option value="published">Published</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3">
                <button type="button" onclick="clearFilters()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i data-lucide="x" class="w-4 h-4 inline mr-1"></i>
                    Clear
                </button>
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
                <tr class="article-row hover:bg-gray-50 transition-colors duration-150"
                    data-id="{{ $article->id }}"
                    data-title="{{ strtolower($article->title ?? '') }}"
                    data-author-name="{{ strtolower($article->author->name ?? '') }}"
                    data-journal-id="{{ $article->journal_id ?? '' }}"
                    data-journal-name="{{ strtolower($article->journal->name ?? '') }}"
                    data-category-id="{{ $article->category_id ?? '' }}"
                    data-category-name="{{ strtolower($article->category->name ?? '') }}"
                    data-status="{{ $article->status ?? '' }}">
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
                <tr class="empty-state">
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
        <!-- No Results Row (Hidden by default) -->
        <tr id="noResults" style="display: none;">
            <td colspan="6" class="px-6 py-12 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="search-x" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No results found</h3>
                    <p class="text-gray-500 mb-4">Try adjusting your search or filter criteria.</p>
                    <button onclick="clearFilters()" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                        <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                        Clear Filters
                    </button>
                </div>
            </td>
        </tr>
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
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Filter functionality
    function filterArticles() {
        const searchInput = document.getElementById('search');
        const journalSelect = document.getElementById('journal_id');
        const categorySelect = document.getElementById('category_id');
        const statusSelect = document.getElementById('status');
        
        if (!searchInput || !journalSelect || !categorySelect || !statusSelect) {
            console.error('Filter elements not found');
            return;
        }
        
        const searchTerm = searchInput.value.toLowerCase().trim();
        const journalFilter = journalSelect.value;
        const categoryFilter = categorySelect.value;
        const statusFilter = statusSelect.value;
        const articleRows = document.querySelectorAll('.article-row');
        const noResults = document.getElementById('noResults');
        const emptyState = document.querySelector('.empty-state');
        let visibleCount = 0;

        articleRows.forEach(row => {
            const id = String(row.getAttribute('data-id') || '');
            const title = (row.getAttribute('data-title') || '').toLowerCase();
            const authorName = (row.getAttribute('data-author-name') || '').toLowerCase();
            const journalId = String(row.getAttribute('data-journal-id') || '');
            const categoryId = String(row.getAttribute('data-category-id') || '');
            const status = (row.getAttribute('data-status') || '').toLowerCase();
            
            // Search matching
            const matchesSearch = !searchTerm || 
                id.includes(searchTerm) ||
                title.includes(searchTerm) || 
                authorName.includes(searchTerm);
            
            // Journal filter matching
            const matchesJournal = journalFilter === 'all' || journalId === String(journalFilter);
            
            // Category filter matching
            const matchesCategory = categoryFilter === 'all' || categoryId === String(categoryFilter);
            
            // Status filter matching
            const matchesStatus = statusFilter === 'all' || status === statusFilter.toLowerCase();

            if (matchesSearch && matchesJournal && matchesCategory && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0 && articleRows.length > 0) {
            if (noResults) noResults.style.display = '';
            if (emptyState) emptyState.style.display = 'none';
        } else {
            if (noResults) noResults.style.display = 'none';
            if (emptyState && articleRows.length === 0) emptyState.style.display = '';
        }
    }

    function clearFilters() {
        document.getElementById('search').value = '';
        document.getElementById('journal_id').value = 'all';
        document.getElementById('category_id').value = 'all';
        document.getElementById('status').value = 'all';
        filterArticles();
    }

    // Add event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const journalSelect = document.getElementById('journal_id');
        const categorySelect = document.getElementById('category_id');
        const statusSelect = document.getElementById('status');

        if (searchInput) {
            searchInput.addEventListener('input', filterArticles);
            searchInput.addEventListener('keyup', filterArticles);
        }
        if (journalSelect) {
            journalSelect.addEventListener('change', filterArticles);
        }
        if (categorySelect) {
            categorySelect.addEventListener('change', filterArticles);
        }
        if (statusSelect) {
            statusSelect.addEventListener('change', filterArticles);
        }
        
        // Initial filter call to ensure everything is visible
        filterArticles();
    });
</script>
@endsection
