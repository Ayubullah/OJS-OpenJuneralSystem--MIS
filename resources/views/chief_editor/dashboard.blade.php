@extends('layout.app_chief_editor')

@section('title', __('Chief Editor Dashboard'))
@section('page-title', __('Dashboard'))
@section('page-description', __('Articles pending your review'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-amber-600 via-orange-600 to-amber-700 rounded-2xl shadow-xl overflow-hidden">
        <div class="px-8 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">{{ __('Welcome back, :name!', ['name' => Auth::user()->name]) }}</h1>
                    <p class="text-amber-100 text-lg mb-2">{{ __('Review articles sent by editors for approval') }}</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30">
                        <i data-lucide="shield-check" class="w-12 h-12 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Pending Review') }}</p>
                    <p class="text-3xl font-bold text-amber-600">{{ $stats['total_pending'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="file-check" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Last 7 Days') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['recent_pending'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="calendar" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Ready to Review') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_pending'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="clipboard-check" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles Pending Review -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-orange-50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">{{ __('Articles Pending Review') }}</h3>
                <a href="{{ route('chief_editor.articles') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                    {{ __('View all') }} <i data-lucide="arrow-right" class="w-4 h-4 inline"></i>
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($recent_articles->count() > 0)
            <div class="space-y-4">
                @foreach($recent_articles as $article)
                <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md hover:border-amber-200 transition-all duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-900 truncate mb-1">{{ $article->title ?? __('Untitled Article') }}</h4>
                            <div class="flex items-center space-x-3 text-xs text-gray-500 mb-2">
                                <span class="flex items-center"><i data-lucide="user" class="w-3 h-3 mr-1"></i>{{ $article->author->name ?? __('Unknown Author') }}</span>
                                <span class="flex items-center"><i data-lucide="book" class="w-3 h-3 mr-1"></i>{{ $article->journal->name ?? __('Unknown Journal') }}</span>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                {{ __('Pending Review') }}
                            </span>
                        </div>
                        <a href="{{ route('chief_editor.articles.show', $article) }}" class="ml-4 px-4 py-2 bg-gradient-to-r from-amber-600 to-orange-600 text-white text-sm font-medium rounded-lg hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-sm">
                            <i data-lucide="eye" class="w-4 h-4 inline mr-1"></i>
                            {{ __('Review') }}
                        </a>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">{{ __('Sent') }} {{ $article->updated_at?->diffForHumans() ?? __('N/A') }}</p>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="inbox" class="w-8 h-8 text-amber-600"></i>
                </div>
                <h4 class="text-lg font-medium text-gray-900 mb-2">{{ __('No articles pending review') }}</h4>
                <p class="text-sm text-gray-500">{{ __('Articles sent by editors will appear here') }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Quick Actions') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('chief_editor.articles') }}" class="flex items-center p-4 border border-gray-200 rounded-xl hover:border-amber-300 hover:bg-amber-50 transition-all duration-200 group">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-amber-200 transition-colors">
                    <i data-lucide="file-check" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 group-hover:text-amber-600">{{ __('View All Pending Articles') }}</h4>
                    <p class="text-sm text-gray-500">{{ __('Review articles sent by editors') }}</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto group-hover:text-amber-600"></i>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 group">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors">
                    <i data-lucide="user-circle" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 group-hover:text-blue-600">{{ __('Profile Settings') }}</h4>
                    <p class="text-sm text-gray-500">{{ __('Update your profile') }}</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto group-hover:text-blue-600"></i>
            </a>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
@endsection
