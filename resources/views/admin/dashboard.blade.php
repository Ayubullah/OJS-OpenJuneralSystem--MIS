@extends('layout.app_admin')

@section('title', __('Admin Dashboard'))
@section('page-title', __('Dashboard'))
@section('page-description', __('Welcome to your KJOS admin dashboard'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Total Users') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                    <p class="text-xs text-green-600 font-medium mt-1">
                        <i data-lucide="trending-up" class="w-3 h-3 inline mr-1"></i>
                        {{ __('+12% from last month') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>

        <!-- Total Journals -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Total Journals') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_journals']) }}</p>
                    <p class="text-xs text-green-600 font-medium mt-1">
                        <i data-lucide="trending-up" class="w-3 h-3 inline mr-1"></i>
                        {{ __('+3 new this month') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="book" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>

        <!-- Total Articles -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Total Articles') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_articles']) }}</p>
                    <p class="text-xs text-green-600 font-medium mt-1">
                        <i data-lucide="trending-up" class="w-3 h-3 inline mr-1"></i>
                        {{ __('+8% from last month') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="file-text" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>

        <!-- Pending Reviews -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ __('Pending Reviews') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['pending_reviews']) }}</p>
                    <p class="text-xs text-orange-600 font-medium mt-1">
                        <i data-lucide="clock" class="w-3 h-3 inline mr-1"></i>
                        {{ __('Needs attention') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="eye" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Journals and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Journals -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">{{ __('Top Journals') }}</h3>
                <a href="{{ route('admin.journals.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">{{ __('View all') }}</a>
            </div>
            <div class="space-y-4">
                @forelse($top_journals as $journal)
                <a href="{{ route('admin.articles.index', ['journal_id' => $journal->id]) }}" class="flex items-center justify-between p-4 rounded-lg border border-gray-100 hover:border-blue-200 hover:shadow-md transition-all duration-200 cursor-pointer">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-blue-500 rounded-lg flex items-center justify-center">
                            <i data-lucide="book" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 hover:text-blue-600 hover:underline transition-colors">{{ $journal->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $journal->issn }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-gray-900">{{ $journal->articles_count }}</p>
                        <p class="text-xs text-gray-500">{{ __('articles') }}</p>
                    </div>
                </a>
                @empty
                <div class="text-center py-8">
                    <i data-lucide="book" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <p class="text-gray-500 text-sm">{{ __('No journals found') }}</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Quick Actions') }}</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.journals.create') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 hover:border-blue-200 border border-gray-100 transition-all duration-200 group">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200">
                        <i data-lucide="plus" class="w-4 h-4 text-blue-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">{{ __('Add New Journal') }}</span>
                </a>

                <a href="{{ route('admin.articles.create') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-green-50 hover:border-green-200 border border-gray-100 transition-all duration-200 group">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200">
                        <i data-lucide="file-plus" class="w-4 h-4 text-green-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-green-700">{{ __('Add New Article') }}</span>
                </a>

                <a href="{{ route('admin.users.create') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-50 hover:border-purple-200 border border-gray-100 transition-all duration-200 group">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200">
                        <i data-lucide="user-plus" class="w-4 h-4 text-purple-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">{{ __('Add New User') }}</span>
                </a>

                <a href="{{ route('admin.submissions.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-orange-50 hover:border-orange-200 border border-gray-100 transition-all duration-200 group">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200">
                        <i data-lucide="inbox" class="w-4 h-4 text-orange-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-orange-700">{{ __('Review Submissions') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Articles by Status Chart -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">{{ __('Articles by Status') }}</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">{{ __('Status Distribution') }}</span>
                </div>
            </div>
            <div class="space-y-4">
                @foreach($articles_by_status as $status)
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 rounded-full bg-gradient-to-r from-blue-500 to-purple-500"></div>
                        <span class="text-sm font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $status->status) }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-bold text-gray-900">{{ $status->total }}</span>
                        <div class="w-16 bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full" style="width: {{ ($status->total / $stats['total_articles']) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Submissions -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">{{ __('Recent Submissions') }}</h3>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">{{ __('View all') }}</a>
            </div>
            <div class="space-y-4">
                @forelse($recent_submissions as $submission)
                <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center">
                        <i data-lucide="file-text" class="w-5 h-5 text-white"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $submission->article->title ?? __('Untitled') }}</p>
                        <p class="text-xs text-gray-500">{{ $submission->author->name ?? __('Unknown Author') }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                            {{ ucfirst($submission->status) }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $submission->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i data-lucide="inbox" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <p class="text-gray-500 text-sm">{{ __('No recent submissions') }}</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
