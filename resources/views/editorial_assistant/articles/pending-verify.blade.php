@extends('layout.app_editorial_assistant')

@section('title', __('Pending Verify'))
@section('page-title', __('Pending Verify'))
@section('page-description', __('Review files uploaded by authors for verification'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <a href="{{ route('editorial_assistant.dashboard') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Dashboard') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('editorial_assistant.articles.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Accepted Articles') }}</a>
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
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-teal-100 text-teal-800">
                    {{ __('Pending Verification Files') }}
                </span>
            </div>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Review files uploaded by authors for verification. Verify to accept or reject with a comment so the author can upload a new file.') }}
            </p>
        </div>
    </div>

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

    @if($items && count($items) > 0)
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-cyan-50 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">{{ __('Not Verified Articles') }} ({{ $articles->total() }})</h2>
            <p class="text-sm text-gray-600 mt-1">{{ __('Articles with status pending verification. Some may be waiting for the author to upload a file.') }}</p>
        </div>
        <div class="divide-y divide-gray-200">
            @foreach($items as $item)
            @php $article = $item->article; $submission = $item->submission; $hasFile = $item->has_file_to_verify; @endphp
            <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="{{ $hasFile ? 'file-check' : 'clock' }}" class="w-6 h-6 text-white"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $article->title ?? 'Untitled Article' }}</h3>
                                    @if($hasFile)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-teal-100 text-teal-800">
                                        {{ __('File ready for verification') }}
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                        {{ __('Waiting for author upload') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <i data-lucide="book" class="w-4 h-4 mr-1"></i>
                                        {{ $article->journal->name ?? 'Unknown Journal' }}
                                    </span>
                                    <span class="flex items-center">
                                        <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                        {{ $article->updated_at->format('M d, Y H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($hasFile && $submission && $submission->approval_pending_file)
                        <div class="ml-15 mt-4 p-4 bg-gradient-to-r from-teal-50 to-cyan-50 border border-teal-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <i data-lucide="file-text" class="w-5 h-5 text-teal-600"></i>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ basename($submission->approval_pending_file) }}</p>
                                        <p class="text-xs text-gray-500">{{ __('Uploaded for verification') }}</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $submission->approval_pending_file) }}" target="_blank" 
                                   class="inline-flex items-center px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 transition-colors duration-200">
                                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                    {{ __('Download File') }}
                                </a>
                            </div>
                        </div>
                        @endif

                        <!-- Message Record -->
                        @if(isset($messageCounts) && ($msgCount = $messageCounts[$article->id] ?? 0) > 0)
                        <div class="ml-15 mt-3 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 flex items-center">
                                    <i data-lucide="message-square" class="w-4 h-4 mr-1.5 text-teal-600"></i>
                                    {{ $msgCount }} {{ $msgCount == 1 ? __('message') : __('messages') }} {{ __('between author and editorial assistant') }}
                                </span>
                                <a href="{{ route('editorial_assistant.articles.show', $article) }}#messages" 
                                   class="text-sm font-medium text-teal-600 hover:text-teal-700">
                                    {{ __('View all messages') }}
                                </a>
                            </div>
                        </div>
                        @endif

                        <div class="ml-15 mt-4 flex items-center space-x-3">
                            @if($hasFile)
                            <form action="{{ route('editorial_assistant.articles.approve-verification', $article) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                    onclick="return confirm('{{ __('Are you sure you want to verify this article? This will change the status to verified.') }}')"
                                    class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-sm">
                                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                                    {{ __('Verify Article') }}
                                </button>
                            </form>
                            <button type="button" onclick="openRejectModal({{ $article->id }}, '{{ addslashes($article->title) }}')"
                                class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200 shadow-sm">
                                <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>
                                {{ __('Reject with Comment') }}
                            </button>
                            @endif
                            <a href="{{ route('editorial_assistant.articles.show', $article) }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                {{ __('View Details') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $articles->links() }}
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
        <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="file-check" class="w-8 h-8 text-teal-600"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('No Pending Verification Articles') }}</h3>
        <p class="text-sm text-gray-600">{{ __('There are no articles with pending verification status at the moment.') }}</p>
    </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">{{ __('Reject Verification') }}</h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <p class="text-sm text-gray-600 mb-4">{{ __('Please provide a comment explaining why the verification is rejected. The author will see this and can upload a new file.') }}</p>
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label for="rejection_comment" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Rejection Comment') }} *</label>
                    <textarea id="rejection_comment" name="rejection_comment" rows="5" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                              placeholder="{{ __('Explain what needs to be corrected...') }}"></textarea>
                </div>
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                        <i data-lucide="x-circle" class="w-4 h-4 inline mr-2"></i>
                        {{ __('Reject Verification') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRejectModal(articleId, articleTitle) {
        document.getElementById('rejectForm').action = '{{ url("editorial-assistant/articles") }}/' + articleId + '/reject-verification';
        document.getElementById('rejectModal').classList.remove('hidden');
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
@endsection
