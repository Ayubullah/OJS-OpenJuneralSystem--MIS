@extends('layout.app_editor')

@section('title', 'Edit Review Comment')
@section('page-title', 'Edit Review Comment')
@section('page-description', 'Edit and approve reviewer comment')

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
    <a href="{{ route('editor.submissions.show', $review->submission) }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Submission Details</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Edit Review</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Edit Review Comment</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            <span>{{ $review->submission->article->title ?? 'Untitled Article' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>Reviewer: {{ $review->reviewer->user->name ?? 'Unknown Reviewer' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-3"></i>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mr-3"></i>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Review Information -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Review Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Reviewer</label>
                <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer->user->name ?? 'Unknown Reviewer' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Rating</label>
                <p class="text-sm font-semibold text-gray-900">
                    @if($review->rating)
                        {{ $review->rating }}/10
                    @else
                        Not rated
                    @endif
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Review Date</label>
                <p class="text-sm font-semibold text-gray-900">{{ $review->review_date?->format('F d, Y \a\t h:i A') ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $review->editor_approved ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                    {{ $review->editor_approved ? 'Approved' : 'Pending Approval' }}
                </span>
            </div>
        </div>

        <!-- Original Comment -->
        @if($review->comments)
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Reviewer's Original Comment:</label>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $review->comments }}</p>
            </div>
        </div>
        @endif

        <!-- Edit Form -->
        <form action="{{ route('editor.reviews.update', $review) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="editor_edited_comments" class="block text-sm font-semibold text-gray-700 mb-2">
                    Edited Comment <span class="text-red-500">*</span>
                </label>
                <!-- Rich Text Editor Container -->
                <div id="editor-container" class="bg-white border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 @error('editor_edited_comments') border-red-300 @enderror" style="min-height: 350px;"></div>
                <!-- Hidden textarea to store HTML content -->
                <textarea 
                    id="editor_edited_comments" 
                    name="editor_edited_comments" 
                    style="display: none;"
                    required>{{ old('editor_edited_comments', $review->editor_edited_comments ?? $review->comments) }}</textarea>
                @error('editor_edited_comments')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">You can edit the reviewer's comment before approving it. The edited version will be shown to the author. Use the formatting toolbar to style your text.</p>
            </div>

            <div class="mb-6">
                <label class="flex items-center space-x-3">
                    <input 
                        type="checkbox" 
                        name="approve" 
                        value="1"
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        {{ old('approve', $review->editor_approved) ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">Approve and notify author</span>
                </label>
                <p class="mt-1 text-xs text-gray-500 ml-7">If checked, the review will be approved and the author will be notified immediately.</p>
            </div>

            <div class="flex items-center space-x-3">
                <button 
                    type="submit"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Save Changes
                </button>
                <a 
                    href="{{ route('editor.submissions.show', $review->submission) }}"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Quill.js Rich Text Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Initialize Quill Rich Text Editor
    document.addEventListener('DOMContentLoaded', function() {
        const editorContainer = document.getElementById('editor-container');
        const hiddenTextarea = document.getElementById('editor_edited_comments');
        
        if (editorContainer && hiddenTextarea) {
            // Initialize Quill editor
            const quill = new Quill('#editor-container', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'font': [] }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'align': [] }],
                        ['blockquote', 'code-block'],
                        ['link', 'image'],
                        ['clean']
                    ]
                },
                placeholder: 'Edit the reviewer\'s comment here. You can format the text, add emphasis, and structure the content before approving it.'
            });

            // Set initial content
            const initialContent = hiddenTextarea.value;
            if (initialContent) {
                // Check if it's HTML or plain text
                if (initialContent.trim().startsWith('<')) {
                    quill.root.innerHTML = initialContent;
                } else {
                    quill.setText(initialContent);
                }
            }

            // Update hidden textarea when content changes
            quill.on('text-change', function() {
                const html = quill.root.innerHTML;
                hiddenTextarea.value = html;
            });

            // Before form submission, ensure content is synced
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const html = quill.root.innerHTML;
                    hiddenTextarea.value = html;
                });
            }

            // Custom styles for Quill editor
            const style = document.createElement('style');
            style.textContent = `
                .ql-container {
                    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    font-size: 14px;
                    min-height: 300px;
                }
                .ql-editor {
                    min-height: 300px;
                    padding: 16px;
                }
                .ql-editor.ql-blank::before {
                    font-style: normal;
                    color: #9ca3af;
                }
                .ql-toolbar {
                    border-top: 1px solid #e5e7eb;
                    border-left: 1px solid #e5e7eb;
                    border-right: 1px solid #e5e7eb;
                    border-bottom: none;
                    background: #f9fafb;
                    padding: 12px;
                    border-radius: 8px 8px 0 0;
                }
                .ql-container {
                    border-bottom: 1px solid #e5e7eb;
                    border-left: 1px solid #e5e7eb;
                    border-right: 1px solid #e5e7eb;
                    border-top: none;
                    border-radius: 0 0 8px 8px;
                }
                .ql-snow .ql-stroke {
                    stroke: #6b7280;
                }
                .ql-snow .ql-fill {
                    fill: #6b7280;
                }
                .ql-snow .ql-picker-label {
                    color: #6b7280;
                }
                .ql-snow .ql-picker-options {
                    background: white;
                    border: 1px solid #e5e7eb;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                }
                .ql-snow .ql-tooltip {
                    background: white;
                    border: 1px solid #e5e7eb;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                }
            `;
            document.head.appendChild(style);
        }
    });
</script>
@endsection

