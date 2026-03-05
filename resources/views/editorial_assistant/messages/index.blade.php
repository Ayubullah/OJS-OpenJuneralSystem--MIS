@extends('layout.app_editorial_assistant')

@section('title', __('Messages'))
@section('page-title', __('Messages'))
@section('page-description', __('Manage messages sent to authors'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <a href="{{ route('editorial_assistant.dashboard') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Dashboard') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ __('Messages') }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
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

    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-teal-50 to-cyan-50">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('Messages') }}</h1>
                    <p class="mt-2 text-sm text-gray-600">{{ __('Manage reminders and messages sent to authors') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px overflow-x-auto">
                <button onclick="showTab('articles')" id="articlesTab" class="tab-button active px-6 py-4 text-sm font-medium text-teal-600 border-b-2 border-teal-600 whitespace-nowrap">
                    <i data-lucide="file-text" class="w-4 h-4 inline mr-2"></i>
                    {{ __('Articles') }}
                </button>
                <button onclick="showTab('authorMessages')" id="authorMessagesTab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                    {{ __('Author Messages') }}
                    @if($authorMessages->count() > 0)
                    <span class="ml-2 px-2 py-0.5 bg-teal-500 text-white text-xs font-bold rounded-full">{{ $authorMessages->count() }}</span>
                    @endif
                </button>
                <button onclick="showTab('editorMessages')" id="editorMessagesTab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    <i data-lucide="user-check" class="w-4 h-4 inline mr-2"></i>
                    {{ __('Editor Messages') }}
                    @if($editorMessages->count() > 0)
                    <span class="ml-2 px-2 py-0.5 bg-green-500 text-white text-xs font-bold rounded-full">{{ $editorMessages->count() }}</span>
                    @endif
                </button>
                <button onclick="showTab('adminMessages')" id="adminMessagesTab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    <i data-lucide="shield" class="w-4 h-4 inline mr-2"></i>
                    {{ __('Admin Messages') }}
                    @if($adminMessages->count() > 0)
                    <span class="ml-2 px-2 py-0.5 bg-indigo-500 text-white text-xs font-bold rounded-full">{{ $adminMessages->count() }}</span>
                    @endif
                </button>
            </nav>
        </div>

        <!-- Articles Tab -->
        <div id="articlesTabContent" class="tab-content p-6">
            <div class="mb-4">
                <p class="text-sm text-gray-600">{{ __('Select an article to send a message or verification request to the author.') }}</p>
            </div>

            @if($articles->count() > 0)
            <div class="space-y-4">
                @foreach($articles as $article)
                <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-teal-100 text-teal-800">
                                    {{ __('Article ID') }}: {{ $article->id }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-900">{{ $article->title }}</h3>
                            </div>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-3">
                                <div class="flex items-center space-x-1">
                                    <i data-lucide="book" class="w-4 h-4"></i>
                                    <span>{{ $article->journal->name ?? __('N/A') }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i data-lucide="tag" class="w-4 h-4"></i>
                                    <span>{{ $article->category->name ?? __('N/A') }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                    <span>{{ $article->author->name ?? __('N/A') }}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 
                                       ($article->status === 'pending_verify' ? 'bg-purple-100 text-purple-800' : 
                                       ($article->status === 'verified' ? 'bg-emerald-100 text-emerald-800' : 
                                       ($article->status === 'accepted' ? 'bg-emerald-100 text-emerald-800' : 
                                       ($article->status === 'approved_chief_editor' ? 'bg-lime-100 text-lime-800' : 
                                       ($article->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('editorial_assistant.articles.show', $article) }}" 
                               class="inline-flex items-center px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 transition-colors duration-200">
                                <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                                {{ __('Send Message') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($articles->hasPages())
            <div class="mt-6">
                {{ $articles->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="file-text" class="w-8 h-8 text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium">{{ __('No articles found') }}</p>
                <p class="text-sm text-gray-400 mt-1">{{ __('Articles will appear here when they are accepted or pending verification') }}</p>
            </div>
            @endif
        </div>

        <!-- Author Messages Tab -->
        <div id="authorMessagesTabContent" class="tab-content p-6 hidden">
            @if($authorMessages->count() > 0)
            <div class="space-y-4">
                @foreach($authorMessages as $message)
                <div class="bg-white rounded-lg border border-gray-200 p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i data-lucide="user" class="w-5 h-5 text-teal-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $message->author->name ?? __('Author') }}</span>
                                    @if($message->article_id)
                                    <span class="text-xs text-gray-500">•</span>
                                    <a href="{{ route('editorial_assistant.articles.show', $message->article) }}" class="text-sm font-medium text-teal-600 hover:text-teal-700">
                                        {{ Str::limit($message->article->title ?? __('Untitled Article'), 50) }}
                                    </a>
                                    <span class="text-xs text-gray-500">({{ __('Article ID') }}: {{ $message->article_id }})</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ $message->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <div class="flex items-center gap-2 mb-2">
                                @if($message->is_approval_request)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ __('Verification Request') }}
                                </span>
                                @endif
                                @if($message->is_rejection ?? false)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                    {{ __('Rejection') }}
                                </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                            @if($message->article_id)
                            <a href="{{ route('editorial_assistant.articles.show', $message->article) }}" 
                               class="inline-flex items-center mt-3 text-sm font-medium text-teal-600 hover:text-teal-700">
                                <i data-lucide="external-link" class="w-4 h-4 mr-1"></i>
                                {{ __('View Article') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="user" class="w-8 h-8 text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium">{{ __('No messages sent to authors yet') }}</p>
                <p class="text-sm text-gray-400 mt-1">{{ __('Messages you send to authors will appear here. Send verification requests or messages from article pages.') }}</p>
            </div>
            @endif
        </div>

        <!-- Editor Messages Tab -->
        <div id="editorMessagesTabContent" class="tab-content p-6 hidden">
            @if($editorMessages->count() > 0)
            <div class="space-y-4">
                @foreach($editorMessages as $message)
                <div class="bg-white rounded-lg border border-gray-200 p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-blue-600">{{ substr($message->editor?->name ?? 'E', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $message->editor?->name ?? __('Editor') }}</span>
                                    <span class="px-1.5 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded">{{ __('Editor') }}</span>
                                    @if($message->article_id)
                                    <span class="text-xs text-gray-500">•</span>
                                    <a href="{{ route('editorial_assistant.articles.show', $message->article) }}" class="text-sm font-medium text-teal-600 hover:text-teal-700">
                                        {{ Str::limit($message->article->title ?? __('Untitled Article'), 50) }}
                                    </a>
                                    <span class="text-xs text-gray-500">({{ __('Article ID') }}: {{ $message->article_id }})</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ $message->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                            @if($message->article_id)
                            <a href="{{ route('editorial_assistant.articles.show', $message->article) }}" 
                               class="inline-flex items-center mt-3 text-sm font-medium text-teal-600 hover:text-teal-700">
                                <i data-lucide="external-link" class="w-4 h-4 mr-1"></i>
                                {{ __('View Article') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="user-check" class="w-8 h-8 text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium">{{ __('No editor messages yet') }}</p>
                <p class="text-sm text-gray-400 mt-1">{{ __('Messages from editors will appear here.') }}</p>
            </div>
            @endif
        </div>

        <!-- Admin Messages Tab -->
        <div id="adminMessagesTabContent" class="tab-content p-6 hidden">
            @if($adminMessages->count() > 0)
            <div class="space-y-4">
                @foreach($adminMessages as $message)
                <div class="bg-white rounded-lg border border-gray-200 p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-indigo-600">{{ substr($message->editor->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $message->editor->name ?? __('Admin') }}</span>
                                    <span class="px-1.5 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-bold rounded">{{ __('Admin') }}</span>
                                    @if($message->article_id)
                                    <span class="text-xs text-gray-500">•</span>
                                    <a href="{{ route('editorial_assistant.articles.show', $message->article) }}" class="text-sm font-medium text-teal-600 hover:text-teal-700">
                                        {{ Str::limit($message->article->title ?? __('Untitled Article'), 50) }}
                                    </a>
                                    <span class="text-xs text-gray-500">({{ __('Article ID') }}: {{ $message->article_id }})</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ $message->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                            @if($message->article_id)
                            <a href="{{ route('editorial_assistant.articles.show', $message->article) }}" 
                               class="inline-flex items-center mt-3 text-sm font-medium text-teal-600 hover:text-teal-700">
                                <i data-lucide="external-link" class="w-4 h-4 mr-1"></i>
                                {{ __('View Article') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="shield" class="w-8 h-8 text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium">{{ __('No admin messages yet') }}</p>
                <p class="text-sm text-gray-400 mt-1">{{ __('Messages from administrators will appear here.') }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    function showTab(tabName) {
        // Hide all tab contents
        ['articlesTabContent', 'authorMessagesTabContent', 'editorMessagesTabContent', 'adminMessagesTabContent'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        });
        
        // Remove active class from all tabs
        ['articlesTab', 'authorMessagesTab', 'editorMessagesTab', 'adminMessagesTab'].forEach(tabId => {
            const tab = document.getElementById(tabId);
            if (tab) {
                tab.classList.remove('active', 'text-teal-600', 'border-teal-600');
                tab.classList.add('text-gray-500', 'border-transparent');
            }
        });
        
        // Show selected tab content and activate tab
        const tabMap = {
            'articles': ['articlesTabContent', 'articlesTab'],
            'authorMessages': ['authorMessagesTabContent', 'authorMessagesTab'],
            'editorMessages': ['editorMessagesTabContent', 'editorMessagesTab'],
            'adminMessages': ['adminMessagesTabContent', 'adminMessagesTab']
        };
        const [contentId, tabId] = tabMap[tabName] || [];
        if (contentId && tabId) {
            const content = document.getElementById(contentId);
            const tab = document.getElementById(tabId);
            if (content) content.classList.remove('hidden');
            if (tab) {
                tab.classList.add('active', 'text-teal-600', 'border-teal-600');
                tab.classList.remove('text-gray-500', 'border-transparent');
            }
        }
    }
</script>
@endsection
