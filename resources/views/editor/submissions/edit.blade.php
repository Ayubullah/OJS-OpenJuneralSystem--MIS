@extends('layout.app_editor')

@section('title', __('Edit Submission'))
@section('page-title', __('Edit Submission'))
@section('page-description', __('Update submission information'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('editor.submissions.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Submissions') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ __('Edit') }}</span>
</li>
@endsection

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-red-50">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center mr-4">
                    <i data-lucide="edit" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('Edit Submission') }}</h1>
                    <p class="text-sm text-gray-600">{{ __('Update submission information') }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('editor.submissions.update', $submission) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Article Selection -->
            <div class="space-y-2">
                <label for="journal_select" class="block text-sm font-semibold text-gray-700">
                    {{ __('Journal') }} <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select id="journal_select" 
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('article_id') border-red-300 @enderror"
                            required>
                        <option value="">{{ __('Select a journal') }}</option>
                        @php
                            $currentJournalId = $submission->article->journal_id ?? null;
                            $currentArticleId = old('article_id', $submission->article_id);
                            $articlesByJournal = $articles->groupBy('journal_id');
                        @endphp
                        @foreach($journals as $journal)
                            @php
                                $isCurrentJournal = $currentJournalId == $journal->id;
                            @endphp
                            <option value="{{ $journal->id }}" 
                                    data-journal-id="{{ $journal->id }}"
                                    {{ $isCurrentJournal ? 'selected' : '' }}
                                    {{ $isCurrentJournal ? 'style="background-color: #fef3c7; font-weight: bold;"' : '' }}>
                                {{ $journal->name }}
                            </option>
                        @endforeach
                    </select>
                    <i data-lucide="book" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                </div>
                <input type="hidden" id="article_id" name="article_id" value="{{ old('article_id', $submission->article_id) }}" required>
                <input type="hidden" id="author_id" name="author_id" value="{{ old('author_id', $submission->author_id) }}" required>
                <input type="hidden" id="journal_id" name="journal_id" value="{{ old('journal_id', $currentJournalId) }}">
                @error('article_id')
                <p class="text-sm text-red-600 flex items-center">
                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- File Upload -->
            <div class="flex items-center gap-3">
                <label for="file_path" class="text-xs font-semibold text-gray-700 whitespace-nowrap">
                    {{ __('Update Submitted File') }}:
                </label>
                <div class="flex-1 flex items-center gap-2">
                    @if($submission->file_path)
                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-700 hover:bg-blue-100 transition-colors">
                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                        <span class="truncate max-w-[200px] font-medium">{{ basename($submission->file_path) }}</span>
                        <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                    @endif
                    <div class="relative flex-1 max-w-xs">
                        <label for="file_path" class="flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-orange-400 transition-all cursor-pointer text-xs font-medium text-gray-700 shadow-sm">
                            <i data-lucide="upload" class="w-3.5 h-3.5 text-orange-600"></i>
                            <span id="file-path-label">{{ __('Choose File') }}</span>
                            <input id="file_path" name="file_path" type="file" class="sr-only" accept=".pdf,.doc,.docx" onchange="updateFileName(this, 'file-name')">
                        </label>
                        <span id="file-name" class="absolute left-0 top-full mt-1 text-xs text-gray-600 truncate max-w-xs"></span>
                    </div>
                    @error('file_path')
                    <span class="text-xs text-red-600 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3 h-3"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Status and Version -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Status Selection -->
                <div class="space-y-2">
                    <label for="status" class="block text-sm font-semibold text-gray-700">
                        {{ __('Status') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="status" 
                                name="status"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('status') border-red-300 @enderror"
                                required>
                            <option value="">{{ __('Select status') }}</option>
                            <option value="submitted" {{ old('status', $submission->status) === 'submitted' ? 'selected' : '' }}>{{ __('Submitted') }}</option>
                            <option value="under_review" {{ old('status', $submission->status) === 'under_review' ? 'selected' : '' }}>{{ __('Under Review') }}</option>
                            <option value="revision_required" {{ old('status', $submission->status) === 'revision_required' ? 'selected' : '' }}>{{ __('Revision Required') }}</option>
                            <option value="disc_review" {{ old('status', $submission->status) === 'disc_review' ? 'selected' : '' }}>{{ __('Disc Review') }}</option>
                            <option value="pending_verify" {{ old('status', $submission->status) === 'pending_verify' ? 'selected' : '' }}>{{ __('Pending Verify') }}</option>
                            <option value="verified" {{ old('status', $submission->status) === 'verified' ? 'selected' : '' }}>{{ __('Verified') }}</option>
                            <option value="accepted" {{ old('status', $submission->status) === 'accepted' ? 'selected' : '' }}>{{ __('Accepted') }}</option>
                            <option value="published" {{ old('status', $submission->status) === 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                            <option value="rejected" {{ old('status', $submission->status) === 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
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
                        {{ __('Version Number') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="version_number" 
                           name="version_number" 
                           value="{{ old('version_number', $submission->version_number) }}"
                           min="1"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('version_number') border-red-300 @enderror"
                           placeholder="{{ __('Enter version number') }}"
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
                    {{ __('Approval Status') }}
                    @if($submission->approval_status === 'verified')
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                        <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                        {{ __('Verified') }}
                    </span>
                    @endif
                </label>
                <div class="relative">
                    <select id="approval_status" 
                            name="approval_status"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('approval_status') border-red-300 @enderror {{ $submission->approval_status === 'verified' ? 'border-green-300 bg-green-50' : '' }}">
                        <option value="">{{ __('No Approval Status') }}</option>
                        <option value="pending" {{ old('approval_status', $submission->approval_status) === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="verified" {{ old('approval_status', $submission->approval_status) === 'verified' ? 'selected' : '' }}>{{ __('Verified') }}</option>
                        <option value="rejected" {{ old('approval_status', $submission->approval_status) === 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                    </select>
                    <i data-lucide="check-circle" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                </div>
                @if($submission->approval_status === 'verified')
                <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800 flex items-center">
                        <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                        <strong>{{ __('This article has been verified through the verification workflow.') }}</strong> {{ __('The status is set to "Verified" and approval status is "Verified".') }}
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

            <!-- Plagiarism Section -->
            <div class="border-t border-gray-100 pt-4 space-y-3">
                <!-- First Row: Plagiarism Percentage -->
                <div class="flex items-center gap-2">
                    <label for="plagiarism_percentage" class="text-xs font-semibold text-gray-700 whitespace-nowrap">
                        <i data-lucide="file-search" class="w-3 h-3 inline mr-1"></i>{{ __('Plagiarism') }}:
                    </label>
                    <div class="flex items-center gap-1 flex-1 max-w-xs">
                        <input type="number" 
                               id="plagiarism_percentage" 
                               name="plagiarism_percentage" 
                               value="{{ old('plagiarism_percentage', $submission->plagiarism_percentage) }}"
                               min="0" 
                               max="100" 
                               step="0.01"
                               placeholder="0.00"
                               class="flex-1 px-2 py-1.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500 @error('plagiarism_percentage') border-red-300 @enderror">
                        <span class="text-xs text-gray-600">%</span>
                    </div>
                    @error('plagiarism_percentage')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Second Row: AI Report and Other Report -->
                <div class="flex items-center gap-4 flex-wrap">
                    <!-- AI Report File -->
                    <div class="flex items-center gap-2 flex-1 min-w-[200px]">
                        <label for="ai_report_file" class="text-xs font-semibold text-gray-700 whitespace-nowrap">
                            {{ __('AI Report') }}:
                        </label>
                        <div class="flex-1 flex items-center gap-2">
                            @if($submission->ai_report_file)
                            <a href="{{ asset('storage/' . $submission->ai_report_file) }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-700 hover:bg-blue-100 transition-colors">
                                <i data-lucide="file-text" class="w-3 h-3"></i>
                                <span class="truncate max-w-[100px] font-medium">{{ basename($submission->ai_report_file) }}</span>
                            </a>
                            @endif
                            <div class="relative flex-1">
                                <label for="ai_report_file" class="flex items-center gap-1.5 px-2.5 py-1 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-orange-400 transition-all cursor-pointer text-xs font-medium text-gray-700 shadow-sm">
                                    <i data-lucide="upload" class="w-3 h-3 text-orange-600"></i>
                                    <span>{{ __('Choose') }}</span>
                                    <input id="ai_report_file" name="ai_report_file" type="file" class="sr-only" accept=".pdf,.doc,.docx" onchange="updateFileName(this, 'ai-report-name')">
                                </label>
                                <span id="ai-report-name" class="absolute left-0 top-full mt-0.5 text-xs text-gray-600 truncate max-w-[150px]"></span>
                            </div>
                            @error('ai_report_file')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Other Resources Report File -->
                    <div class="flex items-center gap-2 flex-1 min-w-[200px]">
                        <label for="other_resources_report_file" class="text-xs font-semibold text-gray-700 whitespace-nowrap">
                            {{ __('Other Report') }}:
                        </label>
                        <div class="flex-1 flex items-center gap-2">
                            @if($submission->other_resources_report_file)
                            <a href="{{ asset('storage/' . $submission->other_resources_report_file) }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-700 hover:bg-blue-100 transition-colors">
                                <i data-lucide="file-text" class="w-3 h-3"></i>
                                <span class="truncate max-w-[100px] font-medium">{{ basename($submission->other_resources_report_file) }}</span>
                            </a>
                            @endif
                            <div class="relative flex-1">
                                <label for="other_resources_report_file" class="flex items-center gap-1.5 px-2.5 py-1 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-orange-400 transition-all cursor-pointer text-xs font-medium text-gray-700 shadow-sm">
                                    <i data-lucide="upload" class="w-3 h-3 text-orange-600"></i>
                                    <span>{{ __('Choose') }}</span>
                                    <input id="other_resources_report_file" name="other_resources_report_file" type="file" class="sr-only" accept=".pdf,.doc,.docx" onchange="updateFileName(this, 'other-resources-name')">
                                </label>
                                <span id="other-resources-name" class="absolute left-0 top-full mt-0.5 text-xs text-gray-600 truncate max-w-[150px]"></span>
                            </div>
                            @error('other_resources_report_file')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Article Date Fields -->
            <div class="border-t border-gray-100 pt-4">
                <div class="flex items-center gap-2 mb-3">
                    <i data-lucide="calendar" class="w-4 h-4 text-orange-600"></i>
                    <h3 class="text-sm font-bold text-gray-900">{{ __('Article Dates') }}</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Article Created At -->
                    <div class="space-y-2">
                        <label for="article_created_at" class="block text-xs font-semibold text-gray-700">
                            {{ __('Article Created Date') }}
                        </label>
                        <input type="datetime-local" 
                               id="article_created_at" 
                               name="article_created_at" 
                               value="{{ old('article_created_at', $submission->article->created_at ? $submission->article->created_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('article_created_at') border-red-300 @enderror">
                        @error('article_created_at')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Article Updated At -->
                    <div class="space-y-2">
                        <label for="article_updated_at" class="block text-xs font-semibold text-gray-700">
                            {{ __('Article Updated Date') }}
                        </label>
                        <input type="datetime-local" 
                               id="article_updated_at" 
                               name="article_updated_at" 
                               value="{{ old('article_updated_at', $submission->article->updated_at ? $submission->article->updated_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('article_updated_at') border-red-300 @enderror">
                        @error('article_updated_at')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Disc Review Message Section -->
            <div class="border-t border-gray-100 pt-4">
                <div class="flex items-center gap-2 mb-3">
                    <i data-lucide="message-square" class="w-4 h-4 text-orange-600"></i>
                    <h3 class="text-sm font-bold text-gray-900">{{ __('Disc Review Message') }}</h3>
                </div>
                <div class="space-y-3">
                    <!-- Hidden field to always send to author -->
                    <input type="hidden" name="disc_review_recipient" value="author">
                    
                    <div>
                        <label for="disc_review_message" class="block text-xs font-semibold text-gray-700 mb-1">
                            {{ __('Message') }}
                        </label>
                        <textarea id="disc_review_message" 
                                  name="disc_review_message" 
                                  rows="4"
                                  class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                  placeholder="{{ __('Enter your disc review message here...') }}"></textarea>
                        <p class="text-xs text-gray-500 mt-1">{{ __('This message will be sent to the author') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" 
                               id="send_disc_review_message" 
                               name="send_disc_review_message" 
                               value="1"
                               class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500">
                        <label for="send_disc_review_message" class="text-xs text-gray-700 cursor-pointer">
                            {{ __('Send disc review message') }}
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-100">
                <a href="{{ route('editor.submissions.show', $submission) }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white text-sm font-semibold rounded-xl hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i data-lucide="save" class="w-4 h-4 mr-2 inline"></i>
                    {{ __('Update Submission') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Update file name display
    function updateFileName(input, elementId) {
        const fileName = input.files[0]?.name || '';
        const fileNameDisplay = document.getElementById(elementId || 'file-name');
        const filePathLabel = document.getElementById('file-path-label');
        
        if (fileName && fileNameDisplay) {
            fileNameDisplay.textContent = fileName;
            fileNameDisplay.classList.remove('text-gray-600');
            fileNameDisplay.classList.add('text-green-600', 'font-medium');
        } else if (fileNameDisplay) {
            fileNameDisplay.textContent = '';
            fileNameDisplay.classList.remove('text-green-600', 'font-medium');
            fileNameDisplay.classList.add('text-gray-600');
        }
        
        // Update label text for main file input
        if (filePathLabel && fileName) {
            filePathLabel.textContent = fileName.length > 20 ? fileName.substring(0, 20) + '...' : fileName;
        } else if (filePathLabel && !fileName) {
            filePathLabel.textContent = '{{ __('Choose File') }}';
        }
    }

    // Handle journal selection
    document.addEventListener('DOMContentLoaded', function() {
        const journalSelect = document.getElementById('journal_select');
        const articleIdInput = document.getElementById('article_id');
        const journalIdInput = document.getElementById('journal_id');
        
        // Store articles by journal
        const articlesByJournal = {
            @php
                $articlesByJournal = $articles->groupBy('journal_id');
            @endphp
            @foreach($journals as $journal)
                @php
                    $journalArticles = $articlesByJournal->get($journal->id, collect());
                @endphp
                {{ $journal->id }}: [
                    @foreach($journalArticles as $article)
                        {id: {{ $article->id }}, title: "{{ addslashes($article->title) }}"}{{ !$loop->last ? ',' : '' }}
                    @endforeach
                ]{{ !$loop->last ? ',' : '' }}
            @endforeach
        };

        journalSelect.addEventListener('change', function() {
            const selectedJournalId = this.value;
            journalIdInput.value = selectedJournalId;
            
            // Find first article for selected journal
            const journalArticles = articlesByJournal[selectedJournalId] || [];
            if (journalArticles.length > 0) {
                articleIdInput.value = journalArticles[0].id;
            } else {
                // If no articles, keep current article_id but update journal_id
                // The controller will handle updating the article's journal_id
                articleIdInput.value = '{{ $currentArticleId }}';
            }
        });
    });
</script>
@endsection







