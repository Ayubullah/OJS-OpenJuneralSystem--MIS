@extends('layout.app_admin')

@section('title', 'Reviewers Management')
@section('page-title', 'Reviewers')
@section('page-description', 'Manage all reviewers in the system')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Reviewers</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reviewers Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage peer reviewers for article submissions</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <a href="{{ route('review-articles.submit') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                View Assignments
            </a>
            <a href="{{ route('admin.reviewers.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-105">
                <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                Add New Reviewer
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-3"></i>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               placeholder="Search by name, email, expertise, or specialization..." 
                               class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                    </div>
                </div>

                <!-- Journal Filter -->
                <div>
                    <label for="journal_id" class="block text-sm font-medium text-gray-700 mb-2">Journal</label>
                    <select id="journal_id" 
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="all">All Journals</option>
                        @foreach($journals as $journal)
                        <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status" 
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3">
                <button type="button" onclick="clearFilters()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                    <i data-lucide="x" class="w-4 h-4 inline mr-1"></i>
                    Clear
                </button>
            </div>
        </div>
    </div>

    <!-- Reviewers Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Journal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expertise</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviews</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reviewers as $reviewer)
                    <tr class="reviewer-row hover:bg-gray-50 transition-colors duration-200"
                        data-name="{{ strtolower($reviewer->user->name ?? '') }}"
                        data-email="{{ strtolower($reviewer->email ?? '') }}"
                        data-expertise="{{ strtolower($reviewer->expertise ?? '') }}"
                        data-specialization="{{ strtolower($reviewer->specialization ?? '') }}"
                        data-journal-id="{{ $reviewer->journal_id ?? '' }}"
                        data-journal-name="{{ strtolower($reviewer->journal->name ?? '') }}"
                        data-status="{{ $reviewer->status ?? '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-white font-semibold text-sm">{{ strtoupper(substr($reviewer->user->name ?? 'R', 0, 2)) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $reviewer->user->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $reviewer->specialization ?? 'General' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $reviewer->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <i data-lucide="book" class="w-4 h-4 text-gray-400"></i>
                                <span class="text-sm text-gray-900">{{ $reviewer->journal->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $reviewer->expertise ?? 'Not specified' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $reviewer->reviews_count }} reviews
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $reviewer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($reviewer->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.reviewers.articles.show', $reviewer) }}" class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50 transition-colors duration-200" title="View Assigned Articles">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.reviewers.show', $reviewer) }}" class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors duration-200" title="View Details">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.reviewers.edit', $reviewer) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors duration-200" title="Edit Reviewer">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.reviewers.destroy', $reviewer) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this reviewer?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition-colors duration-200" title="Delete Reviewer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-state">
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="user-check" class="w-12 h-12 text-gray-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No reviewers found</h3>
                                <p class="text-gray-500 mb-4">Get started by adding your first reviewer.</p>
                                <a href="{{ route('admin.reviewers.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                                    Add New Reviewer
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    <!-- No Results Row (Hidden by default) -->
                    <tr id="noResults" style="display: none;">
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="search-x" class="w-12 h-12 text-gray-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No results found</h3>
                                <p class="text-gray-500 mb-4">Try adjusting your search or filter criteria.</p>
                                <button onclick="clearFilters()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
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
        @if($reviewers->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $reviewers->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Filter functionality
    function filterReviewers() {
        const searchInput = document.getElementById('search');
        const journalSelect = document.getElementById('journal_id');
        const statusSelect = document.getElementById('status');
        
        if (!searchInput || !journalSelect || !statusSelect) {
            console.error('Filter elements not found');
            return;
        }
        
        const searchTerm = searchInput.value.toLowerCase().trim();
        const journalFilter = journalSelect.value;
        const statusFilter = statusSelect.value;
        const reviewerRows = document.querySelectorAll('.reviewer-row');
        const noResults = document.getElementById('noResults');
        const emptyState = document.querySelector('.empty-state');
        let visibleCount = 0;

        reviewerRows.forEach(row => {
            const name = (row.getAttribute('data-name') || '').toLowerCase();
            const email = (row.getAttribute('data-email') || '').toLowerCase();
            const expertise = (row.getAttribute('data-expertise') || '').toLowerCase();
            const specialization = (row.getAttribute('data-specialization') || '').toLowerCase();
            const journalId = String(row.getAttribute('data-journal-id') || '');
            const status = (row.getAttribute('data-status') || '').toLowerCase();
            
            // Search matching
            const matchesSearch = !searchTerm || 
                name.includes(searchTerm) || 
                email.includes(searchTerm) || 
                expertise.includes(searchTerm) || 
                specialization.includes(searchTerm);
            
            // Journal filter matching
            const matchesJournal = journalFilter === 'all' || journalId === String(journalFilter);
            
            // Status filter matching
            const matchesStatus = statusFilter === 'all' || status === statusFilter.toLowerCase();

            if (matchesSearch && matchesJournal && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0 && reviewerRows.length > 0) {
            if (noResults) noResults.style.display = '';
            if (emptyState) emptyState.style.display = 'none';
        } else {
            if (noResults) noResults.style.display = 'none';
            if (emptyState && reviewerRows.length === 0) emptyState.style.display = '';
        }
    }

    function clearFilters() {
        document.getElementById('search').value = '';
        document.getElementById('journal_id').value = 'all';
        document.getElementById('status').value = 'all';
        filterReviewers();
    }

    // Add event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const journalSelect = document.getElementById('journal_id');
        const statusSelect = document.getElementById('status');

        if (searchInput) {
            searchInput.addEventListener('input', filterReviewers);
            searchInput.addEventListener('keyup', filterReviewers);
        }
        if (journalSelect) {
            journalSelect.addEventListener('change', filterReviewers);
        }
        if (statusSelect) {
            statusSelect.addEventListener('change', filterReviewers);
        }
        
        // Initial filter call to ensure everything is visible
        filterReviewers();
    });
</script>
@endsection

