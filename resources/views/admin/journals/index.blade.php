@extends('layout.app_admin')

@section('title', 'Journals Management')
@section('page-title', 'Journals')
@section('page-description', 'Manage all journals in the system')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Journals</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Journals Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage all journals in your Kardan Journal Operating System</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.journals.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Add New Journal
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

    <!-- Journals Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">All Journals</h3>
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <input type="text" placeholder="Search journals..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Journal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISSN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Articles</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($journals as $journal)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center mr-4">
                                    <i data-lucide="book" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $journal->name }}</div>
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($journal->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900 font-mono">{{ $journal->issn }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $journal->articles_count }} articles
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $journal->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($journal->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $journal->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.journals.show', $journal) }}" class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors duration-200">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.journals.edit', $journal) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors duration-200">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.journals.destroy', $journal) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this journal?')">
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
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="book" class="w-12 h-12 text-gray-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No journals found</h3>
                                <p class="text-gray-500 mb-4">Get started by creating your first journal.</p>
                                <a href="{{ route('admin.journals.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                    Add New Journal
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($journals->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $journals->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
