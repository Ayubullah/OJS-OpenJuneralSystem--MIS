@extends('layout.app_admin')

@section('title', __('Submissions Management'))
@section('page-title', __('Submissions'))
@section('page-description', __('Manage all article submissions'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ __('Submissions') }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center space-x-3">
                <h1 class="text-2xl font-bold text-gray-900">{{ __('Submissions Management') }}</h1>
                @if(isset($statusFilter))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $statusFilter === 'published' ? 'bg-green-100 text-green-800' : 
                       ($statusFilter === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                       ($statusFilter === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                       ($statusFilter === 'accepted' ? 'bg-emerald-100 text-emerald-800' : 
                       ($statusFilter === 'rejected' ? 'bg-red-100 text-red-800' : 
                       ($statusFilter === 'revision_required' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800'))))) }}">
                    {{ __(ucfirst(str_replace('_', ' ', $statusFilter))) }}
                </span>
                @endif
            </div>
            <p class="mt-1 text-sm text-gray-600">
                @if(isset($statusFilter))
                    {{ __('Showing :status submissions', ['status' => __(ucfirst(str_replace('_', ' ', $statusFilter)))]) }}
                @else
                    {{ __('Manage all article submissions and reviews') }}
                @endif
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <!-- Search Input with Filter -->
            <div class="flex items-center space-x-2">
                <!-- Search Field Selector -->
                <div class="relative">
                    <select id="searchField" 
                            class="appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <option value="all">{{ __('All Fields') }}</option>
                        <option value="id">{{ __('Article ID') }}</option>
                        <option value="title">{{ __('Article Title') }}</option>
                        <option value="journal">{{ __('Journal') }}</option>
                        <option value="status">{{ __('Status') }}</option>
                    </select>
                    <i data-lucide="filter" class="w-4 h-4 text-gray-400 absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                </div>
                
                <!-- Search Input -->
                <div class="relative">
                    <input type="text" 
                           id="searchInput"
                           placeholder="{{ __('Search...') }}" 
                           class="pl-10 pr-10 py-2 w-64 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                    <button id="clearSearch" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
            
            <!-- Filter Dropdown -->
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option>{{ __('All Status') }}</option>
                    <option>{{ __('Submitted') }}</option>
                    <option>{{ __('Under Review') }}</option>
                    <option>{{ __('Accepted') }}</option>
                    <option>{{ __('Published') }}</option>
                    <option>{{ __('Rejected') }}</option>
                </select>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
            </div>
            
            <a href="{{ route('admin.submissions.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-600 to-red-600 text-white text-sm font-medium rounded-lg hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                {{ __('Add New Submission') }}
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

    <!-- Submissions Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-orange-50 to-red-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            {{ __('Article ID') }}
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            {{ __('Article Title') }}
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            {{ __('Journal') }}
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            {{ __('Status') }}
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            {{ __('Version') }}
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            {{ __('Reviews') }}
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            {{ __('Submission Date') }}
                        </th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody id="submissionsTableBody" class="bg-white divide-y divide-gray-200">
                    @forelse($submissions as $submission)
                    <tr class="submission-row hover:bg-gray-50 transition-colors duration-200" 
                        data-article-id="{{ $submission->article->id ?? '' }}"
                        data-article-title="{{ strtolower($submission->article->title ?? '') }}"
                        data-journal="{{ strtolower($submission->article->journal->name ?? '') }}"
                        data-author="{{ strtolower($submission->author->name ?? '') }}"
                        data-status="{{ strtolower($submission->status) }}">
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                #{{ $submission->article->id ?? __('N/A') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">
                            {{ $submission->article->title ?? __('Untitled Article') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <i data-lucide="book" class="w-4 h-4 text-gray-400"></i>
                                <span class="text-sm text-gray-700">{{ $submission->article->journal->name ?? __('Unknown Journal') }}</span>
                        </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            {{ $submission->status === 'published' ? 'bg-green-100 text-green-800' : 
                               ($submission->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                               ($submission->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                               ($submission->status === 'accepted' ? 'bg-emerald-100 text-emerald-800' : 
                               ($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))) }}">
                            {{ __(ucfirst(str_replace('_', ' ', $submission->status))) }}
                        </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                v{{ $submission->version_number }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-bold text-gray-900">{{ $submission->reviews->count() }}</span>
                @if($submission->reviews->count() > 0)
                                <div class="w-full max-w-[80px] bg-gray-200 rounded-full h-1.5 mt-1">
                                    <div class="bg-gradient-to-r from-orange-500 to-red-500 h-1.5 rounded-full" 
                             style="width: {{ ($submission->reviews->whereNotNull('rating')->count() / max($submission->reviews->count(), 1)) * 100 }}%"></div>
                </div>
                @endif
            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-1 text-sm text-gray-500">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>{{ $submission->submission_date->format('M d, Y') }}</span>
                        </div>
                            <div class="flex items-center space-x-1 text-xs text-gray-400 mt-1">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                            <span>{{ $submission->updated_at->diffForHumans() }}</span>
                        </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                        <a href="{{ route('admin.submissions.show', $submission) }}" 
                                   class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                   title="{{ __('View') }}">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('admin.submissions.edit', $submission) }}" 
                                   class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors duration-200"
                                   title="{{ __('Edit') }}">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('admin.submissions.assign-reviewer', $submission) }}" 
                                   class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                   title="{{ __('Send to Reviewer') }}">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.submissions.destroy', $submission) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this submission?') }}')">
                            @csrf
                            @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                            title="{{ __('Delete') }}">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                        </td>
                    </tr>
        @empty
                    <tr class="empty-state">
                        <td colspan="9" class="px-6 py-12">
                            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="inbox" class="w-8 h-8 text-orange-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No submissions found') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('Get started by creating your first submission.') }}</p>
                <a href="{{ route('admin.submissions.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white text-sm font-medium rounded-lg hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    {{ __('Add New Submission') }}
                </a>
            </div>
                        </td>
                    </tr>
                    @endforelse
                    <!-- No Search Results Row (Hidden by default) -->
                    <tr id="noResults" class="hidden">
                        <td colspan="9" class="px-6 py-12">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                    <i data-lucide="search-x" class="w-8 h-8 text-gray-400"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No results found') }}</h3>
                                <p class="text-gray-500">{{ __('Try adjusting your search to find what you\'re looking for.') }}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($submissions->hasPages())
    <div class="flex items-center justify-center">
        {{ $submissions->links() }}
    </div>
    @endif
</div>

<script>
    // Wrap in IIFE to avoid variable conflicts with layout script
    (function() {
        // Search functionality
        const pageSearchInput = document.getElementById('searchInput');
        const searchField = document.getElementById('searchField');
        const clearSearchBtn = document.getElementById('clearSearch');
        const submissionRows = document.querySelectorAll('.submission-row');
        const noResultsRow = document.getElementById('noResults');
        const emptyState = document.querySelector('.empty-state');

        // Update placeholder based on selected field
        function updatePlaceholder() {
            if (!searchField || !pageSearchInput) return;
            const fieldValue = searchField.value;
            const placeholders = {
                'all': '{{ __('Search all fields...') }}',
                'id': '{{ __('Search by Article ID...') }}',
                'title': '{{ __('Search by Article Title...') }}',
                'journal': '{{ __('Search by Journal...') }}',
                'status': '{{ __('Search by Status...') }}'
            };
            pageSearchInput.placeholder = placeholders[fieldValue] || '{{ __('Search...') }}';
        }

        // Search function
        function performSearch() {
            if (!pageSearchInput) return;
            const searchTerm = pageSearchInput.value.toLowerCase().trim();
            const selectedField = searchField ? searchField.value : 'all';
            let visibleCount = 0;

            // Show/hide clear button
            if (clearSearchBtn) {
                if (searchTerm) {
                    clearSearchBtn.classList.remove('hidden');
                } else {
                    clearSearchBtn.classList.add('hidden');
                }
            }

            // Hide empty state when searching
            if (emptyState) {
                emptyState.classList.add('hidden');
            }

            // Filter rows
            submissionRows.forEach(row => {
                let searchContent = '';
                
                // Get search content based on selected field
                if (selectedField === 'all') {
                    // Search all fields
                    searchContent = 
                        row.getAttribute('data-article-id') + ' ' +
                        row.getAttribute('data-article-title') + ' ' +
                        row.getAttribute('data-journal') + ' ' +
                        row.getAttribute('data-status');
                } else if (selectedField === 'id') {
                    searchContent = row.getAttribute('data-article-id');
                } else if (selectedField === 'title') {
                    searchContent = row.getAttribute('data-article-title');
                } else if (selectedField === 'journal') {
                    searchContent = row.getAttribute('data-journal');
                } else if (selectedField === 'status') {
                    searchContent = row.getAttribute('data-status');
                }
                
                searchContent = searchContent.toLowerCase();
                
                if (searchContent.includes(searchTerm)) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });

            // Show/hide no results message
            if (noResultsRow) {
                if (searchTerm && visibleCount === 0) {
                    noResultsRow.classList.remove('hidden');
                } else {
                    noResultsRow.classList.add('hidden');
                }
            }

            // Reinitialize icons for newly visible elements
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        // Clear search function
        function clearSearch() {
            if (!pageSearchInput) return;
            pageSearchInput.value = '';
            if (clearSearchBtn) {
                clearSearchBtn.classList.add('hidden');
            }
            submissionRows.forEach(row => {
                row.classList.remove('hidden');
            });
            if (noResultsRow) {
                noResultsRow.classList.add('hidden');
            }
            if (emptyState && submissionRows.length === 0) {
                emptyState.classList.remove('hidden');
            }
            pageSearchInput.focus();
        }

        // Event listeners
        if (pageSearchInput) {
            pageSearchInput.addEventListener('input', performSearch);
            pageSearchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Escape') {
                    clearSearch();
                }
            });
        }
        
        if (searchField) {
            searchField.addEventListener('change', function() {
                updatePlaceholder();
                performSearch(); // Re-run search with new field
            });
        }
        
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', clearSearch);
        }
        
        // Initialize placeholder
        updatePlaceholder();

        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    })();
</script>
@endsection
