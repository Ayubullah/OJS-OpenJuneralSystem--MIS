@extends('layout.app_admin')

@section('title', __('Create New Article'))
@section('page-title', __('Create Article'))
@section('page-description', __('Add a new article to the system'))

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
    <span class="text-sm font-medium text-gray-500">{{ __('Create') }}</span>
</li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-blue-50">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-blue-500 rounded-xl flex items-center justify-center mr-4">
                    <i data-lucide="file-plus" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('Create New Article') }}</h1>
                    <p class="text-sm text-gray-600">{{ __('Add a new article to your Kardan Journal Operating System') }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.articles.store') }}" method="POST" class="p-8 space-y-8">
            @csrf

            <!-- Article Title -->
            <div class="space-y-2">
                <label for="title" class="block text-sm font-semibold text-gray-700">
                    {{ __('Article Title') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('title') border-red-300 @enderror"
                       placeholder="{{ __('Enter the article title') }}"
                       required>
                @error('title')
                <p class="text-sm text-red-600 flex items-center">
                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Journal and Author Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Journal Selection -->
                <div class="space-y-2">
                    <label for="journal_id" class="block text-sm font-semibold text-gray-700">
                        {{ __('Journal') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="journal_id" 
                                name="journal_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('journal_id') border-red-300 @enderror"
                                required>
                            <option value="">{{ __('Select a journal') }}</option>
                            @foreach($journals as $journal)
                            <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>
                                {{ $journal->name }} ({{ $journal->issn }})
                            </option>
                            @endforeach
                        </select>
                        <i data-lucide="book" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                    </div>
                    @error('journal_id')
                    <p class="text-sm text-red-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Author Selection -->
                <div class="space-y-2">
                    <label for="author_id" class="block text-sm font-semibold text-gray-700">
                        {{ __('Author') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="author_id" 
                                name="author_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('author_id') border-red-300 @enderror"
                                required>
                            <option value="">{{ __('Select an author') }}</option>
                            @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
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
            </div>

            <!-- Category and Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category Selection -->
                <div class="space-y-2">
                    <label for="category_id" class="block text-sm font-semibold text-gray-700">
                        {{ __('Category') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="category_id" 
                                name="category_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('category_id') border-red-300 @enderror"
                                required>
                            <option value="">{{ __('Select a category') }}</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        <i data-lucide="tag" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                    </div>
                    @error('category_id')
                    <p class="text-sm text-red-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Status Selection -->
                <div class="space-y-2">
                    <label for="status" class="block text-sm font-semibold text-gray-700">
                        {{ __('Status') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="status" 
                                name="status"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('status') border-red-300 @enderror"
                                required>
                            <option value="">{{ __('Select status') }}</option>
                            <option value="submitted" {{ old('status') === 'submitted' ? 'selected' : '' }}>{{ __('Submitted') }}</option>
                            <option value="under_review" {{ old('status') === 'under_review' ? 'selected' : '' }}>{{ __('Under Review') }}</option>
                            <option value="revision_required" {{ old('status') === 'revision_required' ? 'selected' : '' }}>{{ __('Revision Required') }}</option>
                            <option value="accepted" {{ old('status') === 'accepted' ? 'selected' : '' }}>{{ __('Accepted') }}</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                            <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
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
            </div>

            <!-- Keywords Section -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">
                    {{ __('Keywords') }}
                </label>
                <div class="flex flex-wrap gap-2 p-4 border border-gray-200 rounded-xl min-h-[60px] focus-within:ring-2 focus-within:ring-purple-500 focus-within:border-transparent">
                    <input type="text" 
                           id="keywords-input"
                           placeholder="{{ __('Type keywords and press Enter') }}"
                           class="flex-1 min-w-[200px] border-none outline-none text-sm">
                </div>
                <p class="text-xs text-gray-500">{{ __('Press Enter to add keywords. Click to remove.') }}</p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-100">
                <a href="{{ route('admin.articles.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white text-sm font-semibold rounded-xl hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i data-lucide="save" class="w-4 h-4 mr-2 inline"></i>
                    {{ __('Create Article') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Keywords functionality
    const keywordsInput = document.getElementById('keywords-input');
    const keywordsContainer = keywordsInput.parentElement;
    let keywords = [];

    keywordsInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const keyword = this.value.trim();
            if (keyword && !keywords.includes(keyword)) {
                keywords.push(keyword);
                addKeywordTag(keyword);
                this.value = '';
            }
        }
    });

    function addKeywordTag(keyword) {
        const tag = document.createElement('span');
        tag.className = 'inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full';
        tag.innerHTML = `
            ${keyword}
            <button type="button" class="ml-2 text-purple-600 hover:text-purple-800" onclick="removeKeyword('${keyword}')">
                <i data-lucide="x" class="w-3 h-3"></i>
            </button>
        `;
        keywordsContainer.insertBefore(tag, keywordsInput);
        lucide.createIcons();
    }

    function removeKeyword(keyword) {
        keywords = keywords.filter(k => k !== keyword);
        const tags = keywordsContainer.querySelectorAll('span');
        tags.forEach(tag => {
            if (tag.textContent.trim().startsWith(keyword)) {
                tag.remove();
            }
        });
    }
</script>
@endsection
