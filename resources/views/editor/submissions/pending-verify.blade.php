@extends('layout.app_editor')

@section('title', __('Pending Verify'))
@section('page-title', __('Pending Verify'))
@section('page-description', __('Review files uploaded by authors for verification'))

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
    <span class="text-sm font-medium text-gray-500">{{ __('Pending Verify') }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center space-x-3">
                <h1 class="text-2xl font-bold text-gray-900">{{ __('Pending Verify') }}</h1>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                    {{ __('Pending Verification Files') }}
                </span>
            </div>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Review files uploaded by authors for verification') }}
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

            <!-- Pending Verification Files List -->
    @if($submissions->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">{{ __('Pending Verification Files') }} ({{ $submissions->total() }})</h2>
        </div>
        <div class="divide-y divide-gray-200">
            @foreach($submissions as $submission)
            <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="file-check" class="w-6 h-6 text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900">{{ $submission->article->title ?? 'Untitled Article' }}</h3>
                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <i data-lucide="book" class="w-4 h-4 mr-1"></i>
                                        {{ $submission->article->journal->name ?? 'Unknown Journal' }}
                                    </span>
                                    <span class="flex items-center">
                                        <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                        {{ $submission->updated_at->format('M d, Y H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- File Information -->
                        <div class="ml-15 mt-4 p-4 bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <i data-lucide="file-text" class="w-5 h-5 text-purple-600"></i>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ basename($submission->approval_pending_file) }}</p>
                                        <p class="text-xs text-gray-500">Uploaded for verification</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $submission->approval_pending_file) }}" target="_blank" 
                                   class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                    {{ __('Download File') }}
                                </a>
                            </div>
                        </div>

                        <!-- Approval Actions -->
                        <div class="ml-15 mt-4 flex items-center space-x-3">
                            <form action="{{ route('editor.submissions.approve-article', $submission) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                    onclick="return confirm('{{ __('Are you sure you want to verify this article? This will change the status to verified.') }}')"
                                    class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-sm">
                                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                                    {{ __('Verify Article') }}
                                </button>
                            </form>
                            <form action="{{ route('editor.submissions.reject-approval', $submission) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                    onclick="return confirm('{{ __('Are you sure you want to reject this verification request? The author will be notified.') }}')"
                                    class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200 shadow-sm">
                                    <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>
                                    {{ __('Reject / Request Changes') }}
                                </button>
                            </form>
                            <a href="{{ route('editor.submissions.show', $submission) }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                                <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                {{ __('View Details') }}
                            </a>
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
        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="file-check" class="w-8 h-8 text-purple-600"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('No Pending Verification Files') }}</h3>
        <p class="text-sm text-gray-600">{{ __('There are no files waiting for verification at the moment.') }}</p>
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

