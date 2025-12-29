@extends('layout.app_admin')

@section('title', 'Authors Management')
@section('page-title', 'Authors')
@section('page-description', 'Manage all authors in the system')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Authors</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Authors Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage all research authors and contributors</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.authors.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                Add New Author
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               placeholder="Search by name, email, affiliation, specialization, or ORCID..." 
                               class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                    </div>
                </div>

                <!-- Sort by Articles Count -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select id="sort" 
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="name">Name (A-Z)</option>
                        <option value="name_desc">Name (Z-A)</option>
                        <option value="articles_desc">Most Articles</option>
                        <option value="articles_asc">Least Articles</option>
                        <option value="latest">Latest First</option>
                        <option value="oldest">Oldest First</option>
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

    <!-- Authors Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Affiliation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ORCID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Articles</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($authors as $author)
                    <tr class="author-row hover:bg-gray-50 transition-colors duration-200"
                        data-name="{{ strtolower($author->name ?? '') }}"
                        data-email="{{ strtolower($author->email ?? '') }}"
                        data-affiliation="{{ strtolower($author->affiliation ?? '') }}"
                        data-specialization="{{ strtolower($author->specialization ?? '') }}"
                        data-orcid="{{ strtolower($author->orcid_id ?? '') }}"
                        data-articles-count="{{ $author->articles_count ?? 0 }}"
                        data-created="{{ $author->created_at->timestamp ?? 0 }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-white font-semibold text-sm">{{ strtoupper(substr($author->name, 0, 2)) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $author->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $author->specialization ?? 'Not specified' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $author->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ $author->affiliation ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-mono">{{ $author->orcid_id ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $author->articles_count }} articles
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.authors.show', $author) }}" class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors duration-200">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.authors.edit', $author) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors duration-200">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this author?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition-colors duration-200">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-state">
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="users" class="w-12 h-12 text-gray-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No authors found</h3>
                                <p class="text-gray-500 mb-4">Get started by adding your first author.</p>
                                <a href="{{ route('admin.authors.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                                    Add New Author
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    <!-- No Results Row (Hidden by default) -->
                    <tr id="noResults" style="display: none;">
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="search-x" class="w-12 h-12 text-gray-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No results found</h3>
                                <p class="text-gray-500 mb-4">Try adjusting your search criteria.</p>
                                <button onclick="clearFilters()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
        @if($authors->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $authors->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Filter and sort functionality
    function filterAuthors() {
        const searchTerm = document.getElementById('search').value.toLowerCase().trim();
        const sortBy = document.getElementById('sort').value;
        const authorRows = Array.from(document.querySelectorAll('.author-row'));
        const noResults = document.getElementById('noResults');
        const emptyState = document.querySelector('.empty-state');
        let visibleRows = [];

        // Filter rows
        authorRows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const email = row.getAttribute('data-email') || '';
            const affiliation = row.getAttribute('data-affiliation') || '';
            const specialization = row.getAttribute('data-specialization') || '';
            const orcid = row.getAttribute('data-orcid') || '';
            
            const matchesSearch = !searchTerm || 
                name.includes(searchTerm) || 
                email.includes(searchTerm) || 
                affiliation.includes(searchTerm) || 
                specialization.includes(searchTerm) || 
                orcid.includes(searchTerm);

            if (matchesSearch) {
                row.style.display = '';
                visibleRows.push(row);
            } else {
                row.style.display = 'none';
            }
        });

        // Sort visible rows
        if (visibleRows.length > 0) {
            visibleRows.sort((a, b) => {
                switch(sortBy) {
                    case 'name':
                        return (a.getAttribute('data-name') || '').localeCompare(b.getAttribute('data-name') || '');
                    case 'name_desc':
                        return (b.getAttribute('data-name') || '').localeCompare(a.getAttribute('data-name') || '');
                    case 'articles_desc':
                        return parseInt(b.getAttribute('data-articles-count') || 0) - parseInt(a.getAttribute('data-articles-count') || 0);
                    case 'articles_asc':
                        return parseInt(a.getAttribute('data-articles-count') || 0) - parseInt(b.getAttribute('data-articles-count') || 0);
                    case 'latest':
                        return parseInt(b.getAttribute('data-created') || 0) - parseInt(a.getAttribute('data-created') || 0);
                    case 'oldest':
                        return parseInt(a.getAttribute('data-created') || 0) - parseInt(b.getAttribute('data-created') || 0);
                    default:
                        return 0;
                }
            });

            // Reorder rows in DOM
            const tbody = document.querySelector('tbody');
            visibleRows.forEach(row => {
                tbody.appendChild(row);
            });
        }

        // Show/hide no results message
        if (visibleRows.length === 0 && authorRows.length > 0) {
            if (noResults) noResults.style.display = '';
            if (emptyState) emptyState.style.display = 'none';
        } else {
            if (noResults) noResults.style.display = 'none';
            if (emptyState && authorRows.length === 0) emptyState.style.display = '';
        }
    }

    function clearFilters() {
        document.getElementById('search').value = '';
        document.getElementById('sort').value = 'name';
        filterAuthors();
    }

    // Add event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const sortSelect = document.getElementById('sort');

        if (searchInput) {
            searchInput.addEventListener('input', filterAuthors);
        }
        if (sortSelect) {
            sortSelect.addEventListener('change', filterAuthors);
        }
    });
</script>
@endsection

