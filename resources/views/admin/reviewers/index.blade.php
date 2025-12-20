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

    <!-- Reviewers Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">All Reviewers</h3>
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <input type="text" placeholder="Search reviewers..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expertise</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviews</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reviewers as $reviewer)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
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
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
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
    lucide.createIcons();
</script>
@endsection

