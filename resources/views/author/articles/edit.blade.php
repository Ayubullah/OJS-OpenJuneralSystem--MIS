@extends('layout.app_author')

@section('title', 'Edit Article')
@section('page-title', 'Edit Article')
@section('page-description', 'Update your article submission details')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Article</h1>
            <p class="mt-2 text-gray-600">Update the details of your article submission</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-teal-50">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-500 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Edit Article Form</h2>
                        <p class="text-sm text-gray-600">All fields marked with * are required</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('author.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-8">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-blue-600 font-bold">1</span>
                        </span>
                        Basic Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Article Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                                placeholder="Enter the full title of your article" required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Journal -->
                        <div>
                            <label for="journal_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Target Journal <span class="text-red-500">*</span>
                            </label>
                            <select name="journal_id" id="journal_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('journal_id') border-red-500 @enderror" required>
                                <option value="">Select a journal...</option>
                                @foreach($journals as $journal)
                                <option value="{{ $journal->id }}" {{ old('journal_id', $article->journal_id) == $journal->id ? 'selected' : '' }}>
                                    {{ $journal->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('journal_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror" required>
                                <option value="">Select a category...</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Manuscript Type -->
                        <div class="md:col-span-2">
                            <label for="manuscript_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Manuscript Type <span class="text-red-500">*</span>
                            </label>
                            <select name="manuscript_type" id="manuscript_type" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('manuscript_type') border-red-500 @enderror" required>
                                <option value="Research Article" {{ old('manuscript_type', $article->manuscript_type) == 'Research Article' ? 'selected' : '' }}>Research Article</option>
                                <option value="Review Article" {{ old('manuscript_type', $article->manuscript_type) == 'Review Article' ? 'selected' : '' }}>Review Article</option>
                                <option value="Case Study" {{ old('manuscript_type', $article->manuscript_type) == 'Case Study' ? 'selected' : '' }}>Case Study</option>
                                <option value="Short Communication" {{ old('manuscript_type', $article->manuscript_type) == 'Short Communication' ? 'selected' : '' }}>Short Communication</option>
                                <option value="Letter to Editor" {{ old('manuscript_type', $article->manuscript_type) == 'Letter to Editor' ? 'selected' : '' }}>Letter to Editor</option>
                            </select>
                            @error('manuscript_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Abstract and Content -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-green-600 font-bold">2</span>
                        </span>
                        Abstract and Content Details
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Abstract -->
                        <div>
                            <label for="abstract" class="block text-sm font-medium text-gray-700 mb-2">
                                Abstract <span class="text-red-500">*</span>
                            </label>
                            <textarea name="abstract" id="abstract" rows="6" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('abstract') border-red-500 @enderror"
                                placeholder="Enter the abstract of your article..." required>{{ old('abstract', $article->abstract) }}</textarea>
                            @error('abstract')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Word Count -->
                            <div>
                                <label for="word_count" class="block text-sm font-medium text-gray-700 mb-2">
                                    Word Count <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="word_count" id="word_count" value="{{ old('word_count', $article->word_count) }}" min="0"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('word_count') border-red-500 @enderror"
                                    placeholder="5000" required>
                                @error('word_count')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Number of Tables -->
                            <div>
                                <label for="number_of_tables" class="block text-sm font-medium text-gray-700 mb-2">
                                    Number of Tables
                                </label>
                                <input type="number" name="number_of_tables" id="number_of_tables" value="{{ old('number_of_tables', $article->number_of_tables) }}" min="0"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('number_of_tables') border-red-500 @enderror"
                                    placeholder="0">
                                @error('number_of_tables')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Number of Figures -->
                            <div>
                                <label for="number_of_figures" class="block text-sm font-medium text-gray-700 mb-2">
                                    Number of Figures
                                </label>
                                <input type="number" name="number_of_figures" id="number_of_figures" value="{{ old('number_of_figures', $article->number_of_figures) }}" min="0"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('number_of_figures') border-red-500 @enderror"
                                    placeholder="0">
                                @error('number_of_figures')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Manuscript File Upload -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-purple-600 font-bold">3</span>
                        </span>
                        Manuscript File
                    </h3>

                    @if($article->manuscript_file)
                    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-900">Current File</p>
                                    <p class="text-xs text-blue-700">{{ basename($article->manuscript_file) }}</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $article->manuscript_file) }}" target="_blank"
                                class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                View
                            </a>
                        </div>
                    </div>
                    @endif

                    <div>
                        <label for="manuscript_file" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $article->manuscript_file ? 'Replace Manuscript File (Optional)' : 'Upload Manuscript File' }}
                        </label>
                        <div class="mt-1 flex items-center justify-center px-6 py-8 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors duration-200">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="manuscript_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a file</span>
                                        <input id="manuscript_file" name="manuscript_file" type="file" class="sr-only" accept=".pdf,.doc,.docx" onchange="updateFileName(this)">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 10MB</p>
                                <p id="file-name" class="text-sm font-medium text-blue-600 mt-2"></p>
                            </div>
                        </div>
                        @error('manuscript_file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Keywords -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-indigo-600 font-bold">4</span>
                        </span>
                        Keywords
                    </h3>

                    <div class="space-y-4">
                        <!-- Existing Keywords -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Select Existing Keywords
                            </label>
                            <div class="border border-gray-300 rounded-lg p-4 max-h-48 overflow-y-auto">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    @foreach($keywords as $keyword)
                                    <label class="flex items-center p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                                        <input type="checkbox" name="keywords[]" value="{{ $keyword->id }}" 
                                            {{ $article->keywords->contains($keyword->id) ? 'checked' : '' }}
                                            class="text-blue-600 focus:ring-blue-500 rounded">
                                        <span class="ml-2 text-sm text-gray-700">{{ $keyword->keyword }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- New Keywords -->
                        <div>
                            <label for="new_keywords" class="block text-sm font-medium text-gray-700 mb-2">
                                Add New Keywords
                            </label>
                            <input type="text" name="new_keywords" id="new_keywords" value="{{ old('new_keywords') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter keywords separated by commas (e.g., Machine Learning, AI, Neural Networks)">
                            <p class="mt-1 text-sm text-gray-500">Separate multiple keywords with commas</p>
                        </div>
                    </div>
                </div>

                <!-- Submission Details -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-orange-600 font-bold">5</span>
                        </span>
                        Submission Details
                    </h3>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Previously Submitted -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Previously Submitted Elsewhere? <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="previously_submitted" value="Yes" {{ old('previously_submitted', $article->previously_submitted) == 'Yes' ? 'checked' : '' }} 
                                            class="text-blue-600 focus:ring-blue-500" required>
                                        <span class="ml-2 text-sm text-gray-700">Yes</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="previously_submitted" value="No" {{ old('previously_submitted', $article->previously_submitted) == 'No' ? 'checked' : '' }} 
                                            class="text-blue-600 focus:ring-blue-500" required>
                                        <span class="ml-2 text-sm text-gray-700">No</span>
                                    </label>
                                </div>
                                @error('previously_submitted')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Funded by Outside Source -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Funded by Outside Source? <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="funded_by_outside_source" value="Yes" {{ old('funded_by_outside_source', $article->funded_by_outside_source) == 'Yes' ? 'checked' : '' }} 
                                            class="text-blue-600 focus:ring-blue-500" required>
                                        <span class="ml-2 text-sm text-gray-700">Yes</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="funded_by_outside_source" value="No" {{ old('funded_by_outside_source', $article->funded_by_outside_source) == 'No' ? 'checked' : '' }} 
                                            class="text-blue-600 focus:ring-blue-500" required>
                                        <span class="ml-2 text-sm text-gray-700">No</span>
                                    </label>
                                </div>
                                @error('funded_by_outside_source')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirmations -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 space-y-3">
                            <label class="flex items-start">
                                <input type="radio" name="confirm_not_published_elsewhere" value="Yes" {{ old('confirm_not_published_elsewhere', $article->confirm_not_published_elsewhere) == 'Yes' ? 'checked' : '' }} 
                                    class="mt-1 text-blue-600 focus:ring-blue-500" required>
                                <span class="ml-3 text-sm text-gray-700">
                                    <strong>I confirm</strong> that this manuscript has not been published elsewhere and is not under consideration by another journal. <span class="text-red-500">*</span>
                                </span>
                            </label>
                            @error('confirm_not_published_elsewhere')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <label class="flex items-start">
                                <input type="radio" name="confirm_prepared_as_per_guidelines" value="Yes" {{ old('confirm_prepared_as_per_guidelines', $article->confirm_prepared_as_per_guidelines) == 'Yes' ? 'checked' : '' }} 
                                    class="mt-1 text-blue-600 focus:ring-blue-500" required>
                                <span class="ml-3 text-sm text-gray-700">
                                    <strong>I confirm</strong> that this manuscript has been prepared according to the journal's guidelines for authors. <span class="text-red-500">*</span>
                                </span>
                            </label>
                            @error('confirm_prepared_as_per_guidelines')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('author.articles.show', $article) }}" 
                        class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600 text-white text-sm font-medium rounded-lg hover:from-green-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Article
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const fileName = input.files[0]?.name;
    const fileNameDisplay = document.getElementById('file-name');
    if (fileName) {
        fileNameDisplay.textContent = `Selected: ${fileName}`;
    }
}
</script>
@endsection

