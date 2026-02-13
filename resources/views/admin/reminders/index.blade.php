@extends('layout.app_admin')

@section('title', 'Admin Reminders')
@section('page-title', 'Reminders & Messages')
@section('page-description', 'Send reminders and messages to editors, reviewers, and authors')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <a href="{{ route('admin.dashboard') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Reminders</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            </div>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
            </div>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-indigo-50 to-purple-50">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Reminders & Messages</h1>
                    <p class="mt-2 text-sm text-gray-600">Send reminders and messages to editors, reviewers, and authors</p>
                </div>
                <button onclick="openSendMessageModal()" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                    <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                    Send New Message
                </button>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px overflow-x-auto">
                <button onclick="showAdminTab('authorMessages')" id="adminAuthorMessagesTab" class="tab-button active px-6 py-4 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600 whitespace-nowrap">
                    <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                    Author Messages
                    @if(isset($authorMessages) && $authorMessages->count() > 0)
                    <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs font-bold rounded-full">{{ $authorMessages->count() }}</span>
                    @endif
                </button>
                <button onclick="showAdminTab('reviewerMessages')" id="adminReviewerMessagesTab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    <i data-lucide="user-check" class="w-4 h-4 inline mr-2"></i>
                    Reviewer Messages
                    @if(isset($reviewerMessages) && $reviewerMessages->count() > 0)
                    <span class="ml-2 px-2 py-0.5 bg-green-500 text-white text-xs font-bold rounded-full">{{ $reviewerMessages->count() }}</span>
                    @endif
                </button>
                <button onclick="showAdminTab('editorMessages')" id="adminEditorMessagesTab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    <i data-lucide="user-cog" class="w-4 h-4 inline mr-2"></i>
                    Editor Messages
                    @if(isset($editorMessages) && $editorMessages->count() > 0)
                    <span class="ml-2 px-2 py-0.5 bg-purple-500 text-white text-xs font-bold rounded-full">{{ $editorMessages->count() }}</span>
                    @endif
                </button>
            </nav>
        </div>

        <!-- Author Messages Tab -->
        <div id="adminAuthorMessagesTabContent" class="tab-content p-4">
            @if(isset($authorMessages) && $authorMessages->count() > 0)
            <div class="space-y-2">
                @foreach($authorMessages as $message)
                <div class="bg-white rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-white">{{ substr($message->author->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $message->author->name ?? 'Author' }}</span>
                                    @if($message->article_id)
                                    <span class="text-xs text-gray-500">• Article ID: {{ $message->article_id }}</span>
                                    <span class="text-xs text-gray-600 font-medium">{{ Str::limit($message->article->title ?? 'General Message', 40) }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap ml-2">{{ $message->created_at->format('M d, h:i A') }}</span>
                            </div>
                            <p class="text-xs text-gray-700 line-clamp-2 mb-1">{{ Str::limit($message->message, 120) }}</p>
                        </div>
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <button onclick="openEditModal({{ $message->id }}, this)" 
                                    data-message="{{ htmlspecialchars($message->message, ENT_QUOTES, 'UTF-8') }}"
                                    class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                            </button>
                            <button onclick="confirmDelete({{ $message->id }})" 
                                    class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i data-lucide="user" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                <p class="text-sm text-gray-500">No messages sent to authors yet</p>
            </div>
            @endif
        </div>

        <!-- Reviewer Messages Tab -->
        <div id="adminReviewerMessagesTabContent" class="tab-content p-4 hidden">
            @if(isset($reviewerMessages) && $reviewerMessages->count() > 0)
            <div class="space-y-2">
                @foreach($reviewerMessages as $message)
                <div class="bg-white rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-2">
                        <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-white">{{ substr($message->reviewer->user->name ?? 'R', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $message->reviewer->user->name ?? ($message->reviewer->email ?? 'Reviewer') }}</span>
                                    @if($message->article_id)
                                    <span class="text-xs text-gray-500">• Article ID: {{ $message->article_id }}</span>
                                    <span class="text-xs text-gray-600 font-medium">{{ Str::limit($message->article->title ?? 'General Message', 40) }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap ml-2">{{ $message->created_at->format('M d, h:i A') }}</span>
                            </div>
                            <p class="text-xs text-gray-700 line-clamp-2 mb-1">{{ Str::limit($message->message, 120) }}</p>
                        </div>
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <button onclick="openEditModal({{ $message->id }}, this)" 
                                    data-message="{{ htmlspecialchars($message->message, ENT_QUOTES, 'UTF-8') }}"
                                    class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                            </button>
                            <button onclick="confirmDelete({{ $message->id }})" 
                                    class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i data-lucide="user-check" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                <p class="text-sm text-gray-500">No messages sent to reviewers yet</p>
            </div>
            @endif
        </div>

        <!-- Editor Messages Tab -->
        <div id="adminEditorMessagesTabContent" class="tab-content p-4 hidden">
            @if(isset($editorMessages) && $editorMessages->count() > 0)
            <div class="space-y-2">
                @foreach($editorMessages as $message)
                <div class="bg-white rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-2">
                        <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-white">{{ substr($message->editorRecipient->name ?? 'E', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $message->editorRecipient->name ?? 'Editor' }}</span>
                                    @if($message->article_id)
                                    <span class="text-xs text-gray-500">• Article ID: {{ $message->article_id }}</span>
                                    <span class="text-xs text-gray-600 font-medium">{{ Str::limit($message->article->title ?? 'General Message', 40) }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap ml-2">{{ $message->created_at->format('M d, h:i A') }}</span>
                            </div>
                            <p class="text-xs text-gray-700 line-clamp-2 mb-1">{{ Str::limit($message->message, 120) }}</p>
                        </div>
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <button onclick="openEditModal({{ $message->id }}, this)" 
                                    data-message="{{ htmlspecialchars($message->message, ENT_QUOTES, 'UTF-8') }}"
                                    class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                            </button>
                            <button onclick="confirmDelete({{ $message->id }})" 
                                    class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i data-lucide="user-cog" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                <p class="text-sm text-gray-500">No messages sent to editors yet</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Send Message Modal -->
<div id="sendMessageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Send Message</h3>
                <button onclick="closeSendMessageModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="sendMessageForm" method="POST" action="{{ route('admin.reminders.send-message') }}">
                @csrf
                <div class="mb-4">
                    <label for="recipientType" class="block text-sm font-medium text-gray-700 mb-2">Send To *</label>
                    <select id="recipientType" name="recipient_type" required onchange="toggleRecipientFields()"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Select recipient type...</option>
                        <option value="author">Author</option>
                        <option value="reviewer">Reviewer</option>
                        <option value="editor">Editor</option>
                        <option value="all">All (Author & Reviewers)</option>
                    </select>
                </div>

                <div id="submissionField" class="mb-4 hidden">
                    <label for="submissionId" class="block text-sm font-medium text-gray-700 mb-2">Select Article *</label>
                    <div class="relative">
                        <div class="relative">
                            <input type="text" 
                                   id="articleSearchInput" 
                                   placeholder="Search articles..." 
                                   autocomplete="off"
                                   class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                            <button type="button" id="clearArticleSearch" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                        </div>
                        <div id="articleDropdown" class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                            <div class="p-2">
                                <div class="article-option cursor-pointer px-3 py-2 hover:bg-indigo-50 rounded transition-colors" data-value="" data-text="select article" onclick="selectArticle('', 'Select article...')">
                                    <span class="text-sm text-gray-700">Select article...</span>
                                </div>
                                @foreach($submissions as $submission)
                                <div class="article-option cursor-pointer px-3 py-2 hover:bg-indigo-50 rounded transition-colors" 
                                     data-value="{{ $submission->id }}" 
                                     data-text="{{ strtolower($submission->article->title . ' ' . $submission->article_id) }}"
                                     onclick="selectArticle('{{ $submission->id }}', '{{ addslashes($submission->article->title) }} (ID: {{ $submission->article_id }})')">
                                    <span class="text-sm text-gray-700">{{ $submission->article->title }} (ID: {{ $submission->article_id }})</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <select id="submissionId" name="submission_id" required class="hidden">
                            <option value="">Select article...</option>
                            @foreach($submissions as $submission)
                            <option value="{{ $submission->id }}">{{ $submission->article->title }} (ID: {{ $submission->article_id }})</option>
                            @endforeach
                        </select>
                        <div id="selectedArticleDisplay" class="mt-2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600 hidden">
                            <span class="font-medium">Selected: </span><span id="selectedArticleText"></span>
                        </div>
                    </div>
                </div>

                <div id="reviewerField" class="mb-4 hidden">
                    <label for="reviewerId" class="block text-sm font-medium text-gray-700 mb-2">Select Reviewer (Optional)</label>
                    <select id="reviewerId" name="reviewer_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">All reviewers for selected article</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Leave empty to send to all reviewers of the selected article</p>
                </div>

                <div id="editorField" class="mb-4 hidden">
                    <label for="editorId" class="block text-sm font-medium text-gray-700 mb-2">Select Editor *</label>
                    <select id="editorId" name="editor_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Select editor...</option>
                        @foreach($editors as $editor)
                        <option value="{{ $editor->user_id }}">{{ $editor->user->name ?? 'Editor' }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="messageText" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                    <textarea id="messageText" name="message" rows="6" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                              placeholder="Enter your message here..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Minimum 10 characters, maximum 2000 characters</p>
                </div>
                
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeSendMessageModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                        <i data-lucide="send" class="w-4 h-4 inline mr-2"></i>
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Message Modal -->
<div id="editMessageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Edit Message</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="editMessageForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="editMessageText" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                    <textarea id="editMessageText" name="message" rows="6" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                              placeholder="Enter your message here..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Minimum 10 characters, maximum 2000 characters</p>
                </div>
                
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                        <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    function showAdminTab(tabName) {
        // Hide all tab contents
        document.getElementById('adminAuthorMessagesTabContent').classList.add('hidden');
        document.getElementById('adminReviewerMessagesTabContent').classList.add('hidden');
        document.getElementById('adminEditorMessagesTabContent').classList.add('hidden');
        
        // Remove active class from all tabs
        const tabs = ['adminAuthorMessagesTab', 'adminReviewerMessagesTab', 'adminEditorMessagesTab'];
        tabs.forEach(tabId => {
            const tab = document.getElementById(tabId);
            if (tab) {
                tab.classList.remove('active', 'text-indigo-600', 'border-indigo-600');
                tab.classList.add('text-gray-500', 'border-transparent');
            }
        });
        
        // Show selected tab content and activate tab
        if (tabName === 'authorMessages') {
            document.getElementById('adminAuthorMessagesTabContent').classList.remove('hidden');
            document.getElementById('adminAuthorMessagesTab').classList.add('active', 'text-indigo-600', 'border-indigo-600');
            document.getElementById('adminAuthorMessagesTab').classList.remove('text-gray-500', 'border-transparent');
        } else if (tabName === 'reviewerMessages') {
            document.getElementById('adminReviewerMessagesTabContent').classList.remove('hidden');
            document.getElementById('adminReviewerMessagesTab').classList.add('active', 'text-indigo-600', 'border-indigo-600');
            document.getElementById('adminReviewerMessagesTab').classList.remove('text-gray-500', 'border-transparent');
        } else if (tabName === 'editorMessages') {
            document.getElementById('adminEditorMessagesTabContent').classList.remove('hidden');
            document.getElementById('adminEditorMessagesTab').classList.add('active', 'text-indigo-600', 'border-indigo-600');
            document.getElementById('adminEditorMessagesTab').classList.remove('text-gray-500', 'border-transparent');
        }
    }


    function toggleRecipientFields() {
        const recipientType = document.getElementById('recipientType').value;
        const submissionField = document.getElementById('submissionField');
        const reviewerField = document.getElementById('reviewerField');
        const editorField = document.getElementById('editorField');
        const submissionId = document.getElementById('submissionId');
        const editorId = document.getElementById('editorId');

        // Hide all fields first
        submissionField.classList.add('hidden');
        reviewerField.classList.add('hidden');
        editorField.classList.add('hidden');
        
        // Remove required attributes
        submissionId.removeAttribute('required');
        editorId.removeAttribute('required');

        if (recipientType === 'author' || recipientType === 'reviewer' || recipientType === 'all') {
            submissionField.classList.remove('hidden');
            submissionId.setAttribute('required', 'required');
            
            if (recipientType === 'reviewer') {
                reviewerField.classList.remove('hidden');
            }
        } else if (recipientType === 'editor') {
            editorField.classList.remove('hidden');
            editorId.setAttribute('required', 'required');
        }
    }

    function openSendMessageModal() {
        document.getElementById('sendMessageModal').classList.remove('hidden');
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        // Initialize article search after modal opens
        setTimeout(() => {
            initArticleSearch();
        }, 100);
    }

    function closeSendMessageModal() {
        document.getElementById('sendMessageModal').classList.add('hidden');
        document.getElementById('sendMessageForm').reset();
        toggleRecipientFields();
        // Reset article search
        const articleSearchInput = document.getElementById('articleSearchInput');
        const articleDropdown = document.getElementById('articleDropdown');
        const selectedArticleDisplay = document.getElementById('selectedArticleDisplay');
        if (articleSearchInput) articleSearchInput.value = '';
        if (articleDropdown) articleDropdown.classList.add('hidden');
        if (selectedArticleDisplay) selectedArticleDisplay.classList.add('hidden');
    }

    function openEditModal(messageId, buttonElement) {
        const modal = document.getElementById('editMessageModal');
        const form = document.getElementById('editMessageForm');
        const textarea = document.getElementById('editMessageText');
        const messageText = buttonElement.getAttribute('data-message');
        
        form.action = '{{ url("admin/reminders/messages") }}/' + messageId + '/update';
        textarea.value = messageText;
        modal.classList.remove('hidden');
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function closeEditModal() {
        document.getElementById('editMessageModal').classList.add('hidden');
        document.getElementById('editMessageForm').reset();
    }

    // Searchable Article Dropdown Functions
    function initArticleSearch() {
        const articleSearchInput = document.getElementById('articleSearchInput');
        const articleDropdown = document.getElementById('articleDropdown');
        const clearArticleSearch = document.getElementById('clearArticleSearch');
        const articleOptions = document.querySelectorAll('.article-option');
        
        if (!articleSearchInput || !articleDropdown) return;

        // Show dropdown on focus
        articleSearchInput.addEventListener('focus', function() {
            filterArticles();
            articleDropdown.classList.remove('hidden');
        });

        // Filter articles on input
        articleSearchInput.addEventListener('input', function() {
            filterArticles();
            if (this.value.trim()) {
                clearArticleSearch.classList.remove('hidden');
            } else {
                clearArticleSearch.classList.add('hidden');
            }
        });

        // Clear search
        if (clearArticleSearch) {
            clearArticleSearch.addEventListener('click', function(e) {
                e.stopPropagation();
                articleSearchInput.value = '';
                clearArticleSearch.classList.add('hidden');
                filterArticles();
                articleSearchInput.focus();
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!articleSearchInput.contains(e.target) && !articleDropdown.contains(e.target)) {
                articleDropdown.classList.add('hidden');
            }
        });
    }

    function filterArticles() {
        const searchInput = document.getElementById('articleSearchInput');
        if (!searchInput) return;
        
        const searchTerm = searchInput.value.toLowerCase().trim();
        const articleOptions = document.querySelectorAll('.article-option');
        let hasVisible = false;

        articleOptions.forEach(option => {
            const text = option.getAttribute('data-text') || option.textContent.toLowerCase();
            if (!searchTerm || text.includes(searchTerm)) {
                option.style.display = '';
                hasVisible = true;
            } else {
                option.style.display = 'none';
            }
        });

        const dropdown = document.getElementById('articleDropdown');
        if (dropdown && hasVisible) {
            dropdown.classList.remove('hidden');
        }
    }

    function selectArticle(value, text) {
        const submissionId = document.getElementById('submissionId');
        const articleSearchInput = document.getElementById('articleSearchInput');
        const articleDropdown = document.getElementById('articleDropdown');
        const selectedArticleDisplay = document.getElementById('selectedArticleDisplay');
        const selectedArticleText = document.getElementById('selectedArticleText');
        const clearArticleSearch = document.getElementById('clearArticleSearch');

        // Set the hidden select value
        if (submissionId) {
            submissionId.value = value;
        }

        // Update display
        if (value) {
            if (articleSearchInput) articleSearchInput.value = text;
            if (selectedArticleText) selectedArticleText.textContent = text;
            if (selectedArticleDisplay) selectedArticleDisplay.classList.remove('hidden');
        } else {
            if (articleSearchInput) articleSearchInput.value = '';
            if (selectedArticleDisplay) selectedArticleDisplay.classList.add('hidden');
        }

        if (clearArticleSearch) {
            if (value) {
                clearArticleSearch.classList.remove('hidden');
            } else {
                clearArticleSearch.classList.add('hidden');
            }
        }

        // Hide dropdown
        if (articleDropdown) articleDropdown.classList.add('hidden');
    }

    function confirmDelete(messageId) {
        if (confirm('Are you sure you want to delete this message? This action cannot be undone.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ url("admin/reminders/messages") }}/' + messageId + '/delete';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Update reviewers when submission changes
    document.getElementById('submissionId')?.addEventListener('change', function() {
        const submissionId = this.value;
        const reviewerField = document.getElementById('reviewerId');
        
        if (submissionId) {
            // Fetch reviewers for this submission
            fetch(`/admin/submissions/${submissionId}/reviewers`)
                .then(response => response.json())
                .then(data => {
                    reviewerField.innerHTML = '<option value="">All reviewers for selected article</option>';
                    data.reviewers.forEach(reviewer => {
                        const option = document.createElement('option');
                        option.value = reviewer.id;
                        option.textContent = reviewer.name;
                        reviewerField.appendChild(option);
                    });
                })
                .catch(() => {
                    reviewerField.innerHTML = '<option value="">All reviewers for selected article</option>';
                });
        }
    });

    document.getElementById('sendMessageModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeSendMessageModal();
        }
    });

    document.getElementById('editMessageModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
</script>
@endsection

