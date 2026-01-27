@extends('layout.app_admin')

@section('title', __('Article Details'))
@section('page-title', __('Article Details'))
@section('page-description', __('View article information and details'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('admin.articles.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Articles') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ Str::limit($article->title, 30) }}</span>
</li>
@endsection

@section('content')
@php
    $totalReviews = 0;
    foreach($article->submissions as $submission) {
        $totalReviews += $submission->reviews->count();
    }
@endphp
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
                            <span>{{ $article->journal->name ?? __('Unknown Journal') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i data-lucide="tag" class="w-4 h-4"></i>
                            <span>{{ $article->category->name ?? __('Uncategorized') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.articles.edit', $article) }}" 
                       class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2 inline"></i>
                        {{ __('Edit') }}
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
                        <h3 class="text-lg font-bold text-gray-900">{{ $article->author->name ?? __('Unknown Author') }}</h3>
                        <p class="text-sm text-gray-600">{{ $article->author->email ?? __('No email') }}</p>
                        <p class="text-sm text-gray-500">{{ $article->author->affiliation ?? __('No affiliation') }}</p>
                    </div>
                </div>
                @if($article->author->specialization)
                <div class="flex items-center space-x-2">
                    <i data-lucide="award" class="w-4 h-4 text-gray-400"></i>
                    <span class="text-sm text-gray-600">{{ __('Specialization: :value', ['value' => $article->author->specialization]) }}</span>
                </div>
                @endif
            </div>

            <!-- Article Details -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Article Details') }}</h3>
                <div class="space-y-4">
                    @if($article->abstract)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">{{ __('Abstract') }}</label>
                        <p class="text-sm text-gray-700 bg-gray-50 p-4 rounded-lg whitespace-pre-line">{{ $article->abstract }}</p>
                    </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if($article->word_count)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Word Count') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ number_format($article->word_count) }}</p>
                        </div>
                        @endif
                        @if($article->number_of_tables !== null)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Number of Tables') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $article->number_of_tables }}</p>
                        </div>
                        @endif
                        @if($article->number_of_figures !== null)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Number of Figures') }}</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $article->number_of_figures }}</p>
                        </div>
                        @endif
                    </div>
                    @if($article->manuscript_type)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Manuscript Type') }}</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $article->manuscript_type }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Keywords -->
            @if($article->keywords->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Keywords') }}</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->keywords as $keyword)
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full">
                        {{ $keyword->keyword }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Submissions History with Reviews -->
            @if($article->submissions->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="file-text" class="w-5 h-5 mr-2 text-purple-600"></i>
                    {{ __('Submission History & Reviews') }}
                </h3>
                <div class="space-y-6">
                    @foreach($article->submissions as $submission)
                    <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-gray-50 to-blue-50">
                        <!-- Submission Header -->
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                    <i data-lucide="file-text" class="w-6 h-6 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ __('Version :number', ['number' => $submission->version_number]) }}</p>
                                    <p class="text-xs text-gray-500">{{ $submission->submission_date->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ $submission->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($submission->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                                   ($submission->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                   ($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                                {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                            </span>
                        </div>

                        <!-- Submission File -->
                        @if($submission->file_path)
                        <div class="mb-4">
                            <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                Download Submission File
                            </a>
                        </div>
                        @endif

                        <!-- Reviews for this Submission -->
                        @if($submission->reviews->count() > 0)
                        <div class="mt-4">
                            <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                                <i data-lucide="message-square" class="w-4 h-4 mr-2 text-purple-600"></i>
                                Reviews ({{ $submission->reviews->count() }})
                            </h4>
                            <div class="space-y-4">
                                @foreach($submission->reviews as $review)
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <!-- Reviewer Info -->
                                    <div class="flex items-center justify-between mb-3 pb-3 border-b border-gray-100">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-bold text-white">{{ substr($review->reviewer->user->name ?? 'R', 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer->user->name ?? 'Unknown Reviewer' }}</p>
                                                <p class="text-xs text-gray-500">{{ $review->reviewer->email ?? 'No email' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @if($review->rating)
                                            <div class="flex items-center space-x-1">
                                                <span class="text-sm font-bold text-gray-900">{{ $review->rating }}/10</span>
                                                <div class="flex space-x-0.5">
                                                    @for($i = 1; $i <= 5; $i++)
                                                    <i data-lucide="star" class="w-3 h-3 {{ $i <= ($review->rating / 2) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endif
                                            @if($review->total_score !== null)
                                            <p class="text-xs text-gray-500">Score: {{ number_format($review->total_score, 1) }}/60</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Review Criteria (Detailed Format) -->
                                    @if($review->originality_comment || $review->relationship_to_literature_comment || $review->methodology_comment)
                                    <div class="mb-3 space-y-2">
                                        @if($review->originality_comment)
                                        <div class="text-xs">
                                            <span class="font-semibold text-gray-700">Originality:</span>
                                            <span class="text-gray-600">{{ Str::limit($review->originality_comment, 100) }}</span>
                                        </div>
                                        @endif
                                        @if($review->methodology_comment)
                                        <div class="text-xs">
                                            <span class="font-semibold text-gray-700">Methodology:</span>
                                            <span class="text-gray-600">{{ Str::limit($review->methodology_comment, 100) }}</span>
                                        </div>
                                        @endif
                                        @if($review->results_comment)
                                        <div class="text-xs">
                                            <span class="font-semibold text-gray-700">Results:</span>
                                            <span class="text-gray-600">{{ Str::limit($review->results_comment, 100) }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    @endif

                                    <!-- Strengths and Weaknesses -->
                                    @if($review->strengths || $review->weaknesses)
                                    <div class="mb-3 grid grid-cols-2 gap-2">
                                        @if($review->strengths)
                                        <div class="text-xs bg-green-50 p-2 rounded">
                                            <span class="font-semibold text-green-800">Strengths:</span>
                                            <p class="text-gray-700">{{ Str::limit($review->strengths, 80) }}</p>
                                        </div>
                                        @endif
                                        @if($review->weaknesses)
                                        <div class="text-xs bg-red-50 p-2 rounded">
                                            <span class="font-semibold text-red-800">Weaknesses:</span>
                                            <p class="text-gray-700">{{ Str::limit($review->weaknesses, 80) }}</p>
                                        </div>
                                        @endif
                                    </div>
                                    @endif

                                    <!-- Review Comments -->
                                    @if($review->comments)
                                    <div class="mb-3 p-3 bg-gray-50 rounded-lg">
                                        <p class="text-xs font-semibold text-gray-700 mb-1">Review Comments:</p>
                                        <div class="text-sm text-gray-700 ql-editor" style="padding: 0;">
                                            {!! Str::limit(strip_tags($review->comments), 200) !!}
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Recommendation -->
                                    @if($review->recommendation)
                                    <div class="mb-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            {{ $review->recommendation === 'acceptance' ? 'bg-green-100 text-green-800' : 
                                               ($review->recommendation === 'minor_revision' ? 'bg-blue-100 text-blue-800' : 
                                               ($review->recommendation === 'major_revision' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                                        </span>
                                    </div>
                                    @endif

                                    <!-- Plagiarism Percentage -->
                                    @if($review->plagiarism_percentage !== null)
                                    <div class="mb-3">
                                        <span class="text-xs text-gray-600">Plagiarism: </span>
                                        <span class="text-xs font-bold {{ $review->plagiarism_percentage > 20 ? 'text-red-600' : ($review->plagiarism_percentage > 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                            {{ number_format($review->plagiarism_percentage, 2) }}%
                                        </span>
                                    </div>
                                    @endif

                                    <!-- Author Reply -->
                                    @if($review->author_reply)
                                    <div class="mt-3 p-3 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <i data-lucide="message-square" class="w-4 h-4 text-green-600"></i>
                                            <p class="text-xs font-semibold text-green-800">Author's Reply:</p>
                                        </div>
                                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->author_reply }}</p>
                                    </div>
                                    @else
                                    <div class="mt-2 text-xs text-gray-400 italic">
                                        <i data-lucide="info" class="w-3 h-3 inline mr-1"></i>
                                        No author reply yet
                                    </div>
                                    @endif

                                    <!-- Review Date -->
                                    <div class="mt-2 text-xs text-gray-400">
                                        Reviewed on: {{ $review->created_at->format('M d, Y H:i') }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg text-center">
                            <p class="text-sm text-gray-500">
                                <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                                No reviews yet for this submission
                            </p>
                        </div>
                        @endif
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
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Quick Stats') }}</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Submissions') }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $article->submissions->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Reviews') }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $totalReviews }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Keywords') }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $article->keywords->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Journal Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Journal Details') }}</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $article->journal->name ?? __('Unknown Journal') }}</p>
                        <p class="text-xs text-gray-500">{{ __('ISSN: :issn', ['issn' => $article->journal->issn ?? 'N/A']) }}</p>
                    </div>
                    @if($article->journal->description)
                    <p class="text-sm text-gray-600">{{ Str::limit($article->journal->description, 100) }}</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Actions') }}</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.articles.edit', $article) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        {{ __('Edit Article') }}
                    </a>
                    <a href="{{ route('admin.submissions.create') }}?article_id={{ $article->id }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        {{ __('New Submission') }}
                    </a>
                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this article?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                            {{ __('Delete Article') }}
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
