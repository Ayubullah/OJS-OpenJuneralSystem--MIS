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
        <form action="{{ route('editor.submissions.update', $submission) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
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

            <!-- File Upload -->
            <div class="space-y-2">
                <label for="file_path" class="block text-sm font-semibold text-gray-700">
                    Update Submitted File
                </label>
                @if($submission->file_path)
                <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Current file:</p>
                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                        <i data-lucide="file" class="w-4 h-4 mr-2"></i>
                        {{ basename($submission->file_path) }}
                    </a>
                </div>
                @endif
                <div class="mt-1 flex items-center justify-center px-6 py-8 border-2 border-gray-300 border-dashed rounded-xl hover:border-orange-400 transition-colors duration-200 bg-gray-50">
                    <div class="space-y-3 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <div class="flex flex-col items-center text-sm text-gray-600">
                            <label for="file_path" class="relative cursor-pointer bg-white px-4 py-2 rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500 border border-orange-300">
                                <span>Choose file to upload</span>
                                <input id="file_path" name="file_path" type="file" class="sr-only" accept=".pdf,.doc,.docx" onchange="updateFileName(this)">
                            </label>
                            <p class="mt-2">or drag and drop here</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 10MB</p>
                        <p id="file-name" class="text-sm font-semibold text-orange-600 mt-2"></p>
                    </div>
                </div>
                @error('file_path')
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
                            <option value="pending_verify" {{ old('status', $submission->status) === 'pending_verify' ? 'selected' : '' }}>Pending Verify</option>
                            <option value="verified" {{ old('status', $submission->status) === 'verified' ? 'selected' : '' }}>Verified</option>
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

            <!-- Approval Status (if approval workflow is being used) -->
            @if($submission->approval_pending_file || $submission->approval_status)
            <div class="space-y-2">
                <label for="approval_status" class="block text-sm font-semibold text-gray-700">
                    Approval Status
                    @if($submission->approval_status === 'verified')
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                        <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                        Verified
                    </span>
                    @endif
                </label>
                <div class="relative">
                    <select id="approval_status" 
                            name="approval_status"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('approval_status') border-red-300 @enderror {{ $submission->approval_status === 'verified' ? 'border-green-300 bg-green-50' : '' }}">
                        <option value="">No Approval Status</option>
                        <option value="pending" {{ old('approval_status', $submission->approval_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ old('approval_status', $submission->approval_status) === 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ old('approval_status', $submission->approval_status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <i data-lucide="check-circle" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                </div>
                @if($submission->approval_status === 'verified')
                <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800 flex items-center">
                        <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                        <strong>This article has been verified through the verification workflow.</strong> The status is set to "Verified" and approval status is "Verified".
                    </p>
                </div>
                @endif
                @error('approval_status')
                <p class="text-sm text-red-600 flex items-center">
                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>
            @endif

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

    // Update file name display
    function updateFileName(input) {
        const fileName = input.files[0]?.name || '';
        const fileNameDisplay = document.getElementById('file-name');
        if (fileName) {
            fileNameDisplay.textContent = 'Selected: ' + fileName;
        } else {
            fileNameDisplay.textContent = '';
        }
    }
</script>
@endsection







