@extends('layout.app_author')

@section('title', __('My Articles'))
@section('page-title', __('My Articles'))
@section('page-description', __('Manage and track your submitted articles'))

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('My Articles') }}</h1>
                    <p class="mt-2 text-gray-600">{{ __('Manage and track your submitted articles') }}</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('author.articles.create') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        {{ __('Submit New Article') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Articles List -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            @if($articles->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('Title') }}</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('Journal') }}</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('Category') }}</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('Submitted Date') }}</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($articles as $article)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($article->title, 60) }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $article->manuscript_type }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700">{{ $article->journal->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700">{{ $article->category->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'submitted' => 'bg-blue-100 text-blue-800',
                                        'under_review' => 'bg-yellow-100 text-yellow-800',
                                        'revision_required' => 'bg-orange-100 text-orange-800',
                                        'accepted' => 'bg-green-100 text-green-800',
                                        'published' => 'bg-purple-100 text-purple-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusColor = $statusColors[$article->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                    {{ __(ucfirst(str_replace('_', ' ', $article->status))) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $article->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('author.articles.show', $article) }}" 
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors duration-150"
                                        title="{{ __('View Details') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    @if(in_array($article->status, ['submitted', 'under_review', 'revision_required']) && $article->status !== 'rejected')

                                    <a href="{{ route('author.articles.resubmit', $article) }}" 
                                        class="inline-flex items-center px-3 py-1.5 bg-orange-50 text-orange-700 rounded-lg hover:bg-orange-100 transition-colors duration-150"
                                        title="{{ __('Resubmit Article') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $articles->links() }}
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">{{ __('No Articles Yet') }}</h3>
                <p class="mt-2 text-sm text-gray-500">{{ __('Get started by submitting your first article.') }}</p>
                <div class="mt-6">
                    <a href="{{ route('author.articles.create') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        {{ __('Submit Your First Article') }}
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

