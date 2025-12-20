@extends('layout.app_editor')

@section('title', 'Edit Submission')
@section('page-title', 'Edit Submission')
@section('page-description', 'Update submission information')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('editor.submissions.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Submissions</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Edit</span>
</li>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-red-50">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center mr-4">
                    <i data-lucide="edit" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Submission</h1>
                    <p class="text-sm text-gray-600">Update submission information</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('editor.submissions.update', $submission) }}" method="POST" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Article Selection -->
            <div class="space-y-2">
                <label for="article_id" class="block text-sm font-semibold text-gray-700">
                    Article <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select id="article_id" 
                            name="article_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('article_id') border-red-300 @enderror"
                            required>
                        <option value="">Select an article</option>
                        @foreach($articles as $article)
                        <option value="{{ $article->id }}" {{ old('article_id', $submission->article_id) == $article->id ? 'selected' : '' }}>
                            {{ $article->title }} - {{ $article->journal->name }}
                        </option>
                        @endforeach
                    </select>
                    <i data-lucide="file-text" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                </div>
                @error('article_id')
                <p class="text-sm text-red-600 flex items-center">
                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Author Selection -->
            <div class="space-y-2">
                <label for="author_id" class="block text-sm font-semibold text-gray-700">
                    Author <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select id="author_id" 
                            name="author_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('author_id') border-red-300 @enderror"
                            required>
                        <option value="">Select an author</option>
                        @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ old('author_id', $submission->author_id) == $author->id ? 'selected' : '' }}>
                            {{ $author->name }} ({{ $author->email }})
                        </option>
                        @endforeach
                    </select>
                    <i data-lucide="user" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                </div>
                @error('author_id')
                <p class="text-sm text-red-600 flex items-center">
                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Status and Version -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Status Selection -->
                <div class="space-y-2">
                    <label for="status" class="block text-sm font-semibold text-gray-700">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="status" 
                                name="status"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('status') border-red-300 @enderror"
                                required>
                            <option value="">Select status</option>
                            <option value="submitted" {{ old('status', $submission->status) === 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="under_review" {{ old('status', $submission->status) === 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="revision_required" {{ old('status', $submission->status) === 'revision_required' ? 'selected' : '' }}>Revision Required</option>
                            <option value="accepted" {{ old('status', $submission->status) === 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="published" {{ old('status', $submission->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="rejected" {{ old('status', $submission->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <i data-lucide="activity" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                    </div>
                    @error('status')
                    <p class="text-sm text-red-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Version Number -->
                <div class="space-y-2">
                    <label for="version_number" class="block text-sm font-semibold text-gray-700">
                        Version Number <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="version_number" 
                           name="version_number" 
                           value="{{ old('version_number', $submission->version_number) }}"
                           min="1"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('version_number') border-red-300 @enderror"
                           placeholder="Enter version number"
                           required>
                    @error('version_number')
                    <p class="text-sm text-red-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-100">
                <a href="{{ route('editor.submissions.show', $submission) }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white text-sm font-semibold rounded-xl hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i data-lucide="save" class="w-4 h-4 mr-2 inline"></i>
                    Update Submission
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection





