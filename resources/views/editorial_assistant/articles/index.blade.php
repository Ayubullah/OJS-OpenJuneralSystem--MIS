@extends('layout.app_editorial_assistant')

@section('title', __('Accepted Articles'))
@section('page-title', __('Accepted Articles'))
@section('page-description', __('View all accepted articles'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <a href="{{ route('editorial_assistant.dashboard') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Dashboard') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ __('Accepted Articles') }}</span>
</li>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-teal-50 to-cyan-50 px-6 py-4 rounded-t-lg border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ __('Accepted Articles (:count)', ['count' => $articles->total()]) }}</h1>
                <p class="text-sm text-gray-600 mt-1">{{ __('All articles that have been accepted for publication') }}</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white border-b border-gray-200 px-6 py-4">
        <form method="GET" action="{{ route('editorial_assistant.articles.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Search') }}</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="{{ __('Search by title, author, or journal...') }}" 
                               class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                    </div>
                </div>

                <!-- Journal Filter -->
                <div>
                    <label for="journal_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Journal') }}</label>
                    <select id="journal_id" 
                            name="journal_id"
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="">{{ __('All Journals') }}</option>
                        @foreach($journals as $journal)
                        <option value="{{ $journal->id }}" {{ request('journal_id') == $journal->id ? 'selected' : '' }}>{{ $journal->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Category') }}</label>
                    <select id="category_id" 
                            name="category_id"
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="">{{ __('All Categories') }}</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('editorial_assistant.articles.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                    <i data-lucide="x" class="w-4 h-4 inline mr-1"></i>
                    {{ __('Clear') }}
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-gradient-to-r from-teal-600 to-cyan-600 text-white text-sm font-medium rounded-lg hover:from-teal-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                    <i data-lucide="search" class="w-4 h-4 inline mr-1"></i>
                    {{ __('Search') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Articles Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Title') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Author') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Journal') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Category') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Accepted Date') }}</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($articles as $article)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($article->title, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $article->author->name ?? __('N/A') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $article->journal->name ?? __('N/A') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $article->category->name ?? __('N/A') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $article->updated_at->format('M d, Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('editorial_assistant.articles.show', $article) }}" 
                           class="text-teal-600 hover:text-teal-900 inline-flex items-center">
                            <i data-lucide="eye" class="w-4 h-4 mr-1"></i>
                            {{ __('View') }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i data-lucide="file-x" class="w-12 h-12 text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No accepted articles found') }}</h3>
                            <p class="text-sm text-gray-500">{{ __('Try adjusting your search filters') }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
    <div class="bg-white px-6 py-4 border-t border-gray-200">
        {{ $articles->links() }}
    </div>
    @endif
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endsection

