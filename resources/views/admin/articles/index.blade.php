@extends('layout.app_admin')

@section('title', 'Articles Management')
@section('page-title', 'Articles')
@section('page-description', 'Manage all articles in the system')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Articles</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Articles Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage all articles across your journals</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <!-- Filter Dropdown -->
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>All Status</option>
                    <option>Published</option>
                    <option>Under Review</option>
                    <option>Submitted</option>
                    <option>Rejected</option>
                </select>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
            </div>
            <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white text-sm font-medium rounded-lg hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Add New Article
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

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($articles as $article)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
            <!-- Article Header -->
            <div class="p-6 pb-4">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-purple-600 transition-colors duration-200">
                            {{ $article->title }}
                        </h3>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            <span class="truncate">{{ $article->journal->name ?? 'Unknown Journal' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 
                               ($article->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                               ($article->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                               ($article->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                            {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Author Info -->
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-xs font-bold text-white">{{ substr($article->author->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $article->author->name ?? 'Unknown Author' }}</p>
                        <p class="text-xs text-gray-500">{{ $article->author->affiliation ?? 'No affiliation' }}</p>
                    </div>
                </div>

                <!-- Category -->
                <div class="flex items-center space-x-2">
                    <i data-lucide="tag" class="w-4 h-4 text-gray-400"></i>
                    <span class="text-sm text-gray-600">{{ $article->category->name ?? 'Uncategorized' }}</span>
                </div>
            </div>

            <!-- Article Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <div class="flex items-center space-x-1">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>{{ $article->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            <span>{{ rand(10, 999) }} views</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.articles.show', $article) }}" 
                           class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('admin.articles.edit', $article) }}" 
                           class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?')">
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
                <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="file-text" class="w-8 h-8 text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No articles found</h3>
                <p class="text-gray-500 mb-6">Get started by creating your first article.</p>
                <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white text-sm font-medium rounded-lg hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Add New Article
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
    <div class="flex items-center justify-center">
        {{ $articles->links() }}
    </div>
    @endif
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
