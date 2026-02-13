@extends('layout.app_author')

@section('title', 'Author Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview of your articles and submissions')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl shadow-xl overflow-hidden">
        <div class="px-8 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="text-indigo-100 text-lg">Track your article submissions and review progress</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30">
                        <i data-lucide="layout-dashboard" class="w-12 h-12 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages from Editor -->
    <div id="messages-section" class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Messages from Editor</h3>
                    <p class="text-sm text-gray-600">All messages sent to you by editors and administrators</p>
                </div>
                @if($allMessages && $allMessages->count() > 0)
                <span class="px-3 py-1 bg-blue-500 text-white text-sm font-bold rounded-full">{{ $allMessages->count() }}</span>
                @endif
            </div>
        </div>
        <div class="p-6">
            @if($allMessages && $allMessages->count() > 0)
            <div class="space-y-2">
                @foreach($allMessages as $message)
                <div class="bg-white rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 {{ $message->sender_type === 'admin' ? 'bg-indigo-600' : 'bg-blue-600' }} rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-white">{{ substr($message->sender_type === 'admin' ? ($message->editor->name ?? 'A') : ($message->editor->name ?? 'E'), 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-900">
                                        {{ $message->sender_type === 'admin' ? ($message->editor->name ?? 'Admin') : ($message->editor->name ?? 'Editor') }}
                                    </span>
                                    @if($message->sender_type === 'admin')
                                    <span class="px-1.5 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-bold rounded">Admin</span>
                                    @endif
                                    @if($message->article_id)
                                    <span class="text-xs text-gray-500">• Article ID: {{ $message->article_id }}</span>
                                    <span class="text-xs text-gray-600 font-medium">{{ $message->article->title ?? 'Untitled Article' }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ $message->created_at->format('M d, h:i A') }}</span>
                            </div>
                            <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($message->message, 150) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i data-lucide="message-square" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                <p class="text-sm text-gray-500">No messages yet</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endsection


