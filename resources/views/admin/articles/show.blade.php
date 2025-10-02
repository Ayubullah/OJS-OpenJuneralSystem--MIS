@extends('layout.app_admin')

@section('title', 'Article Details')
@section('page-title', 'Article Details')
@section('page-description', 'View article information and details')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('admin.articles.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Articles</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ Str::limit($article->title, 30) }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Article Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-purple-50 to-blue-50">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 
                               ($article->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                               ($article->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                               ($article->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                            {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $article->created_at->format('M d, Y') }}</span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $article->title }}</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            <span>{{ $article->journal->name ?? 'Unknown Journal' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i data-lucide="tag" class="w-4 h-4"></i>
                            <span>{{ $article->category->name ?? 'Uncategorized' }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.articles.edit', $article) }}" 
                       class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2 inline"></i>
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Author Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center">
                        <span class="text-lg font-bold text-white">{{ substr($article->author->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $article->author->name ?? 'Unknown Author' }}</h3>
                        <p class="text-sm text-gray-600">{{ $article->author->email ?? 'No email' }}</p>
                        <p class="text-sm text-gray-500">{{ $article->author->affiliation ?? 'No affiliation' }}</p>
                    </div>
                </div>
                @if($article->author->specialization)
                <div class="flex items-center space-x-2">
                    <i data-lucide="award" class="w-4 h-4 text-gray-400"></i>
                    <span class="text-sm text-gray-600">Specialization: {{ $article->author->specialization }}</span>
                </div>
                @endif
            </div>

            <!-- Keywords -->
            @if($article->keywords->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Keywords</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->keywords as $keyword)
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full">
                        {{ $keyword->keyword }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Submissions History -->
            @if($article->submissions->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Submission History</h3>
                <div class="space-y-4">
                    @foreach($article->submissions as $submission)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="file-text" class="w-5 h-5 text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Version {{ $submission->version_number }}</p>
                                <p class="text-xs text-gray-500">{{ $submission->submission_date->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $submission->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                               ($submission->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                               ($submission->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Stats</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Submissions</span>
                        <span class="text-sm font-bold text-gray-900">{{ $article->submissions->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Reviews</span>
                        <span class="text-sm font-bold text-gray-900">{{ $article->submissions->sum(function($s) { return $s->reviews->count(); }) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Keywords</span>
                        <span class="text-sm font-bold text-gray-900">{{ $article->keywords->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Journal Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Journal Details</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $article->journal->name ?? 'Unknown Journal' }}</p>
                        <p class="text-xs text-gray-500">ISSN: {{ $article->journal->issn ?? 'N/A' }}</p>
                    </div>
                    @if($article->journal->description)
                    <p class="text-sm text-gray-600">{{ Str::limit($article->journal->description, 100) }}</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.articles.edit', $article) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        Edit Article
                    </a>
                    <a href="{{ route('admin.submissions.create') }}?article_id={{ $article->id }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        New Submission
                    </a>
                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                            Delete Article
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
