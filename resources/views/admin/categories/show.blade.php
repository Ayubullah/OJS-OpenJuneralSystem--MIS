@extends('layout.app_admin')

@section('title', 'Category Details')
@section('page-title', 'Category Details')
@section('page-description', 'View category information and articles')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Categories</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-900">{{ $category->name }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Category Info Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center mr-4">
                        <i data-lucide="folder" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $category->name }}</h2>
                        <p class="text-sm text-gray-600">Category Information</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
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
                    <dt class="text-sm font-medium text-gray-500">Category Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $category->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Articles</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                            {{ $category->articles->count() }} articles
                        </span>
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $category->description ?? 'No description provided' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('F d, Y h:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $category->updated_at->format('F d, Y h:i A') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Articles in Category -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Articles in this Category</h3>
        </div>

        <div class="overflow-x-auto">
            @if($category->articles->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Journal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($category->articles as $article)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($article->title, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $article->author->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $article->journal->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($article->status === 'published') bg-green-100 text-green-800
                                @elseif($article->status === 'under_review') bg-yellow-100 text-yellow-800
                                @elseif($article->status === 'accepted') bg-blue-100 text-blue-800
                                @elseif($article->status === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $article->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="px-6 py-12 text-center">
                <i data-lucide="file-text" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No articles yet</h3>
                <p class="text-gray-500">There are no articles in this category.</p>
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

