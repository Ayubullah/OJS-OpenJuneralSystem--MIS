@extends('layout.app_author')

@section('title', __('Resubmit Article'))
@section('page-title', __('Resubmit Article'))
@section('page-description', __('Upload a new version of your article'))

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 border-l-4 border-orange-500 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-orange-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-bold text-orange-900">Article Resubmission</h3>
                        <p class="mt-1 text-sm text-orange-800">
                            This will create a <strong>NEW VERSION</strong> in the submissions table. The original article information remains unchanged.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Original Article Info -->
        <div class="mb-6 bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Original Article Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Title</p>
                    <p class="text-base font-medium text-gray-900">{{ $article->title }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Journal</p>
                    <p class="text-base font-medium text-gray-900">{{ $article->journal->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Category</p>
                    <p class="text-base font-medium text-gray-900">{{ $article->category->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="text-base font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $article->status)) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Manuscript Type</p>
                    <p class="text-base font-medium text-gray-900">{{ $article->manuscript_type }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Original Submission Date</p>
                    <p class="text-base font-medium text-gray-900">{{ $article->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            @php
                $latestSubmission = $article->submissions()->orderBy('version_number', 'desc')->first();
                $currentVersion = $latestSubmission ? $latestSubmission->version_number : 0;
                $nextVersion = $currentVersion + 1;
            @endphp

            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-500">Current Version</p>
                <p class="text-2xl font-bold text-blue-600">Version {{ $currentVersion }}</p>
                <p class="text-sm text-green-600 mt-1">→ Next submission will be Version {{ $nextVersion }}</p>
            </div>
        </div>

        <!-- Resubmission Form -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-amber-50">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-500 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Upload New Version</h2>
                        <p class="text-sm text-gray-600">Upload your revised manuscript file</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('author.articles.storeResubmission', $article) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- File Upload -->
                <div>
                    <label for="manuscript_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Revised Manuscript File <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="mt-1 flex items-center justify-center px-6 py-12 border-2 border-gray-300 border-dashed rounded-lg hover:border-orange-400 transition-colors duration-200 bg-gray-50">
                        <div class="space-y-3 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <div class="flex flex-col items-center text-sm text-gray-600">
                                <label for="manuscript_file" class="relative cursor-pointer bg-white px-4 py-2 rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500 border border-orange-300">
                                    <span>Choose file to upload</span>
                                    <input id="manuscript_file" name="manuscript_file" type="file" class="sr-only" accept=".pdf,.doc,.docx" required onchange="updateFileName(this)">
                                </label>
                                <p class="mt-2">or drag and drop here</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 10MB</p>
                            <p id="file-name" class="text-base font-bold text-orange-600 mt-3"></p>
                        </div>
                    </div>
                    
                    @error('manuscript_file')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-sm text-blue-800">
                            <strong>📝 Note:</strong> Upload your revised manuscript. This will be tracked as Version {{ $nextVersion }} in the submission history.
                        </p>
                    </div>
                </div>

                <!-- Message to Reviewers -->
                <div>
                    <label for="message_to_reviewers" class="block text-sm font-medium text-gray-700 mb-2">
                        Message to Reviewers <span class="text-gray-500">(Optional but Recommended)</span>
                    </label>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-2">
                        <p class="text-sm text-blue-800">
                            <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                            <strong>This message will be sent to reviewers of Version {{ $currentVersion }}</strong> (the current version). Use this to explain the changes you made in Version {{ $nextVersion }}.
                        </p>
                    </div>
                    <textarea name="message_to_reviewers" id="message_to_reviewers" rows="6" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                        placeholder="Dear Reviewers,

I have revised the manuscript based on your valuable feedback. The main changes include:
- [Describe changes]
- [Explain improvements]
- [Address specific reviewer concerns]

Thank you for your time and consideration.

Best regards">{{ old('message_to_reviewers') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Your message will be visible to all reviewers who have reviewed your article</p>
                    @error('message_to_reviewers')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Optional Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Revision Notes (Optional - For Your Reference Only)
                    </label>
                    <textarea name="notes" id="notes" rows="3" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Private notes about this revision (not visible to reviewers)...">{{ old('notes') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">These notes are for your personal reference only and will not be shared with reviewers</p>
                </div>

                <!-- Information Box -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-green-900">What happens when you resubmit:</h4>
                            <ul class="mt-2 text-sm text-green-800 space-y-1">
                                <li>• A new submission record (Version {{ $nextVersion }}) will be created</li>
                                <li>• The original article information remains unchanged</li>
                                <li>• Status will be set to "Under Review"</li>
                                <li>• All previous versions remain in the submission history</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('author.articles.show', $article) }}" 
                        class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-amber-600 text-white text-sm font-medium rounded-lg hover:from-orange-700 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Submit Version {{ $nextVersion }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Initialize Lucide icons
if (typeof lucide !== 'undefined') {
    lucide.createIcons();
}

function updateFileName(input) {
    const fileName = input.files[0]?.name;
    const fileNameDisplay = document.getElementById('file-name');
    if (fileName) {
        fileNameDisplay.textContent = `✓ Selected: ${fileName}`;
        fileNameDisplay.classList.add('animate-pulse');
        setTimeout(() => {
            fileNameDisplay.classList.remove('animate-pulse');
        }, 1000);
    }
}

// Drag and drop functionality
const dropZone = document.querySelector('[class*="border-dashed"]');
const fileInput = document.getElementById('manuscript_file');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => {
        dropZone.classList.add('border-orange-500', 'bg-orange-50');
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => {
        dropZone.classList.remove('border-orange-500', 'bg-orange-50');
    }, false);
});

dropZone.addEventListener('drop', (e) => {
    const files = e.dataTransfer.files;
    if (files.length) {
        fileInput.files = files;
        updateFileName(fileInput);
    }
}, false);
</script>
@endsection
