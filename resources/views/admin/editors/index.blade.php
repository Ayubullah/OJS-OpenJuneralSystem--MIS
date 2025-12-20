@extends('layout.app_admin')

@section('title', 'Editors Management')
@section('page-title', 'Editors')
@section('page-description', 'Manage all editors')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Editors</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Editors Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage all editors in the system</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <!-- Search Input -->
            <div class="relative">
                <input type="text" 
                       id="searchInput"
                       placeholder="Search editors..." 
                       class="pl-10 pr-4 py-2 w-64 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
            </div>
            
            <a href="{{ route('admin.editors.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Add New Editor
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

    <!-- Editors Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Joined Date
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="editorsTableBody" class="bg-white divide-y divide-gray-200">
                    @forelse($editors as $editor)
                    <tr class="editor-row hover:bg-gray-50 transition-colors duration-200" 
                        data-name="{{ strtolower($editor->name ?? '') }}"
                        data-email="{{ strtolower($editor->email ?? '') }}"
                        data-username="{{ strtolower($editor->username ?? '') }}">
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                #{{ $editor->id }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center">
                                    <span class="text-sm font-bold text-white">{{ substr($editor->name ?? 'E', 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $editor->name ?? 'Unknown' }}</div>
                                    <div class="text-xs text-gray-500">@{{ $editor->username ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                                <span class="text-sm text-gray-700">{{ $editor->email ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-700">Editor</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                                <span class="text-sm text-gray-700">{{ $editor->created_at->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ $editor->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($editor->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.editors.show', $editor) }}" 
                                   class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                   title="View">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.editors.edit', $editor) }}" 
                                   class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200"
                                   title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.editors.destroy', $editor) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this editor?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                            title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-state">
                        <td colspan="7" class="px-6 py-12">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                    <i data-lucide="users" class="w-8 h-8 text-indigo-600"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">No editors found</h3>
                                <p class="text-gray-500 mb-6">Get started by creating your first editor.</p>
                                <a href="{{ route('admin.editors.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                    Add New Editor
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    <!-- No Search Results Row (Hidden by default) -->
                    <tr id="noResults" class="hidden">
                        <td colspan="7" class="px-6 py-12">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                    <i data-lucide="search-x" class="w-8 h-8 text-gray-400"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">No results found</h3>
                                <p class="text-gray-500">Try adjusting your search to find what you're looking for.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($editors->hasPages())
    <div class="flex items-center justify-center">
        {{ $editors->links() }}
    </div>
    @endif
</div>

<script>
    // Wrap in IIFE to avoid variable conflicts with layout script
    (function() {
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Search functionality
        const pageSearchInput = document.getElementById('searchInput');
        const editorRows = document.querySelectorAll('.editor-row');
        const noResultsRow = document.getElementById('noResults');
        const emptyState = document.querySelector('.empty-state');

        if (pageSearchInput) {
            pageSearchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                if (emptyState) {
                    emptyState.classList.add('hidden');
                }

                editorRows.forEach(row => {
                    const name = row.getAttribute('data-name');
                    const email = row.getAttribute('data-email');
                    const username = row.getAttribute('data-username');
                    const searchContent = name + ' ' + email + ' ' + username;

                    if (searchContent.includes(searchTerm)) {
                        row.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        row.classList.add('hidden');
                    }
                });

                if (noResultsRow) {
                    if (searchTerm && visibleCount === 0) {
                        noResultsRow.classList.remove('hidden');
                    } else {
                        noResultsRow.classList.add('hidden');
                    }
                }

                if (!searchTerm && emptyState && editorRows.length === 0) {
                    emptyState.classList.remove('hidden');
                }

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        }
    })();
</script>
@endsection

