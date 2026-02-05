@extends('layout.app_admin')

@section('title', 'Article Submission Portal')

@section('page-title', 'Submit Article')
@section('page-description', 'Create your account and submit your research article in one step')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-2xl p-8 text-white shadow-2xl">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <h1 class="text-3xl font-bold mb-3">Article Submission Portal</h1>
                <p class="text-blue-100 text-lg mb-4">Create your author account and submit your research article in one comprehensive workflow</p>
                <div class="flex flex-wrap items-center gap-6 text-sm">
                    <div class="flex items-center space-x-2 bg-white/10 rounded-lg px-3 py-2">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Author Registration</span>
                    </div>
                    <div class="flex items-center space-x-2 bg-white/10 rounded-lg px-3 py-2">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        <span>Article Submission</span>
                    </div>
                    <div class="flex items-center space-x-2 bg-white/10 rounded-lg px-3 py-2">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        <span>Peer Review Ready</span>
                    </div>
                </div>
            </div>
            <div class="hidden lg:flex items-center space-x-6 ml-8">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold">{{ $journals->count() }}</div>
                    <div class="text-xs text-blue-100 uppercase tracking-wide">Journals</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold">{{ $categories->count() }}</div>
                    <div class="text-xs text-blue-100 uppercase tracking-wide">Categories</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold">{{ $keywords->count() }}</div>
                    <div class="text-xs text-blue-100 uppercase tracking-wide">Keywords</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Author & Reviewer Management</h3>
            <p class="text-sm text-gray-600">Create new authors and assign reviewers with ratings</p>
        </div>

        <!-- Form Sections Overview -->
    <div class="bg-white rounded-lg shadow-xl border border-gray-200 p-4 mb-6">
        <div class="text-center mb-3">
            <h2 class="text-lg font-bold text-gray-800">Article Submission Form</h2>
            <p class="text-gray-600 text-xs">Complete all sections below to submit your article</p>
        </div>
        <div class="flex items-center justify-center flex-wrap gap-2">
            <div class="flex items-center space-x-1 text-xs text-gray-600">
                <i data-lucide="user-plus" class="w-3 h-3 text-blue-600"></i>
                <span>Personal Info</span>
            </div>
            <div class="w-1.5 h-1.5 bg-gray-300 rounded-full"></div>
            <div class="flex items-center space-x-1 text-xs text-gray-600">
                <i data-lucide="file-text" class="w-3 h-3 text-green-600"></i>
                <span>Article Details</span>
            </div>
            <div class="w-1.5 h-1.5 bg-gray-300 rounded-full"></div>
            <div class="flex items-center space-x-1 text-xs text-gray-600">
                <i data-lucide="edit-3" class="w-3 h-3 text-purple-600"></i>
                <span>Abstract</span>
            </div>
            <div class="w-1.5 h-1.5 bg-gray-300 rounded-full"></div>
            <div class="flex items-center space-x-1 text-xs text-gray-600">
                <i data-lucide="upload" class="w-3 h-3 text-orange-600"></i>
                <span>Upload</span>
            </div>
            <div class="w-1.5 h-1.5 bg-gray-300 rounded-full"></div>
            <div class="flex items-center space-x-1 text-xs text-gray-600">
                <i data-lucide="tag" class="w-3 h-3 text-teal-600"></i>
                <span>Keywords</span>
            </div>
            <div class="w-1.5 h-1.5 bg-gray-300 rounded-full"></div>
            <div class="flex items-center space-x-1 text-xs text-gray-600">
                <i data-lucide="send" class="w-3 h-3 text-gray-600"></i>
                <span>Submit</span>
            </div>
        </div>
    </div>

    <!-- Multi-Step Form -->
    <div class="bg-white rounded-lg shadow-2xl border border-gray-200 overflow-hidden">
        <form id="articleSubmissionForm" enctype="multipart/form-data">
            @csrf

        <!-- Step 1: Personal Information -->
        <div id="step1-content" class="step-content mb-8">
            <div class="bg-white border-2 border-blue-100 rounded-2xl shadow-xl overflow-hidden">
                <!-- Step Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 text-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3 backdrop-blur-sm">
                            <i data-lucide="user-plus" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">Personal Information</h2>
                            <p class="text-blue-100 text-xs mt-0.5">Create your author account</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6">
                    <!-- Author Selection Section -->
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i data-lucide="user-search" class="w-4 h-4 text-blue-600 mr-2"></i>
                            <label class="text-xs font-medium text-blue-800">Select Existing Author or Create New</label>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label for="existing_author_id" class="block text-xs font-medium text-gray-700 mb-1">Search Existing Author</label>
                                <select id="existing_author_id" name="existing_author_id" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Select an existing author (optional)...</option>
                                    @foreach($authors as $author)
                                    <option value="{{ $author->id }}" data-email="{{ $author->email }}" data-name="{{ $author->name }}" data-affiliation="{{ $author->affiliation }}" data-specialization="{{ $author->specialization }}" data-orcid="{{ $author->orcid_id }}" data-contributions="{{ $author->author_contributions }}">
                                        {{ $author->name }} - {{ $author->email }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="button" id="clearAuthorSelection" class="px-3 py-2 text-xs bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                                    <i data-lucide="x" class="w-3 h-3 inline mr-1"></i>Clear Selection
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">If you select an existing author, their information will be auto-filled. You can still edit it or create a new author.</p>
                    </div>

                    <!-- Hidden field to track if using existing author -->
                    <input type="hidden" id="use_existing_author" name="use_existing_author" value="0">

                    <div id="authorFormFields">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <div>
                                <label for="author_name" class="block text-xs font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" id="author_name" name="author_name" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Dr. John Smith" required>
                            </div>

                            <div>
                                <label for="username" class="block text-xs font-medium text-gray-700 mb-1">Username <span id="username_required" class="text-red-500">*</span></label>
                                <input type="text" id="username" name="username" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="johnsmith">
                            </div>

                            <div>
                                <label for="author_email" class="block text-xs font-medium text-gray-700 mb-1">Email Address *</label>
                                <input type="email" id="author_email" name="author_email" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="name@example.com" required>
                            </div>

                            <div id="passwordFields">
                                <label for="password" class="block text-xs font-medium text-gray-700 mb-1">Password <span id="password_required" class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" class="w-full px-3 py-2 pr-10 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Leave blank if using existing author">
                                    <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword('password')">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                <div class="mt-1">
                                    <div class="flex items-center space-x-2">
                                        <div class="text-xs text-gray-600">Strength:</div>
                                        <div id="password-strength" class="text-xs font-medium text-red-500">Weak</div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-0.5 mt-0.5">
                                        <div id="password-strength-bar" class="bg-red-500 h-0.5 rounded-full transition-all duration-300" style="width: 20%"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="passwordConfirmationField">
                                <label for="password_confirmation" class="block text-xs font-medium text-gray-700 mb-1">Confirm Password <span id="password_confirmation_required" class="text-red-500">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            </div>

                            <div>
                                <label for="affiliation" class="block text-xs font-medium text-gray-700 mb-1">Affiliation</label>
                                <input type="text" id="affiliation" name="affiliation" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="University of California">
                            </div>

                            <div>
                                <label for="specialization" class="block text-xs font-medium text-gray-700 mb-1">Specialization</label>
                                <input type="text" id="specialization" name="specialization" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="e.g., Molecular Biology">
                            </div>

                            <div class="lg:col-span-3">
                                <label for="orcid_id" class="block text-xs font-medium text-gray-700 mb-1">ORCID ID</label>
                                <input type="text" id="orcid_id" name="orcid_id" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="https://orcid.org/0000-0000-0000-0000">
                            </div>

                            <div class="lg:col-span-3">
                                <label for="author_contributions" class="block text-xs font-medium text-gray-700 mb-1">Author Contributions</label>
                                <textarea id="author_contributions" name="author_contributions" rows="2" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Describe your specific contributions to research (optional)..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Basic Information -->
        <div id="step2-content" class="step-content mb-8">
            <div class="bg-white border-2 border-green-100 rounded-2xl shadow-xl overflow-hidden">
                <!-- Step Header -->
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-4 py-3 text-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3 backdrop-blur-sm">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">Article Details</h2>
                            <p class="text-green-100 text-xs mt-0.5">Provide information about your research article</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Article Title -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 border border-green-100">
                            <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-lucide="file-text" class="w-4 h-4 text-green-600"></i>
                                </div>
                                Article Information
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="title" class="block text-xs font-semibold text-gray-800 mb-1">
                                        Article Title <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="title" name="title"
                                               class="w-full px-3 py-2 pl-10 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white"
                                               placeholder="Enter the complete title of your research article" required>
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                            <i data-lucide="file-text" class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <label for="journal_id" class="block text-xs font-semibold text-gray-800 mb-1">
                                            Target Journal <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <select id="journal_id" name="journal_id"
                                                    class="w-full px-3 py-2 pl-9 pr-8 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white appearance-none" required>
                                                <option value="">Select a journal...</option>
                                                @foreach($journals as $journal)
                                                <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                                <i data-lucide="book-open" class="w-4 h-4"></i>
                                            </div>
                                            <div class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="category_id" class="block text-xs font-semibold text-gray-800 mb-1">
                                            Article Category <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <select id="category_id" name="category_id"
                                                    class="w-full px-3 py-2 pl-9 pr-8 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white appearance-none" required>
                                                <option value="">Select a category...</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                                <i data-lucide="folder" class="w-4 h-4"></i>
                                            </div>
                                            <div class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="manuscript_type" class="block text-xs font-semibold text-gray-800 mb-1">
                                            Manuscript Type <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <select id="manuscript_type" name="manuscript_type"
                                                    class="w-full px-3 py-2 pl-9 pr-8 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white appearance-none" required>
                                                <option value="">Select type...</option>
                                                <option value="Research Article">Research Article</option>
                                                <option value="Review Article">Review Article</option>
                                                <option value="Case Study">Case Study</option>
                                                <option value="Short Communication">Short Communication</option>
                                                <option value="Letter to Editor">Letter to Editor</option>
                                            </select>
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </div>
                                            <div class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Editor & Reviewer Preview Section (Shows when journal is selected) -->
                        <div id="journalPreviewSection" class="hidden mt-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                                    <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
                                </div>
                                Available Editors & Reviewers for Selected Journal
                            </h3>

                            <!-- Editors Section -->
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <i data-lucide="user-check" class="w-4 h-4 mr-2 text-blue-600"></i>
                                    Available Editors
                                </h4>
                                <div id="journalEditorsList" class="space-y-2">
                                    <p class="text-sm text-gray-600">Select a journal to see available editors</p>
                                </div>
                            </div>

                            <!-- Reviewers Section -->
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <i data-lucide="user-search" class="w-4 h-4 mr-2 text-green-600"></i>
                                    Available Reviewers
                                </h4>
                                <div id="journalReviewersList" class="space-y-2">
                                    <p class="text-sm text-gray-600">Select a journal to see available reviewers</p>
                                </div>
                            </div>

                            <div class="mt-4 bg-blue-100 border border-blue-200 rounded-lg p-3">
                                <p class="text-xs text-blue-800">
                                    <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                                    <strong>Note:</strong> You can assign editors and reviewers in Step 6 (Submission Details). This preview shows all available options for the selected journal.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Step 3: Abstract and Content Details -->
        <div id="step3-content" class="step-content mb-8">
            <div class="bg-white border-2 border-purple-100 rounded-2xl shadow-xl overflow-hidden">
                <!-- Step Header -->
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-4 py-3 text-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3 backdrop-blur-sm">
                            <i data-lucide="edit-3" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">Abstract & Content Details</h2>
                            <p class="text-purple-100 text-xs mt-0.5">Provide detailed information about your manuscript</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Abstract Section -->
                        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-lg p-4 border border-purple-100">
                            <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-lucide="file-text" class="w-4 h-4 text-purple-600"></i>
                                </div>
                                Abstract
                            </h3>

                            <div>
                                <label for="abstract" class="block text-xs font-semibold text-gray-800 mb-1">
                                    Abstract <span class="text-red-500">*</span>
                                    <span class="text-xs text-gray-500">(Max 5000 chars)</span>
                                </label>
                                <textarea id="abstract" name="abstract" rows="5"
                                          class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white resize-none"
                                          placeholder="Provide a concise summary of your research..." required></textarea>
                                <div class="mt-1 flex justify-between items-center">
                                    <div class="text-xs text-gray-600">
                                        <span class="font-medium">Count:</span>
                                        <span id="abstract-count" class="font-bold text-purple-600">0</span>/5000
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Manuscript Details -->
                        <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-lg p-4 border border-orange-100">
                            <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-orange-600"></i>
                                </div>
                                Manuscript Specifications
                            </h3>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <div>
                                    <label for="word_count" class="block text-xs font-semibold text-gray-800 mb-1">
                                        Word Count <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="word_count" name="word_count"
                                               class="w-full px-3 py-2 pl-9 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white"
                                               placeholder="5000" min="100" max="50000" required>
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                            <i data-lucide="type" class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="number_of_tables" class="block text-xs font-semibold text-gray-800 mb-1">
                                        Number of Tables
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="number_of_tables" name="number_of_tables"
                                               class="w-full px-3 py-2 pl-9 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white"
                                               placeholder="0" min="0">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                            <i data-lucide="table" class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="number_of_figures" class="block text-xs font-semibold text-gray-800 mb-1">
                                        Number of Figures
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="number_of_figures" name="number_of_figures"
                                               class="w-full px-3 py-2 pl-9 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white"
                                               placeholder="0" min="0">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                            <i data-lucide="image" class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-800 mb-1">
                                        Manuscript Type
                                    </label>
                                    <div class="bg-white border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-600">
                                        <i data-lucide="file-text" class="w-3 h-3 inline mr-1"></i>
                                        <span id="manuscript-type-display">Not selected</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Manuscript File -->
        <div id="step4-content" class="step-content mb-8">
            <div class="bg-white border-2 border-orange-100 rounded-2xl shadow-xl overflow-hidden">
                <!-- Step Header -->
                <div class="bg-gradient-to-r from-orange-600 to-red-600 px-4 py-3 text-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3 backdrop-blur-sm">
                            <i data-lucide="upload" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">Upload Manuscript</h2>
                            <p class="text-orange-100 text-xs mt-0.5">Submit your research manuscript file</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6">
                    <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-lg p-4 border border-orange-100">
                        <div class="text-center mb-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i data-lucide="upload-cloud" class="w-6 h-6 text-orange-600"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-800 mb-1">Upload Your Manuscript</h3>
                            <p class="text-xs text-gray-600">Submit your complete research manuscript for review</p>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <label for="manuscript_file" class="block text-xs font-semibold text-gray-800 mb-2 text-center">
                                    Manuscript File <span class="text-red-500">*</span>
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-orange-400 transition-all duration-300 bg-gray-50 hover:bg-orange-50/50">
                                    <div class="text-center">
                                        <i data-lucide="file-text" class="w-10 h-10 text-gray-400 mx-auto mb-2"></i>
                                        <div class="space-y-1">
                                            <div class="text-sm font-semibold text-gray-700">
                                                <label for="manuscript_file" class="cursor-pointer text-orange-600 hover:text-orange-700 underline">
                                                    Click to upload
                                                </label>
                                                <span class="text-gray-500">or drag and drop</span>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, DOC, DOCX files up to 10MB</p>
                                        </div>
                                        <input id="manuscript_file" name="manuscript_file" type="file"
                                               class="hidden" accept=".pdf,.doc,.docx" required>
                                    </div>
                                </div>
                                <div id="file-info" class="mt-2 hidden">
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-2">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 bg-green-100 rounded flex items-center justify-center">
                                                <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-xs font-semibold text-green-800" id="file-name-display"></div>
                                                <div class="text-xs text-green-600" id="file-size-display"></div>
                                            </div>
                                            <button type="button" onclick="clearFile()"
                                                    class="text-red-500 hover:text-red-700 p-0.5">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-2">
                                <div class="flex items-start space-x-2">
                                    <i data-lucide="info" class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0"></i>
                                    <div>
                                        <h4 class="text-xs font-semibold text-blue-800 mb-1">File Requirements:</h4>
                                        <ul class="text-xs text-blue-700 space-y-0.5">
                                            <li>• PDF, DOC, DOCX up to 10MB</li>
                                            <li>• Complete manuscript with figures/tables</li>
                                            <li>• Remove identifying information</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5: Keywords -->
        <div id="step5-content" class="step-content mb-8">
            <div class="bg-white border-2 border-teal-100 rounded-2xl shadow-xl overflow-hidden">
                <!-- Step Header -->
                <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-4 py-3 text-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3 backdrop-blur-sm">
                            <i data-lucide="tag" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">Keywords & Tags</h2>
                            <p class="text-teal-100 text-xs mt-0.5">Add relevant keywords to help readers find your article</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Existing Keywords -->
                        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-lg p-4 border border-teal-100">
                            <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-lucide="search" class="w-4 h-4 text-teal-600"></i>
                                </div>
                                Select Existing Keywords
                            </h3>

                            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                                @foreach($keywords as $keyword)
                                <label class="flex items-center space-x-1 p-2 bg-white border border-gray-300 rounded-lg hover:border-teal-300 hover:bg-teal-50 transition-all duration-200 cursor-pointer group">
                                    <input type="checkbox" name="existing_keywords[]" value="{{ $keyword->id }}"
                                           class="w-3 h-3 text-teal-600 rounded focus:ring-teal-500">
                                    <span class="text-xs text-gray-700 group-hover:text-teal-800">{{ $keyword->keyword }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- New Keywords -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg p-4 border border-indigo-100">
                            <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-2">
                                    <i data-lucide="plus" class="w-4 h-4 text-indigo-600"></i>
                                </div>
                                Add New Keywords
                            </h3>

                            <div>
                                <label for="new_keywords" class="block text-xs font-semibold text-gray-800 mb-1">
                                    New Keywords <span class="text-xs text-gray-500">(Optional)</span>
                                </label>
                                <textarea id="new_keywords" name="new_keywords" rows="3"
                                          class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white resize-none"
                                          placeholder="Enter new keywords separated by commas"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 6: Submission Details -->
        <div id="step6-content" class="step-content mb-8">
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg p-4 border border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-gray-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Submission Details</h3>
                        <p class="text-xs text-gray-600">Final confirmations and optional reviewer assignment</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Submission History -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-2">Previously Submitted? *</label>
                            <div class="space-y-1">
                                <label class="flex items-center">
                                    <input type="radio" name="previously_submitted" value="1" class="w-3 h-3 text-gray-600 focus:ring-gray-500" required>
                                    <span class="ml-1 text-xs text-gray-700">Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="previously_submitted" value="0" class="w-3 h-3 text-gray-600 focus:ring-gray-500" required checked>
                                    <span class="ml-1 text-xs text-gray-700">No</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-2">Funded by Outside Source? *</label>
                            <div class="space-y-1">
                                <label class="flex items-center">
                                    <input type="radio" name="funded_by_outside_source" value="1" class="w-3 h-3 text-gray-600 focus:ring-gray-500" required>
                                    <span class="ml-1 text-xs text-gray-700">Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="funded_by_outside_source" value="0" class="w-3 h-3 text-gray-600 focus:ring-gray-500" required checked>
                                    <span class="ml-1 text-xs text-gray-700">No</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmations -->
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" id="confirm_not_published" name="confirm_not_published_elsewhere" value="1" class="mt-1 w-4 h-4 text-gray-600 rounded focus:ring-gray-500" required>
                            <label for="confirm_not_published" class="text-sm text-gray-700">
                                <span class="font-medium">I confirm that this manuscript has not been published elsewhere and is not under consideration by another journal.</span> *
                            </label>
                        </div>

                        <div class="flex items-start space-x-3">
                            <input type="checkbox" id="confirm_guidelines" name="confirm_prepared_as_per_guidelines" value="1" class="mt-1 w-4 h-4 text-gray-600 rounded focus:ring-gray-500" required>
                            <label for="confirm_guidelines" class="text-sm text-gray-700">
                                <span class="font-medium">I confirm that this manuscript has been prepared according to the journal's guidelines for authors.</span> *
                            </label>
                        </div>
                    </div>

                    <!-- Optional Editor Assignment (for admin use) -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <div class="flex items-center mb-2">
                            <i data-lucide="info" class="w-4 h-4 text-blue-600 mr-1"></i>
                            <span class="text-xs font-medium text-blue-800">Optional: Assign Editor & Reviewers</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label for="editor_id" class="block text-xs font-medium text-gray-700 mb-1">Assign Editor</label>
                                <select id="editor_id" name="editor_id" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Choose an editor (optional)...</option>
                                    @foreach($editors as $editor)
                                    <option value="{{ $editor->id }}" data-journal-id="{{ $editor->journal_id }}">
                                        {{ $editor->user->name }} - {{ $editor->journal->name ?? 'No Journal' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="editorDetails" class="hidden">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Editor Details</label>
                                <div class="bg-white p-2 rounded-lg border border-gray-200">
                                    <div class="space-y-0.5 text-xs">
                                        <div><span class="font-medium">Name:</span> <span id="editorName"></span></div>
                                        <div><span class="font-medium">Email:</span> <span id="editorEmail"></span></div>
                                        <div><span class="font-medium">Journal:</span> <span id="editorJournal"></span></div>
                                        <div><span class="font-medium">Status:</span> <span id="editorStatus"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Editors List Section -->
                        <div id="editorsListContainer" class="hidden mt-4">
                            <p class="text-xs font-medium text-blue-800 mb-2">Available Editors for Selected Journal:</p>
                            <div id="editorsList" class="grid grid-cols-1 md:grid-cols-2 gap-2"></div>
                        </div>

                        <!-- Reviewer Assignment Section -->
                        <div id="reviewersContainer" class="hidden mt-4">
                            <p class="text-xs font-medium text-blue-800 mb-2">Available Reviewers for Selected Journal:</p>
                            <p class="text-xs text-blue-600 mb-2">Select reviewers and provide ratings (optional)</p>
                            <!-- Reviewers will be displayed here via JavaScript -->
                        </div>

                        <!-- Template for reviewer cards -->
                        <div id="reviewerTemplate" class="hidden">
                            <div class="reviewer-card bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-1 mb-0.5">
                                            <input type="checkbox" class="reviewer-checkbox w-3 h-3 text-blue-600 rounded focus:ring-blue-500" data-reviewer-id="" name="" value="">
                                            <h5 class="text-xs font-medium text-gray-800 reviewer-name"></h5>
                                        </div>
                                        <p class="text-xs text-gray-600 reviewer-email"></p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-xs bg-blue-100 text-blue-800 px-1.5 py-0.5 rounded-full reviewer-expertise"></span>
                                            <span class="text-xs bg-green-100 text-green-800 px-1.5 py-0.5 rounded-full reviewer-specialization"></span>
                                        </div>
                                    </div>
                                    <div class="reviewer-rating-section hidden ml-2">
                                        <div class="flex items-center space-x-1">
                                            <label class="text-xs font-medium text-gray-700">Rating:</label>
                                            <select class="reviewer-rating w-20 px-1.5 py-1 border border-gray-300 rounded text-xs focus:ring-2 focus:ring-blue-500 focus:border-transparent" name="">
                                                <option value="">Rate</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="reviewer-comments-section hidden">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Comments</label>
                                    <textarea class="reviewer-comments w-full px-2 py-1 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" rows="2" name="" placeholder="Enter your review comments..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-4 pt-4 border-t border-gray-200">
                    <button type="submit" id="submitBtn" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-semibold text-sm shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                        <i data-lucide="send" class="w-4 h-4 mr-1"></i>
                        Submit Article
                    </button>
                </div>
            </div>
        </div>
    </form>

<!-- Success/Error Messages -->
<div id="messageContainer" class="fixed top-4 right-4 z-50 hidden">
    <div class="max-w-sm bg-white rounded-lg shadow-lg border p-4">
        <div class="flex items-center">
            <div id="messageIcon" class="flex-shrink-0"></div>
            <div class="ml-3">
                <p id="messageText" class="text-sm font-medium"></p>
            </div>
            <button type="button" id="closeMessage" class="ml-auto flex-shrink-0 text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

<!-- jQuery Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Lucide icons
    lucide.createIcons();

    // Check for success message in URL parameter and display it
    const urlParams = new URLSearchParams(window.location.search);
    const successMessage = urlParams.get('success');
    if (successMessage) {
        showMessage(decodeURIComponent(successMessage), 'success');
        // Clean up URL by removing the success parameter
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }

    // Author selection handler
    $('#existing_author_id').on('change', function() {
        const authorId = $(this).val();
        const selectedOption = $(this).find('option:selected');
        
        if (authorId) {
            // Fill form fields with selected author data
            $('#author_name').val(selectedOption.data('name') || '');
            $('#author_email').val(selectedOption.data('email') || '');
            $('#affiliation').val(selectedOption.data('affiliation') || '');
            $('#specialization').val(selectedOption.data('specialization') || '');
            $('#orcid_id').val(selectedOption.data('orcid') || '');
            $('#author_contributions').val(selectedOption.data('contributions') || '');
            
            // Make username and password optional
            $('#username').removeAttr('required');
            $('#password').removeAttr('required');
            $('#password_confirmation').removeAttr('required');
            $('#username_required').hide();
            $('#password_required').hide();
            $('#password_confirmation_required').hide();
            
            // Set hidden field to indicate using existing author
            $('#use_existing_author').val('1');
            
            // Show info message
            showMessage('Author information loaded. You can edit if needed. Username and password are optional for existing authors.', 'success');
        } else {
            // Clear form and make fields required again
            $('#author_name').val('');
            $('#author_email').val('');
            $('#affiliation').val('');
            $('#specialization').val('');
            $('#orcid_id').val('');
            $('#author_contributions').val('');
            $('#username').val('');
            $('#password').val('');
            $('#password_confirmation').val('');
            
            $('#username').attr('required', 'required');
            $('#password').attr('required', 'required');
            $('#password_confirmation').attr('required', 'required');
            $('#username_required').show();
            $('#password_required').show();
            $('#password_confirmation_required').show();
            
            $('#use_existing_author').val('0');
        }
        lucide.createIcons();
    });

    // Clear author selection button
    $('#clearAuthorSelection').on('click', function() {
        $('#existing_author_id').val('').trigger('change');
    });

    // Journal selection change handler - Auto-load editors and reviewers via AJAX
    // This matches the SQL query: SELECT j.id, j.name, eu.username, ru.username 
    // FROM journals j INNER JOIN editors/reviewers ON journal_id
    $(document).on('change', '#journal_id', function() {
        const journalId = $(this).val();
        const journalName = $(this).find('option:selected').text();
        
        console.log('Journal selected:', journalId, journalName);
        
        if (journalId) {
            // Load editors and reviewers via AJAX when journal is selected
            loadEditorsByJournal(journalId);
            loadReviewersByJournal(journalId);
            
            // Show preview section in Step 2 and load editors/reviewers preview
            loadJournalPreview(journalId);
        } else {
            // Reset editors dropdown to show all
            resetEditorDropdown();
            $('#editor_id').val('');
            $('#editorDetails').addClass('hidden');
            
            // Hide editors list
            $('#editorsListContainer').addClass('hidden');
            $('#editorsList').empty();
            
            // Clear reviewers
            $('#reviewersContainer').addClass('hidden');
            $('#reviewersContainer').find('.reviewers-grid, .loading-message').remove();
            
            // Hide preview section
            $('#journalPreviewSection').addClass('hidden');
        }
    });

    // Load editors by journal via AJAX
    // Matches SQL: SELECT j.id, j.name, eu.username FROM journals j 
    // INNER JOIN editors ed ON ed.journal_id = j.id
    // INNER JOIN users eu ON ed.user_id = eu.id
    // Load editors by journal via AJAX
    function loadEditorsByJournal(journalId) {
        console.log('Loading editors for journal:', journalId);
        
        const ajaxUrl = '{{ url("admin/previous-articles/journals") }}/' + journalId + '/editors';
        console.log('AJAX URL:', ajaxUrl);
        
        // Show loading state for editors
        $('#editorsListContainer').removeClass('hidden');
        $('#editorsList').html('<div class="col-span-2 text-center py-2"><i data-lucide="loader-2" class="w-4 h-4 text-blue-600 mx-auto mb-1 animate-spin inline"></i><p class="text-xs text-gray-600">Loading editors...</p></div>');
        lucide.createIcons();
        
        $.ajax({
            url: ajaxUrl,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log('Editors loaded:', data);
                const editorSelect = $('#editor_id');
                // Clear existing options except the first one
                editorSelect.find('option:not(:first)').remove();
                
                // Display editors in the list container
                const editorsList = $('#editorsList');
                editorsList.empty();
                
                if (data.editors && data.editors.length > 0) {
                    console.log('Found', data.editors.length, 'editors');
                    
                    // Add editors from AJAX response to dropdown
                    data.editors.forEach(function(editor) {
                        const displayName = editor.username || editor.name || 'N/A';
                        editorSelect.append(
                            $('<option></option>')
                                .attr('value', editor.id)
                                .attr('data-journal-id', editor.journal_id)
                                .text(displayName + ' - ' + editor.journal_name)
                        );
                    });
                    
                    // Display editors as cards below
                    data.editors.forEach(function(editor) {
                        const displayName = editor.username || editor.name || 'N/A';
                        const editorCard = `
                            <div class="bg-white p-2 rounded-lg border border-blue-200 shadow-sm hover:border-blue-400 transition-all">
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="user-check" class="w-4 h-4 text-blue-600 flex-shrink-0"></i>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-xs font-medium text-gray-800 truncate">${displayName}</div>
                                        <div class="text-xs text-gray-600 truncate">${editor.email || 'N/A'}</div>
                                        <div class="text-xs text-blue-600 mt-0.5">${editor.journal_name}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                        editorsList.append(editorCard);
                    });
                    
                    // Show editors list container
                    $('#editorsListContainer').removeClass('hidden');
                    
                    // Auto-select first editor if available
                    if (data.editors.length > 0) {
                        editorSelect.val(data.editors[0].id).trigger('change');
                    }
                } else {
                    console.log('No editors found for journal:', journalId);
                    // Show message if no editors found
                    editorSelect.append(
                        $('<option></option>')
                            .attr('value', '')
                            .text('No editors available for this journal')
                    );
                    editorsList.html('<div class="col-span-2 text-center py-2"><p class="text-xs text-gray-600">No editors available for this journal</p></div>');
                }
                lucide.createIcons();
            },
            error: function(xhr, status, error) {
                console.error('Error loading editors:', error, xhr.responseText);
                $('#editorsList').html('<div class="col-span-2 text-center py-2"><p class="text-xs text-red-600">Error loading editors. Check console for details.</p></div>');
                if (typeof showMessage === 'function') {
                    showMessage('Error loading editors for selected journal', 'error');
                }
                resetEditorDropdown();
            }
        });
    }

    // Reset editor dropdown to show all editors
    function resetEditorDropdown() {
        const editorSelect = $('#editor_id');
        editorSelect.find('option:not(:first)').remove();
        
        // Reload all editors from original data
        @foreach($editors as $editor)
        editorSelect.append(
            $('<option></option>')
                .attr('value', '{{ $editor->id }}')
                .attr('data-journal-id', '{{ $editor->journal_id }}')
                .text('{{ $editor->user->name }} - {{ $editor->journal->name ?? 'No Journal' }}')
        );
        @endforeach
    }

    // Load reviewers by journal via AJAX
    function loadReviewersByJournal(journalId) {
        console.log('Loading reviewers for journal:', journalId);
        
        const ajaxUrl = '{{ url("admin/previous-articles/journals") }}/' + journalId + '/reviewers';
        console.log('Reviewers AJAX URL:', ajaxUrl);
        
        // Show loading state
        $('#reviewersContainer').removeClass('hidden');
        // Remove existing content except headers
        $('#reviewersContainer').find('.reviewers-grid, .loading-message').remove();
        $('#reviewersContainer').append('<div class="loading-message text-center py-2"><i data-lucide="loader-2" class="w-4 h-4 text-blue-600 mx-auto mb-1 animate-spin inline"></i><p class="text-xs text-gray-600 inline ml-1">Loading reviewers...</p></div>');
        lucide.createIcons();
        
        $.ajax({
            url: ajaxUrl,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log('Reviewers loaded:', data);
                // Remove loading message
                $('#reviewersContainer').find('.loading-message').remove();
                
                if (data.reviewers && data.reviewers.length > 0) {
                    console.log('Found', data.reviewers.length, 'reviewers');
                    displayReviewers(data.reviewers);
                    $('#reviewersContainer').removeClass('hidden');
                } else {
                    console.log('No reviewers found for journal:', journalId);
                    $('#reviewersContainer').append(`
                        <div class="text-center py-2">
                            <i data-lucide="user-x" class="w-4 h-4 text-gray-400 mx-auto mb-1 inline"></i>
                            <p class="text-xs text-gray-600 inline ml-1">No reviewers found for this journal</p>
                        </div>
                    `);
                    $('#reviewersContainer').removeClass('hidden');
                    lucide.createIcons();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading reviewers:', error, xhr.responseText);
                $('#reviewersContainer').find('.loading-message').remove();
                $('#reviewersContainer').append(`
                    <div class="text-center py-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-red-400 mx-auto mb-1 inline"></i>
                        <p class="text-xs text-red-600 inline ml-1">Error loading reviewers. Check console for details.</p>
                    </div>
                `);
                lucide.createIcons();
                if (typeof showMessage === 'function') {
                    showMessage('Error loading reviewers for selected journal', 'error');
                }
            }
        });
    }

    // Load journal preview (editors and reviewers) for Step 2
    function loadJournalPreview(journalId) {
        // Show preview section
        $('#journalPreviewSection').removeClass('hidden');
        
        // Load editors for this journal via AJAX
        $.ajax({
            url: `{{ url('admin/previous-articles/journals') }}/${journalId}/editors`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                const editorsList = $('#journalEditorsList');
                if (data.editors && data.editors.length > 0) {
                    let editorsHtml = '<div class="grid grid-cols-1 md:grid-cols-2 gap-2">';
                    data.editors.forEach(function(editor) {
                        editorsHtml += `
                            <div class="bg-white p-3 rounded-lg border border-blue-200 shadow-sm">
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="user-check" class="w-4 h-4 text-blue-600"></i>
                                    <span class="text-sm font-medium text-gray-800">${editor.name}</span>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">${editor.journal_name}</p>
                            </div>
                        `;
                    });
                    editorsHtml += '</div>';
                    editorsList.html(editorsHtml);
                } else {
                    editorsList.html('<p class="text-sm text-gray-600">No editors available for this journal</p>');
                }
                lucide.createIcons();
            },
            error: function() {
                $('#journalEditorsList').html('<p class="text-sm text-red-600">Error loading editors</p>');
            }
        });
        
        // Load reviewers for this journal via AJAX
        $.ajax({
            url: `{{ url('admin/previous-articles/journals') }}/${journalId}/reviewers`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                const reviewersList = $('#journalReviewersList');
                if (data.reviewers && data.reviewers.length > 0) {
                    let reviewersHtml = '<div class="grid grid-cols-1 md:grid-cols-2 gap-2">';
                    data.reviewers.forEach(function(reviewer) {
                        reviewersHtml += `
                            <div class="bg-white p-3 rounded-lg border border-green-200 shadow-sm">
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="user-search" class="w-4 h-4 text-green-600"></i>
                                    <span class="text-sm font-medium text-gray-800">${reviewer.name}</span>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">${reviewer.email}</p>
                                <div class="flex items-center space-x-2 mt-2">
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">${reviewer.expertise || 'General'}</span>
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded-full">${reviewer.specialization || 'General'}</span>
                                </div>
                            </div>
                        `;
                    });
                    reviewersHtml += '</div>';
                    reviewersList.html(reviewersHtml);
                } else {
                    reviewersList.html('<p class="text-sm text-gray-600">No reviewers available for this journal</p>');
                }
                lucide.createIcons();
            },
            error: function() {
                $('#journalReviewersList').html('<p class="text-sm text-red-600">Error loading reviewers</p>');
            }
        });
    }

    // Editor selection change handler
    $('#editor_id').change(function() {
        const editorId = $(this).val();

        if (editorId) {
            // Load editor details
            $.ajax({
                url: `{{ url('admin/previous-articles/editors') }}/${editorId}`,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#editorName').text(data.editor.name);
                    $('#editorEmail').text(data.editor.email);
                    $('#editorJournal').text(data.editor.journal);
                    $('#editorStatus').text(data.editor.status.charAt(0).toUpperCase() + data.editor.status.slice(1));
                    $('#editorDetails').removeClass('hidden');
                },
                error: function() {
                    showMessage('Error loading editor details', 'error');
                }
            });
        } else {
            $('#editorDetails').addClass('hidden');
        }

        // Don't reset reviewers - they're already loaded from journal selection
        // Reviewers will be reloaded if journal changes
    });

    // Load reviewers button click - works with journal or editor
    $('#loadReviewersBtn').click(function() {
        const journalId = $('select[id="journal_id"]').val();
        const editorId = $('#editor_id').val();

        if (!journalId && !editorId) {
            showMessage('Please select a journal or editor first', 'error');
            return;
        }

        $(this).prop('disabled', true).html('<i data-lucide="loader-2" class="w-3 h-3 mr-1 animate-spin"></i>Loading...');
        lucide.createIcons();

        // Prioritize journal selection, fallback to editor's journal
        if (journalId) {
            loadReviewersByJournal(journalId);
            $(this).prop('disabled', false).html('<i data-lucide="refresh-cw" class="w-3 h-3 mr-1"></i>Reload Reviewers');
            lucide.createIcons();
        } else if (editorId) {
            // Load reviewers for selected editor
            $.ajax({
                url: `{{ url('admin/previous-articles/editors') }}/${editorId}/reviewers`,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    displayReviewers(data.reviewers);
                    $('#reviewersContainer').removeClass('hidden');
                },
                error: function() {
                    showMessage('Error loading reviewers', 'error');
                },
                complete: function() {
                    $('#loadReviewersBtn').prop('disabled', false).html('<i data-lucide="refresh-cw" class="w-3 h-3 mr-1"></i>Reload Reviewers');
                    lucide.createIcons();
                }
            });
        }
    });

    // Display reviewers
    function displayReviewers(reviewers) {
        const container = $('#reviewersContainer');
        // Remove existing reviewers grid, loading messages, and error messages, but keep the header
        container.find('.reviewers-grid, .loading-message, div:contains("No reviewers"), div:contains("Error")').remove();

        if (reviewers.length === 0) {
            container.append(`
                <div class="text-center py-2">
                    <i data-lucide="user-x" class="w-4 h-4 text-gray-400 mx-auto mb-1 inline"></i>
                    <p class="text-xs text-gray-600 inline ml-1">No reviewers found</p>
                </div>
            `);
            lucide.createIcons();
            return;
        }

        // Create a grid container for reviewers
        let reviewersGrid = $('<div class="reviewers-grid grid grid-cols-1 md:grid-cols-2 gap-2 mt-2"></div>');
        
        reviewers.forEach(function(reviewer) {
            const reviewerCard = $('#reviewerTemplate .reviewer-card').clone();

            reviewerCard.find('.reviewer-checkbox').attr('data-reviewer-id', reviewer.id)
                .attr('name', `reviewers[${reviewer.id}][id]`)
                .attr('value', reviewer.id);
            reviewerCard.find('.reviewer-name').text(reviewer.name);
            reviewerCard.find('.reviewer-email').text(reviewer.email);
            reviewerCard.find('.reviewer-expertise').text(reviewer.expertise || 'General');
            reviewerCard.find('.reviewer-specialization').text(reviewer.specialization || 'General');
            reviewerCard.find('.reviewer-rating').attr('name', `reviewers[${reviewer.id}][rating]`);
            reviewerCard.find('.reviewer-comments').attr('name', `reviewers[${reviewer.id}][comments]`);

            reviewersGrid.append(reviewerCard);
        });
        
        container.append(reviewersGrid);
        lucide.createIcons();
    }

    // Reviewer checkbox change handler
    $(document).on('change', '.reviewer-checkbox', function() {
        const card = $(this).closest('.reviewer-card');
        const isChecked = $(this).is(':checked');

        if (isChecked) {
            card.find('.reviewer-rating-section, .reviewer-comments-section').removeClass('hidden');
            card.addClass('ring-2 ring-blue-200 bg-blue-50');
        } else {
            card.find('.reviewer-rating-section, .reviewer-comments-section').addClass('hidden');
            card.removeClass('ring-2 ring-blue-200 bg-blue-50');
            // Clear rating and comments when unchecked
            card.find('.reviewer-rating').val('');
            card.find('.reviewer-comments').val('');
        }
    });

    // Form submission
    // Multi-step form navigation - Make globally accessible
    window.nextStep = function(currentStep) {
        const currentContent = $(`#step${currentStep}-content`);
        const nextContent = $(`#step${currentStep + 1}-content`);
        const currentIndicator = $(`#step${currentStep}`);
        const nextIndicator = $(`#step${currentStep + 1}`);

        // Check if next step exists
        if (nextContent.length === 0) {
            showMessage('No more steps available', 'error');
            return;
        }

        // Validate current step
        if (!validateStep(currentStep)) {
            return;
        }

        // Hide current step
        currentContent.addClass('hidden');
        
        // Update current indicator
        currentIndicator.removeClass('active bg-gradient-to-r from-blue-500 to-blue-600 text-white')
            .addClass('bg-gray-300 text-gray-600');

        // Show next step
        nextContent.removeClass('hidden');
        
        // Update next indicator
        nextIndicator.removeClass('bg-gray-300 text-gray-600')
            .addClass('active bg-gradient-to-r from-blue-500 to-blue-600 text-white');

        // Scroll to top of form
        $('html, body').animate({
            scrollTop: $('.bg-white.rounded-2xl.shadow-2xl').offset().top - 100
        }, 300);

        // Update progress
        updateProgress();
        
        // Reinitialize icons
        lucide.createIcons();
    };

    window.prevStep = function(currentStep) {
        const currentContent = $(`#step${currentStep}-content`);
        const prevContent = $(`#step${currentStep - 1}-content`);
        const currentIndicator = $(`#step${currentStep}`);
        const prevIndicator = $(`#step${currentStep - 1}`);

        // Check if previous step exists
        if (prevContent.length === 0) {
            return;
        }

        // Hide current step
        currentContent.addClass('hidden');
        
        // Update current indicator
        currentIndicator.removeClass('active bg-gradient-to-r from-blue-500 to-blue-600 text-white')
            .addClass('bg-gray-300 text-gray-600');

        // Show previous step
        prevContent.removeClass('hidden');
        
        // Update previous indicator
        prevIndicator.removeClass('bg-gray-300 text-gray-600')
            .addClass('active bg-gradient-to-r from-blue-500 to-blue-600 text-white');

        // Scroll to top of form
        $('html, body').animate({
            scrollTop: $('.bg-white.rounded-2xl.shadow-2xl').offset().top - 100
        }, 300);

        // Update progress
        updateProgress();
        
        // Reinitialize icons
        lucide.createIcons();
    };

    function validateStep(step) {
        let isValid = true;

        switch(step) {
            case 1:
                // Validate personal information
                const requiredFields = ['author_name', 'username', 'author_email', 'password', 'password_confirmation'];
                requiredFields.forEach(field => {
                    if (!$('#' + field).val().trim()) {
                        showFieldError(field, 'This field is required');
                        isValid = false;
                    }
                });

                // Validate password confirmation
                if ($('#password').val() !== $('#password_confirmation').val()) {
                    showFieldError('password_confirmation', 'Passwords do not match');
                    isValid = false;
                }
                break;
            case 2:
                // Validate basic information
                if (!$('#title').val().trim() || !$('#journal_id').val() || !$('#category_id').val() || !$('#manuscript_type').val()) {
                    showMessage('Please fill in all required fields in Basic Information', 'error');
                    isValid = false;
                }
                break;
            case 3:
                // Validate abstract and content
                if (!$('#abstract').val().trim() || !$('#word_count').val()) {
                    showMessage('Please fill in all required fields in Abstract & Content Details', 'error');
                    isValid = false;
                }
                break;
            case 4:
                // Validate manuscript file
                if (!$('#manuscript_file')[0].files[0]) {
                    showMessage('Please upload a manuscript file', 'error');
                    isValid = false;
                }
                break;
            case 6:
                // Validate confirmations
                if (!$('#confirm_not_published').is(':checked') || !$('#confirm_guidelines').is(':checked')) {
                    showMessage('Please accept all confirmation statements', 'error');
                    isValid = false;
                }
                break;
        }

        return isValid;
    }

    function showFieldError(fieldId, message) {
        const field = $('#' + fieldId);
        field.addClass('border-red-500 focus:ring-red-500');
        if (!field.next('.field-error').length) {
            field.after(`<p class="field-error text-red-500 text-xs mt-1">${message}</p>`);
        }
    }

    function updateProgress() {
        // Update step indicators based on current active step
        $('.step-indicator').each(function(index) {
            const stepNumber = index + 1;
            if ($(this).hasClass('active')) {
                $(this).removeClass('bg-gray-300 text-gray-600')
                    .addClass('bg-gradient-to-r from-blue-500 to-blue-600 text-white');
            } else {
                $(this).removeClass('bg-gradient-to-r from-blue-500 to-blue-600 text-white')
                    .addClass('bg-gray-300 text-gray-600');
            }
        });
    }

    // Password strength checker
    $('#password').on('input', function() {
        const password = $(this).val();
        const strength = checkPasswordStrength(password);
        updatePasswordStrength(strength);
    });

    function checkPasswordStrength(password) {
        let score = 0;
        if (password.length >= 8) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        return score;
    }

    function updatePasswordStrength(score) {
        const strengthBar = $('#password-strength-bar');
        const strengthText = $('#password-strength');

        const strengths = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
        const colors = ['bg-red-500', 'bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
        const widths = ['20%', '40%', '60%', '80%', '100%'];

        strengthText.text(strengths[Math.min(score, 4)] || 'Very Weak');
        strengthBar.removeClass('bg-red-500 bg-yellow-500 bg-blue-500 bg-green-500')
                   .addClass(colors[Math.min(score, 4)])
                   .css('width', widths[Math.min(score, 4)]);
    }

    // File upload handling
    $('#manuscript_file').change(function() {
        const file = this.files[0];
        if (file) {
            const fileName = file.name;
            const fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';

            $('#file-name').text(fileName);
            $('#file-size').text('(' + fileSize + ')');
            $('#file-info').removeClass('hidden');
        } else {
            $('#file-info').addClass('hidden');
        }
    });

    // Password toggle
    function togglePassword(fieldId) {
        const field = $('#' + fieldId);
        const icon = field.next('.absolute').find('i');

        if (field.attr('type') === 'password') {
            field.attr('type', 'text');
            icon.attr('data-lucide', 'eye-off');
        } else {
            field.attr('type', 'password');
            icon.attr('data-lucide', 'eye');
        }
        lucide.createIcons();
    }


    // Abstract character counter
    $('#abstract').on('input', function() {
        const count = $(this).val().length;
        $('#abstract-count').text(count);
        if (count > 5000) {
            $('#abstract-count').removeClass('text-purple-600').addClass('text-red-600');
        } else {
            $('#abstract-count').removeClass('text-red-600').addClass('text-purple-600');
        }
    });

    // Update manuscript type display
    $('#manuscript_type').change(function() {
        const selectedText = $(this).find('option:selected').text();
        $('#manuscript-type-display').text(selectedText);
    });

    // File upload handling
    $('#manuscript_file').change(function() {
        const file = this.files[0];
        if (file) {
            const fileName = file.name;
            const fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';

            $('#file-name-display').text(fileName);
            $('#file-size-display').text('Size: ' + fileSize);
            $('#file-info').removeClass('hidden');
        } else {
            clearFile();
        }
    });

    function clearFile() {
        $('#manuscript_file').val('');
        $('#file-info').addClass('hidden');
    }

    window.clearFile = clearFile;

    // Form submission
    $(document).on('submit', '#articleSubmissionForm', function(e) {
        e.preventDefault();

        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();

        console.log('Form submission started');
        
        // Basic validation - check required fields
        let isValid = true;
        let firstErrorField = null;

        // Check if using existing author
        const useExistingAuthor = $('#use_existing_author').val() == '1';
        const existingAuthorId = $('#existing_author_id').val();

        // Check required text fields
        const requiredFields = ['#author_name', '#author_email', '#title', '#journal_id', '#category_id', '#manuscript_type', '#abstract', '#word_count'];
        requiredFields.forEach(function(selector) {
            const $field = $(selector);
            if (!$field.val() || $field.val().trim() === '') {
                isValid = false;
                if (!firstErrorField) firstErrorField = $field;
                console.log('Missing field:', selector);
            }
        });

        // Username and password are only required for new authors
        if (!useExistingAuthor || !existingAuthorId) {
            if (!$('#username').val() || $('#username').val().trim() === '') {
                isValid = false;
                if (!firstErrorField) firstErrorField = $('#username');
                console.log('Missing username');
            }
            if (!$('#password').val() || $('#password').val().trim() === '') {
                isValid = false;
                if (!firstErrorField) firstErrorField = $('#password');
                console.log('Missing password');
            }
        }

        // Check file upload
        if (!$('#manuscript_file')[0].files || !$('#manuscript_file')[0].files[0]) {
            isValid = false;
            if (!firstErrorField) firstErrorField = $('#manuscript_file');
            console.log('Missing manuscript file');
        }

        // Check radio buttons and checkboxes
        if (!$('input[name="previously_submitted"]:checked').length) isValid = false;
        if (!$('input[name="funded_by_outside_source"]:checked').length) isValid = false;
        if (!$('input[name="confirm_not_published_elsewhere"]:checked').length) isValid = false;
        if (!$('input[name="confirm_prepared_as_per_guidelines"]:checked').length) isValid = false;

        if (!isValid) {
            console.log('Validation failed');
            if (firstErrorField) {
                $('html, body').animate({ scrollTop: firstErrorField.offset().top - 100 }, 500);
            }
            showMessage('Please fill in all required fields', 'error');
            return false;
        }

        console.log('Validation passed, submitting...');

        // Disable submit button
        submitBtn.prop('disabled', true).html('<i data-lucide="loader-2" class="w-5 h-5 mr-2 animate-spin"></i>Submitting Article...');
        lucide.createIcons();

        // Submit form
        const formData = new FormData(this);
        
        // Debug: Log form data
        console.log('Form submission data:');
        console.log('use_existing_author:', $('#use_existing_author').val());
        console.log('existing_author_id:', $('#existing_author_id').val());
        console.log('author_email:', $('#author_email').val());
        console.log('author_name:', $('#author_name').val());
        
        console.log('Submitting to:', '{{ route("admin.previous-articles.store") }}');

        $.ajax({
            url: '{{ route("admin.previous-articles.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Success response:', response);
                if (response && response.success) {
                    // Show success message
                    showMessage(response.message || 'Article submitted successfully!', 'success');

                    // Redirect to previous-articles page after short delay
                    if (response.redirect) {
                        setTimeout(function() {
                            // Add success message to URL as query parameter for display after redirect
                            const redirectUrl = response.redirect + '?success=' + encodeURIComponent(response.message);
                            window.location.href = redirectUrl;
                        }, 1500);
                    } else {
                        // Fallback: Reset form if no redirect URL
                        setTimeout(function() {
                            $('#articleSubmissionForm')[0].reset();
                            $('html, body').animate({
                                scrollTop: 0
                            }, 300);
                        }, 2000);
                    }
                } else {
                    showMessage('An error occurred while submitting', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response:', xhr.responseText);
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    let errorMessage = 'Validation errors:\n';
                    Object.keys(errors).forEach(function(field) {
                        errorMessage += `${field}: ${errors[field][0]}\n`;
                    });
                    showMessage(errorMessage, 'error');
                } else {
                    const errorMsg = xhr.responseJSON?.message || xhr.responseText || 'An error occurred while submitting';
                    showMessage(errorMsg, 'error');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i data-lucide="send" class="w-5 h-5 mr-2"></i>Submit Article');
                lucide.createIcons();
            }
        });
        
        return false;
    });

    window.showStep = function(stepNumber) {
        // Scroll to the specified step section
        const stepContent = $(`#step${stepNumber}-content`);
        if (stepContent.length) {
            $('html, body').animate({
                scrollTop: stepContent.offset().top - 100
            }, 500);
        }
        
        // Reinitialize icons
        lucide.createIcons();
    };

    // Message display function
    function showMessage(message, type) {
        const container = $('#messageContainer');
        const icon = $('#messageIcon');
        const text = $('#messageText');

        text.text(message);

        if (type === 'success') {
            container.removeClass('hidden').addClass('border-green-200 bg-green-50');
            icon.html('<i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>');
            text.removeClass('text-red-800').addClass('text-green-800');
        } else {
            container.removeClass('hidden').addClass('border-red-200 bg-red-50');
            icon.html('<i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>');
            text.removeClass('text-green-800').addClass('text-red-800');
        }

        lucide.createIcons();

        // Auto hide after 5 seconds
        setTimeout(function() {
            container.addClass('hidden');
        }, 5000);
    }

    // Close message manually
    $('#closeMessage').click(function() {
        $('#messageContainer').addClass('hidden');
    });
});
</script>

@endsection
