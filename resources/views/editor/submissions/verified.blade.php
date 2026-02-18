@extends('layout.app_editor')

@section('title', __('Verified Articles'))
@section('page-title', __('Verified Articles'))
@section('page-description', __('View all articles that have been verified through the verification workflow'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('editor.submissions.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Submissions') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ __('Verified') }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center space-x-3">
                <h1 class="text-2xl font-bold text-gray-900">{{ __('Verified Articles') }}</h1>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    {{ __('Verified Through Workflow') }}
                </span>
            </div>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('View all articles that have been verified through the verification workflow') }}
            </p>
        </div>
    </div>

    <!-- Success/Error Messages -->
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

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
            </div>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

            <!-- Verified Articles List -->
    @if($submissions->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">{{ __('Verified Articles') }} ({{ $submissions->total() }})</h2>
        </div>
        <div class="divide-y divide-gray-200">
            @foreach($submissions as $submission)
            <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="check-circle-2" class="w-6 h-6 text-white"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $submission->article->title ?? 'Untitled Article' }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                                        {{ __('Verified') }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <i data-lucide="book" class="w-4 h-4 mr-1"></i>
                                        {{ $submission->article->journal->name ?? 'Unknown Journal' }}
                                    </span>
                                    <span class="flex items-center">
                                        <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                        {{ __('Verified on') }} {{ $submission->updated_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Verified File Information -->
                        <div class="ml-15 mt-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <i data-lucide="file-check" class="w-5 h-5 text-green-600"></i>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ basename($submission->approval_pending_file) }}</p>
                                        <p class="text-xs text-gray-500">{{ __('Verified file') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ asset('storage/' . $submission->approval_pending_file) }}" target="_blank" 
                                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                        {{ __('Download Verified File') }}
                                    </a>
                                    @if($submission->file_path)
                                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                        {{ __('Original File') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Article Status -->
                        <div class="ml-15 mt-4 flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600">{{ __('Article Status:') }}</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    {{ $submission->article->status === 'verified' ? 'bg-emerald-100 text-emerald-800' :
                                       ($submission->article->status === 'accepted' ? 'bg-emerald-100 text-emerald-800' : 
                                       ($submission->article->status === 'published' ? 'bg-purple-100 text-purple-800' : 
                                       'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $submission->article->status)) }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600">{{ __('Version:') }}</span>
                                <span class="text-sm font-semibold text-gray-900">v{{ $submission->version_number }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="ml-15 mt-4 flex items-center space-x-3">
                            <a href="{{ route('editor.submissions.show', $submission) }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                                <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                {{ __('View Details') }}
                            </a>
                            @if($submission->article->status !== 'published')
                            <a href="{{ route('editor.submissions.edit', $submission) }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors duration-200 shadow-sm">
                                <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                                {{ __('Edit') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $submissions->links() }}
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="check-circle-2" class="w-8 h-8 text-green-600"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('No Verified Articles') }}</h3>
        <p class="text-sm text-gray-600">{{ __('There are no articles that have been verified through the verification workflow yet.') }}</p>
    </div>
    @endif
</div>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endsection

