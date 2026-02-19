@extends('layout.app_editorial_assistant')

@section('title', __('Editorial Assistant Dashboard'))
@section('page-title', __('Dashboard'))
@section('page-description', __('Overview of accepted articles'))

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-teal-600 via-cyan-600 to-indigo-600 rounded-2xl shadow-xl overflow-hidden">
        <div class="px-8 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">{{ __('Welcome back, :name!', ['name' => Auth::user()->name]) }}</h1>
                    <p class="text-teal-100 text-lg mb-2">{{ __('Here\'s an overview of all accepted articles') }}</p>
                    @if(isset($journalNames) && count($journalNames) > 0)
                    <div class="mt-3">
                        <p class="text-teal-100 text-sm font-medium mb-1">{{ __('Journal(s)') }}:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($journalNames as $journalName)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30 text-white">
                                <i data-lucide="book-open" class="w-4 h-4 mr-1.5"></i>
                                {{ $journalName }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="hidden md:block">
                    <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30">
                        <i data-lucide="check-circle" class="w-12 h-12 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Accepted Articles -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Total Accepted Articles') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_accepted'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="file-check" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>

        <!-- Total Accepted Submissions -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Total Accepted Submissions') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_accepted_submissions'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>

        <!-- Recent Accepted (Last 7 Days) -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Recent Accepted (7 Days)') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['recent_accepted'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="calendar" class="w-7 h-7 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Accepted Articles -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-teal-50 to-cyan-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Recent Accepted Articles') }}</h3>
                    <a href="{{ route('editorial_assistant.articles.index') }}" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                        {{ __('View all') }} <i data-lucide="arrow-right" class="w-4 h-4 inline"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recent_accepted_articles->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_accepted_articles as $article)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 truncate mb-1">
                                    {{ $article->title ?? __('Untitled Article') }}
                                </h4>
                                <div class="flex items-center space-x-3 text-xs text-gray-500 mb-2">
                                    <span class="flex items-center">
                                        <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                                        {{ $article->author->name ?? __('Unknown Author') }}
                                    </span>
                                    <span class="flex items-center">
                                        <i data-lucide="book" class="w-3 h-3 mr-1"></i>
                                        {{ $article->journal->name ?? __('Unknown Journal') }}
                                    </span>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                    Accepted
                                </span>
                            </div>
                            <a href="{{ route('editorial_assistant.articles.show', $article) }}" 
                               class="ml-4 p-2 text-gray-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-colors">
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </a>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">
                            {{ __('Accepted') }} {{ $article->created_at?->diffForHumans() ?? __('N/A') }}
                        </p>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="file-text" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">{{ __('No accepted articles yet') }}</h4>
                    <p class="text-sm text-gray-500">{{ __('Accepted articles will appear here') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Accepted Submissions -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Recent Accepted Submissions') }}</h3>
                    <a href="{{ route('editorial_assistant.articles.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                        {{ __('View all') }} <i data-lucide="arrow-right" class="w-4 h-4 inline"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recent_accepted_submissions->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_accepted_submissions as $submission)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 truncate mb-1">
                                    {{ $submission->article->title ?? __('Untitled Article') }}
                                </h4>
                                <div class="flex items-center space-x-3 text-xs text-gray-500 mb-2">
                                    <span class="flex items-center">
                                        <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                                        {{ $submission->author->name ?? __('Unknown Author') }}
                                    </span>
                                    <span class="flex items-center">
                                        <i data-lucide="book" class="w-3 h-3 mr-1"></i>
                                        {{ $submission->article->journal->name ?? __('Unknown Journal') }}
                                    </span>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Accepted
                                </span>
                            </div>
                            <a href="{{ route('editorial_assistant.articles.show', $submission->article) }}" 
                               class="ml-4 p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </a>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">
                            {{ __('Accepted') }} {{ $submission->created_at?->diffForHumans() ?? __('N/A') }}
                        </p>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="file-check" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">{{ __('No accepted submissions yet') }}</h4>
                    <p class="text-sm text-gray-500">{{ __('Accepted submissions will appear here') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Quick Actions') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('editorial_assistant.articles.index') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-teal-300 hover:bg-teal-50 transition-all duration-200 group">
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-teal-200 transition-colors">
                    <i data-lucide="file-check" class="w-5 h-5 text-teal-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 group-hover:text-teal-600">{{ __('View All Accepted Articles') }}</h4>
                    <p class="text-sm text-gray-500">{{ __('Browse all accepted articles') }}</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto group-hover:text-teal-600"></i>
            </a>

            <a href="{{ route('editorial_assistant.profile.edit') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200 group">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-indigo-200 transition-colors">
                    <i data-lucide="user-circle" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 group-hover:text-indigo-600">{{ __('Profile Settings') }}</h4>
                    <p class="text-sm text-gray-500">{{ __('Update your profile') }}</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto group-hover:text-indigo-600"></i>
            </a>
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

