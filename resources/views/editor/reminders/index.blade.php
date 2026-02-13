@extends('layout.app_editor')

@section('title', 'Reminders')
@section('page-title', 'Reminders & Messages')
@section('page-description', 'Manage reminders and messages sent to authors and reviewers')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <a href="{{ route('editor.dashboard') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
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
        <div class="px-8 py-6 bg-gradient-to-r from-purple-50 to-pink-50">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Reminders & Messages</h1>
                    <p class="mt-2 text-sm text-gray-600">Send reminders and messages to authors and reviewers about their articles</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px overflow-x-auto">
                <button onclick="showTab('submissions')" id="submissionsTab" class="tab-button active px-6 py-4 text-sm font-medium text-purple-600 border-b-2 border-purple-600 whitespace-nowrap">
                    <i data-lucide="file-text" class="w-4 h-4 inline mr-2"></i>
                    Articles
                </button>
                <button onclick="showTab('authorMessages')" id="authorMessagesTab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                    Author Messages
                    @if(isset($authorMessages) && $authorMessages->count() > 0)
                    <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs font-bold rounded-full">{{ $authorMessages->count() }}</span>
                    @endif
                </button>
                <button onclick="showTab('reviewerMessages')" id="reviewerMessagesTab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    <i data-lucide="user-check" class="w-4 h-4 inline mr-2"></i>
                    Reviewer Messages
                    @if(isset($reviewerMessages) && $reviewerMessages->count() > 0)
                    <span class="ml-2 px-2 py-0.5 bg-green-500 text-white text-xs font-bold rounded-full">{{ $reviewerMessages->count() }}</span>
                    @endif
                </button>
                <button onclick="showTab('adminMessages')" id="adminMessagesTab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    <i data-lucide="shield" class="w-4 h-4 inline mr-2"></i>
                    Admin Messages
                    @if(isset($adminMessages) && $adminMessages->count() > 0)
                    <span class="ml-2 px-2 py-0.5 bg-indigo-500 text-white text-xs font-bold rounded-full">{{ $adminMessages->count() }}</span>
                    @endif
                </button>
            </nav>
        </div>

        <!-- Submissions Tab -->
        <div id="submissionsTabContent" class="tab-content p-6">
            <div class="mb-4">
                <p class="text-sm text-gray-600">Select an article to send a reminder message to the author and/or reviewers.</p>
            </div>

            @if($submissions->count() > 0)
            <div class="space-y-4">
                @foreach($submissions as $submission)
                <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                    Article ID: {{ $submission->article_id }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-900">{{ $submission->article->title }}</h3>
                            </div>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-3">
                                <div class="flex items-center space-x-1">
                                    <i data-lucide="book" class="w-4 h-4"></i>
                                    <span>{{ $submission->article->journal->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                    <span><strong>Author:</strong> {{ $submission->author->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i data-lucide="tag" class="w-4 h-4"></i>
                                    <span>{{ $submission->article->category->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                    <span>{{ $submission->submission_date?->format('M d, Y') ?? 'N/A' }}</span>
                                </div>
                            </div>
                            @if($submission->reviews->count() > 0)
                            <div class="mb-3">
                                <p class="text-xs text-gray-600 mb-1"><strong>Reviewers:</strong></p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($submission->reviews as $review)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        <i data-lucide="user-check" class="w-3 h-3 mr-1"></i>
                                        {{ $review->reviewer->user->name ?? 'Reviewer' }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $submission->status === 'published' ? 'bg-green-100 text-green-800' : 
                                       ($submission->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                                       ($submission->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($submission->status === 'accepted' ? 'bg-emerald-100 text-emerald-800' : 
                                       ($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                </span>
                                @if($submission->reviews->count() > 0)
                                <span class="text-xs text-gray-500">
                                    {{ $submission->reviews->count() }} reviewer(s) assigned
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('editor.submissions.show', ['submission' => $submission, 'from' => 'reminders']) }}" 
                               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                                Send Message
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($submissions->hasPages())
            <div class="mt-6">
                {{ $submissions->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="file-text" class="w-8 h-8 text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium">No articles found</p>
                <p class="text-sm text-gray-400 mt-1">Articles will appear here once they are submitted</p>
            </div>
            @endif
        </div>

        <!-- Author Messages Tab -->
        <div id="authorMessagesTabContent" class="tab-content p-4 hidden">
            @if(isset($authorMessages) && $authorMessages->count() > 0)
            <div class="space-y-2">
                @foreach($authorMessages as $message)
                <div class="bg-white rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-white">{{ substr($message->author->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $message->author->name ?? 'Author' }}</span>
                                    @if($message->article_id)
                                    <span class="text-xs text-gray-500">• Article ID: {{ $message->article_id }}</span>
                                    <span class="text-xs text-gray-600 font-medium">{{ $message->article->title ?? 'Untitled Article' }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ $message->created_at->format('M d, h:i A') }}</span>
                            </div>
                            <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($message->message, 150) }}</p>
                        </div>
                        <div class="flex items-center gap-1">
                            @if($message->sender_type !== 'admin')
                            <button onclick="openEditModal({{ $message->id }}, this)" 
                                    data-message="{{ htmlspecialchars($message->message, ENT_QUOTES, 'UTF-8') }}"
                                    class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </button>
                            <button onclick="confirmDelete({{ $message->id }})" 
                                    class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                            @endif
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
        <div id="reviewerMessagesTabContent" class="tab-content p-4 hidden">
            @if(isset($reviewerMessages) && $reviewerMessages->count() > 0)
            <div class="space-y-2">
                @foreach($reviewerMessages as $message)
                <div class="bg-white rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-white">{{ substr($message->reviewer->user->name ?? 'R', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $message->reviewer->user->name ?? ($message->reviewer->email ?? 'Reviewer') }}</span>
                                    @if($message->article_id)
                                    <span class="text-xs text-gray-500">• Article ID: {{ $message->article_id }}</span>
                                    <span class="text-xs text-gray-600 font-medium">{{ $message->article->title ?? 'Untitled Article' }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ $message->created_at->format('M d, h:i A') }}</span>
                            </div>
                            <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($message->message, 150) }}</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <button onclick="openEditModal({{ $message->id }}, this)" 
                                    data-message="{{ htmlspecialchars($message->message, ENT_QUOTES, 'UTF-8') }}"
                                    class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </button>
                            <button onclick="confirmDelete({{ $message->id }})" 
                                    class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
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

        <!-- Admin Messages Tab -->
        <div id="adminMessagesTabContent" class="tab-content p-4 hidden">
            @if(isset($adminMessages) && $adminMessages->count() > 0)
            <div class="space-y-2">
                @foreach($adminMessages as $message)
                <div class="bg-white rounded-lg border border-gray-200 p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-white">{{ substr($message->editor->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $message->editor->name ?? 'Admin' }}</span>
                                    <span class="px-1.5 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-bold rounded">Admin</span>
                                    @if($message->article_id)
                                    <span class="text-xs text-gray-500">• Article ID: {{ $message->article_id }}</span>
                                    <span class="text-xs text-gray-600 font-medium">{{ $message->article->title ?? 'Untitled Article' }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ $message->created_at->format('M d, h:i A') }}</span>
                            </div>
                            <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($message->message, 150) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i data-lucide="shield" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                <p class="text-sm text-gray-500">No admin messages yet</p>
            </div>
            @endif
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
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Enter your message here..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Minimum 10 characters, maximum 2000 characters</p>
                </div>
                
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                        Save Changes
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

    function showTab(tabName) {
        // Hide all tab contents
        document.getElementById('submissionsTabContent').classList.add('hidden');
        document.getElementById('authorMessagesTabContent').classList.add('hidden');
        document.getElementById('reviewerMessagesTabContent').classList.add('hidden');
        document.getElementById('adminMessagesTabContent').classList.add('hidden');
        
        // Remove active class from all tabs
        const tabs = ['submissionsTab', 'authorMessagesTab', 'reviewerMessagesTab', 'adminMessagesTab'];
        tabs.forEach(tabId => {
            const tab = document.getElementById(tabId);
            if (tab) {
                tab.classList.remove('active', 'text-purple-600', 'border-purple-600');
                tab.classList.add('text-gray-500', 'border-transparent');
            }
        });
        
        // Show selected tab content and activate tab
        if (tabName === 'submissions') {
            document.getElementById('submissionsTabContent').classList.remove('hidden');
            document.getElementById('submissionsTab').classList.add('active', 'text-purple-600', 'border-purple-600');
            document.getElementById('submissionsTab').classList.remove('text-gray-500', 'border-transparent');
        } else if (tabName === 'authorMessages') {
            document.getElementById('authorMessagesTabContent').classList.remove('hidden');
            document.getElementById('authorMessagesTab').classList.add('active', 'text-purple-600', 'border-purple-600');
            document.getElementById('authorMessagesTab').classList.remove('text-gray-500', 'border-transparent');
        } else if (tabName === 'reviewerMessages') {
            document.getElementById('reviewerMessagesTabContent').classList.remove('hidden');
            document.getElementById('reviewerMessagesTab').classList.add('active', 'text-purple-600', 'border-purple-600');
            document.getElementById('reviewerMessagesTab').classList.remove('text-gray-500', 'border-transparent');
        } else if (tabName === 'adminMessages') {
            document.getElementById('adminMessagesTabContent').classList.remove('hidden');
            document.getElementById('adminMessagesTab').classList.add('active', 'text-purple-600', 'border-purple-600');
            document.getElementById('adminMessagesTab').classList.remove('text-gray-500', 'border-transparent');
        }
    }

    // Edit Message Modal Functions
    function openEditModal(messageId, buttonElement) {
        const modal = document.getElementById('editMessageModal');
        const form = document.getElementById('editMessageForm');
        const textarea = document.getElementById('editMessageText');
        const messageText = buttonElement.getAttribute('data-message');
        
        // Set form action
        form.action = '{{ url("editor/messages") }}/' + messageId + '/update';
        
        // Set message text
        textarea.value = messageText;
        
        // Show modal
        modal.classList.remove('hidden');
        
        // Reinitialize icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function closeEditModal() {
        const modal = document.getElementById('editMessageModal');
        modal.classList.add('hidden');
        
        // Clear form
        document.getElementById('editMessageForm').reset();
    }

    // Close modal when clicking outside
    document.getElementById('editMessageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });

    // Delete Message Function
    function confirmDelete(messageId) {
        if (confirm('Are you sure you want to delete this message? This action cannot be undone.')) {
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ url("editor/messages") }}/' + messageId + '/delete';
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            // Add method spoofing for DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection

