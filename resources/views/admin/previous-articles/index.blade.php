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

        <!-- Progress Steps -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-6 mb-8">
        <div class="text-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Submission Progress</h2>
            <p class="text-gray-600 text-sm">Complete all steps to submit your article</p>
        </div>
        <div class="flex items-center justify-center">
            <div class="flex items-center space-x-4 md:space-x-6 lg:space-x-8">
                <div class="flex flex-col items-center space-y-2">
                    <div id="step1" class="flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white text-lg font-bold step-indicator active shadow-lg">
                        <i data-lucide="user-plus" class="w-5 h-5 md:w-6 md:h-6"></i>
                    </div>
                    <span class="text-xs md:text-sm font-semibold text-gray-800 text-center">Personal Info</span>
                </div>
                <div class="hidden md:block w-8 h-0.5 bg-gray-300"></div>
                <div class="md:hidden w-4 h-0.5 bg-gray-300"></div>

                <div class="flex flex-col items-center space-y-2">
                    <div id="step2" class="flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-300 text-gray-600 text-lg font-bold step-indicator shadow-md">
                        <i data-lucide="file-text" class="w-5 h-5 md:w-6 md:h-6"></i>
                    </div>
                    <span class="text-xs md:text-sm font-medium text-gray-600 text-center">Article Details</span>
                </div>
                <div class="hidden md:block w-8 h-0.5 bg-gray-300"></div>
                <div class="md:hidden w-4 h-0.5 bg-gray-300"></div>

                <div class="flex flex-col items-center space-y-2">
                    <div id="step3" class="flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-300 text-gray-600 text-lg font-bold step-indicator shadow-md">
                        <i data-lucide="edit-3" class="w-5 h-5 md:w-6 md:h-6"></i>
                    </div>
                    <span class="text-xs md:text-sm font-medium text-gray-600 text-center">Abstract</span>
                </div>
                <div class="hidden md:block w-8 h-0.5 bg-gray-300"></div>
                <div class="md:hidden w-4 h-0.5 bg-gray-300"></div>

                <div class="flex flex-col items-center space-y-2">
                    <div id="step4" class="flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-300 text-gray-600 text-lg font-bold step-indicator shadow-md">
                        <i data-lucide="upload" class="w-5 h-5 md:w-6 md:h-6"></i>
                    </div>
                    <span class="text-xs md:text-sm font-medium text-gray-600 text-center">Upload</span>
                </div>
                <div class="hidden md:block w-8 h-0.5 bg-gray-300"></div>
                <div class="md:hidden w-4 h-0.5 bg-gray-300"></div>

                <div class="flex flex-col items-center space-y-2">
                    <div id="step5" class="flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-300 text-gray-600 text-lg font-bold step-indicator shadow-md">
                        <i data-lucide="tag" class="w-5 h-5 md:w-6 md:h-6"></i>
                    </div>
                    <span class="text-xs md:text-sm font-medium text-gray-600 text-center">Keywords</span>
                </div>
                <div class="hidden md:block w-8 h-0.5 bg-gray-300"></div>
                <div class="md:hidden w-4 h-0.5 bg-gray-300"></div>

                <div class="flex flex-col items-center space-y-2">
                    <div id="step6" class="flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-300 text-gray-600 text-lg font-bold step-indicator shadow-md">
                        <i data-lucide="send" class="w-5 h-5 md:w-6 md:h-6"></i>
                    </div>
                    <span class="text-xs md:text-sm font-medium text-gray-600 text-center">Submit</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
        <form id="articleSubmissionForm" enctype="multipart/form-data">
            @csrf

            <!-- Form Content -->
            <div class="p-8">
                <!-- Personal Information Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                            <i data-lucide="user" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Personal Information</h3>
                            <p class="text-gray-600">Create your author account</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="author_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="author_name" name="author_name"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="Dr. John Smith" required>
                        </div>

                        <div>
                            <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="username" name="username"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="johnsmith" required>
                        </div>

                        <div>
                            <label for="author_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="author_email" name="author_email"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="name@example.com" required>
                        </div>

                        <div>
                            <label for="affiliation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Affiliation
                            </label>
                            <input type="text" id="affiliation" name="affiliation"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="University of California">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" required>
                                <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" onclick="togglePassword('password')">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" required>
                        </div>
                    </div>
                </div>

                <!-- Article Information Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                            <i data-lucide="file-text" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Article Information</h3>
                            <p class="text-gray-600">Basic details about your research article</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                                Article Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Enter the full title of your article" required>
                        </div>

                        <div>
                            <label for="journal_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Target Journal <span class="text-red-500">*</span>
                            </label>
                            <select id="journal_id" name="journal_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" required>
                                <option value="">Select a journal...</option>
                                @foreach($journals as $journal)
                                <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select id="category_id" name="category_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" required>
                                <option value="">Select a category...</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- File Upload Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                            <i data-lucide="upload" class="w-6 h-6 text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Manuscript Upload</h3>
                            <p class="text-gray-600">Upload your research manuscript</p>
                        </div>
                    </div>

                    <div>
                        <label for="manuscript_file" class="block text-sm font-semibold text-gray-700 mb-2">
                            Manuscript File <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-orange-400 transition-colors">
                            <i data-lucide="upload-cloud" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                            <div class="text-lg font-semibold text-gray-700 mb-2">
                                <label for="manuscript_file" class="cursor-pointer text-orange-600 hover:text-orange-700">
                                    Click to upload
                                </label>
                                <span class="text-gray-500">or drag and drop</span>
                            </div>
                            <p class="text-sm text-gray-500">PDF, DOC, DOCX files up to 10MB</p>
                            <input id="manuscript_file" name="manuscript_file" type="file" class="hidden" accept=".pdf,.doc,.docx" required>
                        </div>
                        <div id="file-info" class="mt-4 hidden">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center space-x-3">
                                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                                    <div>
                                        <div class="font-semibold text-green-800" id="file-name-display">File uploaded successfully</div>
                                        <div class="text-sm text-green-600" id="file-size-display">File size information</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-6 border-t border-gray-200">
                    <button type="submit" id="submitBtn"
                            class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i data-lucide="send" class="w-5 h-5 mr-2"></i>
                        Create Author & Submit Article
                    </button>
                </div>
            </div>
        </form>
    </div>

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
<script>
$(document).ready(function() {
    // Initialize Lucide icons
    lucide.createIcons();

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

    // Make togglePassword globally available
    window.togglePassword = togglePassword;

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
            $('#file-info').addClass('hidden');
        }
    });

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

    // Form submission
    $('#articleSubmissionForm').submit(function(e) {
        e.preventDefault();

        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();

        // Disable submit button
        submitBtn.prop('disabled', true).html('<i data-lucide="loader-2" class="w-5 h-5 mr-2 animate-spin"></i>Processing...');
        lucide.createIcons();

        // Submit form
        const formData = new FormData(this);

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
                if (response.success) {
                    showMessage(response.message, 'success');

                    // Reset form after delay
                    setTimeout(function() {
                        $('#articleSubmissionForm')[0].reset();
                        $('#file-info').addClass('hidden');
                    }, 2000);
                } else {
                    showMessage('An error occurred while submitting', 'error');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    let errorMessage = 'Validation errors:\n';
                    Object.keys(errors).forEach(function(field) {
                        errorMessage += `- ${errors[field][0]}\n`;
                    });
                    showMessage(errorMessage, 'error');
                } else {
                    showMessage('An error occurred while submitting', 'error');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i data-lucide="send" class="w-5 h-5 mr-2"></i>Create Author & Submit Article');
                lucide.createIcons();
            }
        });
    });

    // Close message manually
    $('#closeMessage').click(function() {
        $('#messageContainer').addClass('hidden');
    });
});
</script>
                        <label for="author_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" id="author_name" name="author_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Dr. John Smith" required>
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                        <input type="text" id="username" name="username" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="johnsmith" required>
                    </div>

                    <div>
                        <label for="author_email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                        <input type="email" id="author_email" name="author_email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="name@example.com" required>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                            <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" onclick="togglePassword('password')">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-center space-x-2">
                                <div class="text-xs text-gray-600">Password Strength:</div>
                                <div id="password-strength" class="text-xs font-medium text-red-500">Weak</div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div id="password-strength-bar" class="bg-red-500 h-1 rounded-full transition-all duration-300" style="width: 20%"></div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                    </div>

                    <div>
                        <label for="affiliation" class="block text-sm font-medium text-gray-700 mb-2">Affiliation</label>
                        <input type="text" id="affiliation" name="affiliation" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="University of California">
                    </div>

                    <div>
                        <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">Specialization</label>
                        <input type="text" id="specialization" name="specialization" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="e.g., Molecular Biology">
                    </div>

                    <div class="md:col-span-2">
                        <label for="orcid_id" class="block text-sm font-medium text-gray-700 mb-2">ORCID ID</label>
                        <input type="text" id="orcid_id" name="orcid_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="https://orcid.org/0000-0000-0000-0000">
                    </div>

                    <div class="md:col-span-2">
                        <label for="author_contributions" class="block text-sm font-medium text-gray-700 mb-2">Author Contributions</label>
                        <textarea id="author_contributions" name="author_contributions" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Describe your specific contributions to research (optional)..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="button" onclick="nextStep(1)" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                        Next: Basic Information <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 2: Basic Information -->
        <div id="step2-content" class="step-content hidden">
            <div class="bg-white border-2 border-green-100 rounded-2xl shadow-xl overflow-hidden">
                <!-- Step Header -->
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6 text-white">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i data-lucide="file-text" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Article Details</h2>
                            <p class="text-green-100 text-sm mt-1">Provide information about your research article</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <div class="space-y-8">
                        <!-- Article Title -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                                    <i data-lucide="file-text" class="w-5 h-5 text-green-600"></i>
                                </div>
                                Article Information
                            </h3>

                            <div class="space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">
                                        Article Title <span class="text-red-500 text-lg">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="title" name="title"
                                               class="w-full px-4 py-4 pl-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 bg-white shadow-sm hover:border-green-300"
                                               placeholder="Enter the complete title of your research article" required>
                                        <div class="absolute left-4 top-4.5 text-gray-400">
                                            <i data-lucide="file-text" class="w-5 h-5"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Use title case and be specific about your research topic</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="journal_id" class="block text-sm font-semibold text-gray-800 mb-2">
                                            Target Journal <span class="text-red-500 text-lg">*</span>
                                        </label>
                                        <div class="relative">
                                            <select id="journal_id" name="journal_id"
                                                    class="w-full px-4 py-4 pl-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 bg-white shadow-sm hover:border-green-300 appearance-none" required>
                                                <option value="">Select a journal...</option>
                                                @foreach($journals as $journal)
                                                <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="absolute left-4 top-4.5 text-gray-400">
                                                <i data-lucide="book-open" class="w-5 h-5"></i>
                                            </div>
                                            <div class="absolute right-4 top-4.5 text-gray-400 pointer-events-none">
                                                <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="category_id" class="block text-sm font-semibold text-gray-800 mb-2">
                                            Article Category <span class="text-red-500 text-lg">*</span>
                                        </label>
                                        <div class="relative">
                                            <select id="category_id" name="category_id"
                                                    class="w-full px-4 py-4 pl-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 bg-white shadow-sm hover:border-green-300 appearance-none" required>
                                                <option value="">Select a category...</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="absolute left-4 top-4.5 text-gray-400">
                                                <i data-lucide="folder" class="w-5 h-5"></i>
                                            </div>
                                            <div class="absolute right-4 top-4.5 text-gray-400 pointer-events-none">
                                                <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="manuscript_type" class="block text-sm font-semibold text-gray-800 mb-2">
                                        Manuscript Type <span class="text-red-500 text-lg">*</span>
                                    </label>
                                    <div class="relative">
                                        <select id="manuscript_type" name="manuscript_type"
                                                class="w-full px-4 py-4 pl-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 bg-white shadow-sm hover:border-green-300 appearance-none" required>
                                            <option value="">Select manuscript type...</option>
                                            <option value="Research Article">Research Article</option>
                                            <option value="Review Article">Review Article</option>
                                            <option value="Case Study">Case Study</option>
                                            <option value="Short Communication">Short Communication</option>
                                            <option value="Letter to Editor">Letter to Editor</option>
                                        </select>
                                        <div class="absolute left-4 top-4.5 text-gray-400">
                                            <i data-lucide="edit-3" class="w-5 h-5"></i>
                                        </div>
                                        <div class="absolute right-4 top-4.5 text-gray-400 pointer-events-none">
                                            <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                        </div>
                                    </div>
                                    <div class="mt-2 bg-blue-50 border border-blue-200 rounded-lg p-3">
                                        <div class="text-xs text-blue-800">
                                            <div class="font-semibold mb-1">Manuscript Type Guidelines:</div>
                                            <ul class="space-y-1">
                                                <li><strong>Research Article:</strong> Original research with full methodology</li>
                                                <li><strong>Review Article:</strong> Comprehensive analysis of existing research</li>
                                                <li><strong>Case Study:</strong> Detailed analysis of specific cases</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                        <button type="button" onclick="prevStep(2)"
                                class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                            <span>Back to Personal Info</span>
                        </button>
                        <button type="button" onclick="nextStep(2)"
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                            <span>Continue to Abstract</span>
                            <i data-lucide="arrow-right" class="w-6 h-6 ml-3"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Abstract and Content Details -->
        <div id="step3-content" class="step-content hidden">
            <div class="bg-white border-2 border-purple-100 rounded-2xl shadow-xl overflow-hidden">
                <!-- Step Header -->
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6 text-white">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i data-lucide="edit-3" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Abstract & Content Details</h2>
                            <p class="text-purple-100 text-sm mt-1">Provide detailed information about your manuscript</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <div class="space-y-8">
                        <!-- Abstract Section -->
                        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-6 border border-purple-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                                    <i data-lucide="file-text" class="w-5 h-5 text-purple-600"></i>
                                </div>
                                Abstract
                            </h3>

                            <div>
                                <label for="abstract" class="block text-sm font-semibold text-gray-800 mb-2">
                                    Abstract <span class="text-red-500 text-lg">*</span>
                                    <span class="text-xs text-gray-500">(Maximum 5000 characters)</span>
                                </label>
                                <textarea id="abstract" name="abstract" rows="8"
                                          class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 bg-white shadow-sm hover:border-purple-300 resize-none"
                                          placeholder="Provide a concise summary of your research including objectives, methods, results, and conclusions..." required></textarea>
                                <div class="mt-2 flex justify-between items-center">
                                    <div class="text-xs text-gray-600 bg-gray-50 rounded-lg px-3 py-2">
                                        <span class="font-medium">Character count:</span>
                                        <span id="abstract-count" class="font-bold text-purple-600">0</span>/5000
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Include: Background, Methods, Results, Conclusion
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Manuscript Details -->
                        <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl p-6 border border-orange-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mr-3">
                                    <i data-lucide="bar-chart-3" class="w-5 h-5 text-orange-600"></i>
                                </div>
                                Manuscript Specifications
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <label for="word_count" class="block text-sm font-semibold text-gray-800 mb-2">
                                        Word Count <span class="text-red-500 text-lg">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="word_count" name="word_count"
                                               class="w-full px-4 py-4 pl-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 bg-white shadow-sm hover:border-orange-300"
                                               placeholder="5000" min="100" max="50000" required>
                                        <div class="absolute left-4 top-4.5 text-gray-400">
                                            <i data-lucide="type" class="w-5 h-5"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Main body word count</p>
                                </div>

                                <div>
                                    <label for="number_of_tables" class="block text-sm font-semibold text-gray-800 mb-2">
                                        Number of Tables
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="number_of_tables" name="number_of_tables"
                                               class="w-full px-4 py-4 pl-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 bg-white shadow-sm hover:border-orange-300"
                                               placeholder="0" min="0">
                                        <div class="absolute left-4 top-4.5 text-gray-400">
                                            <i data-lucide="table" class="w-5 h-5"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="number_of_figures" class="block text-sm font-semibold text-gray-800 mb-2">
                                        Number of Figures
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="number_of_figures" name="number_of_figures"
                                               class="w-full px-4 py-4 pl-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 bg-white shadow-sm hover:border-orange-300"
                                               placeholder="0" min="0">
                                        <div class="absolute left-4 top-4.5 text-gray-400">
                                            <i data-lucide="image" class="w-5 h-5"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                                        Manuscript Type
                                    </label>
                                    <div class="bg-white border-2 border-gray-200 rounded-xl px-4 py-4 text-sm text-gray-600">
                                        <i data-lucide="file-text" class="w-4 h-4 inline mr-2"></i>
                                        <span id="manuscript-type-display">Not selected</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                        <button type="button" onclick="prevStep(3)"
                                class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                            <span>Back to Article Details</span>
                        </button>
                        <button type="button" onclick="nextStep(3)"
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                            <span>Continue to Upload</span>
                            <i data-lucide="arrow-right" class="w-6 h-6 ml-3"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Manuscript File -->
        <div id="step4-content" class="step-content hidden">
            <div class="bg-white border-2 border-orange-100 rounded-2xl shadow-xl overflow-hidden">
                <!-- Step Header -->
                <div class="bg-gradient-to-r from-orange-600 to-red-600 px-8 py-6 text-white">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i data-lucide="upload" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Upload Manuscript</h2>
                            <p class="text-orange-100 text-sm mt-1">Submit your research manuscript file</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-8 border border-orange-100">
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="upload-cloud" class="w-10 h-10 text-orange-600"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Upload Your Manuscript</h3>
                            <p class="text-gray-600">Submit your complete research manuscript for review</p>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="manuscript_file" class="block text-sm font-semibold text-gray-800 mb-4 text-center">
                                    Manuscript File <span class="text-red-500 text-lg">*</span>
                                </label>
                                <div class="border-4 border-dashed border-gray-300 rounded-2xl p-8 hover:border-orange-400 transition-all duration-300 bg-gray-50 hover:bg-orange-50/50">
                                    <div class="text-center">
                                        <i data-lucide="file-text" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                                        <div class="space-y-2">
                                            <div class="text-lg font-semibold text-gray-700">
                                                <label for="manuscript_file" class="cursor-pointer text-orange-600 hover:text-orange-700 underline">
                                                    Click to upload
                                                </label>
                                                <span class="text-gray-500">or drag and drop</span>
                                            </div>
                                            <p class="text-sm text-gray-500">PDF, DOC, DOCX files up to 10MB</p>
                                        </div>
                                        <input id="manuscript_file" name="manuscript_file" type="file"
                                               class="hidden" accept=".pdf,.doc,.docx" required>
                                    </div>
                                </div>
                                <div id="file-info" class="mt-4 hidden">
                                    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-semibold text-green-800" id="file-name-display"></div>
                                                <div class="text-sm text-green-600" id="file-size-display"></div>
                                            </div>
                                            <button type="button" onclick="clearFile()"
                                                    class="text-red-500 hover:text-red-700 p-1">
                                                <i data-lucide="x" class="w-5 h-5"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                <div class="flex items-start space-x-3">
                                    <i data-lucide="info" class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0"></i>
                                    <div>
                                        <h4 class="font-semibold text-blue-800 mb-2">File Requirements:</h4>
                                        <ul class="text-sm text-blue-700 space-y-1">
                                            <li>• Accepted formats: PDF, Microsoft Word (.doc, .docx)</li>
                                            <li>• Maximum file size: 10MB</li>
                                            <li>• File must contain complete manuscript with all figures and tables</li>
                                            <li>• Ensure all fonts are embedded in PDF files</li>
                                            <li>• Remove any identifying information for blind review</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                        <button type="button" onclick="prevStep(4)"
                                class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                            <span>Back to Abstract</span>
                        </button>
                        <button type="button" onclick="nextStep(4)"
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold rounded-xl hover:from-orange-700 hover:to-red-700 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                            <span>Continue to Keywords</span>
                            <i data-lucide="arrow-right" class="w-6 h-6 ml-3"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5: Keywords -->
        <div id="step5-content" class="step-content hidden">
            <div class="bg-white border-2 border-teal-100 rounded-2xl shadow-xl overflow-hidden">
                <!-- Step Header -->
                <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-8 py-6 text-white">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i data-lucide="tag" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Keywords & Tags</h2>
                            <p class="text-teal-100 text-sm mt-1">Add relevant keywords to help readers find your article</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <div class="space-y-8">
                        <!-- Existing Keywords -->
                        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl p-6 border border-teal-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center mr-3">
                                    <i data-lucide="search" class="w-5 h-5 text-teal-600"></i>
                                </div>
                                Select Existing Keywords
                            </h3>

                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach($keywords as $keyword)
                                <label class="flex items-center space-x-2 p-4 bg-white border-2 border-gray-200 rounded-xl hover:border-teal-300 hover:bg-teal-50 transition-all duration-200 cursor-pointer group">
                                    <input type="checkbox" name="existing_keywords[]" value="{{ $keyword->id }}"
                                           class="w-4 h-4 text-teal-600 rounded focus:ring-teal-500">
                                    <span class="text-sm text-gray-700 group-hover:text-teal-800">{{ $keyword->keyword }}</span>
                                </label>
                                @endforeach
                            </div>

                            <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <p class="text-xs text-blue-800">
                                    <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                                    Select all keywords that are relevant to your research topic. You can select multiple keywords.
                                </p>
                            </div>
                        </div>

                        <!-- New Keywords -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mr-3">
                                    <i data-lucide="plus" class="w-5 h-5 text-indigo-600"></i>
                                </div>
                                Add New Keywords
                            </h3>

                            <div>
                                <label for="new_keywords" class="block text-sm font-semibold text-gray-800 mb-2">
                                    New Keywords <span class="text-xs text-gray-500">(Optional)</span>
                                </label>
                                <textarea id="new_keywords" name="new_keywords" rows="4"
                                          class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-white shadow-sm hover:border-indigo-300 resize-none"
                                          placeholder="Enter new keywords separated by commas (e.g., Machine Learning, AI, Neural Networks, Data Science)"></textarea>
                                <div class="mt-2 text-xs text-gray-600 bg-gray-50 rounded-lg p-3">
                                    <div class="font-medium mb-1">How to add new keywords:</div>
                                    <ul class="space-y-1">
                                        <li>• Separate multiple keywords with commas</li>
                                        <li>• Use specific, searchable terms</li>
                                        <li>• Include both general and specific terms</li>
                                        <li>• Maximum 10 new keywords recommended</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                        <button type="button" onclick="prevStep(5)"
                                class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                            <span>Back to Upload</span>
                        </button>
                        <button type="button" onclick="nextStep(5)"
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-bold rounded-xl hover:from-teal-700 hover:to-cyan-700 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                            <span>Continue to Submission</span>
                            <i data-lucide="arrow-right" class="w-6 h-6 ml-3"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i data-lucide="file-text" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Basic Information</h3>
                        <p class="text-sm text-gray-600">Article details and journal selection</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Article Title *</label>
                        <input type="text" id="title" name="title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="Enter the full title of your article" required>
                    </div>

                    <div>
                        <label for="journal_id" class="block text-sm font-medium text-gray-700 mb-2">Target Journal *</label>
                        <select id="journal_id" name="journal_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                            <option value="">Select a journal...</option>
                            @foreach($journals as $journal)
                            <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select id="category_id" name="category_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                            <option value="">Select a category...</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="manuscript_type" class="block text-sm font-medium text-gray-700 mb-2">Manuscript Type *</label>
                        <select id="manuscript_type" name="manuscript_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                            <option value="">Select manuscript type...</option>
                            <option value="Research Article">Research Article</option>
                            <option value="Review Article">Review Article</option>
                            <option value="Case Study">Case Study</option>
                            <option value="Short Communication">Short Communication</option>
                            <option value="Letter to Editor">Letter to Editor</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" onclick="prevStep(2)" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 font-medium">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Previous
                    </button>
                    <button type="button" onclick="nextStep(2)" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 font-medium">
                        Next: Abstract & Content <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </button>
                </div>
            </div>
        </div>

<!-- jQuery Scripts -->
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="abstract" class="block text-sm font-medium text-gray-700 mb-2">Abstract *</label>
                        <textarea id="abstract" name="abstract" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="Enter the abstract of your article..." required></textarea>
                        <p class="text-xs text-gray-500 mt-1">Maximum 5000 characters</p>
                    </div>

                    <div>
                        <label for="word_count" class="block text-sm font-medium text-gray-700 mb-2">Word Count *</label>
                        <input type="number" id="word_count" name="word_count" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="5000" min="100" max="50000" required>
                    </div>

                    <div>
                        <label for="number_of_tables" class="block text-sm font-medium text-gray-700 mb-2">Number of Tables</label>
                        <input type="number" id="number_of_tables" name="number_of_tables" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="0" min="0">
                    </div>

                    <div>
                        <label for="number_of_figures" class="block text-sm font-medium text-gray-700 mb-2">Number of Figures</label>
                        <input type="number" id="number_of_figures" name="number_of_figures" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="0" min="0">
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" onclick="prevStep(3)" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 font-medium">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Previous
                    </button>
                    <button type="button" onclick="nextStep(3)" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 font-medium">
                        Next: Manuscript File <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 4: Manuscript File -->
        <div id="step4-content" class="step-content p-6 hidden">
            <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-lg p-6 border border-orange-100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                        <i data-lucide="upload" class="w-6 h-6 text-orange-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Manuscript File</h3>
                        <p class="text-sm text-gray-600">Upload your research manuscript</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="manuscript_file" class="block text-sm font-medium text-gray-700 mb-2">Upload Manuscript File *</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-orange-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <i data-lucide="upload-cloud" class="mx-auto h-12 w-12 text-gray-400"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="manuscript_file" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                        <span>Upload a file</span>
                                        <input id="manuscript_file" name="manuscript_file" type="file" class="sr-only" accept=".pdf,.doc,.docx" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 10MB</p>
                            </div>
                        </div>
                        <div id="file-info" class="mt-2 hidden">
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                <span id="file-name"></span>
                                <span id="file-size"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" onclick="prevStep(4)" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 font-medium">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Previous
                    </button>
                    <button type="button" onclick="nextStep(4)" class="px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors duration-200 font-medium">
                        Next: Keywords <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 5: Keywords -->
        <div id="step5-content" class="step-content p-6 hidden">
            <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg p-6 border border-teal-100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4">
                        <i data-lucide="tag" class="w-6 h-6 text-teal-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Keywords</h3>
                        <p class="text-sm text-gray-600">Select existing keywords or add new ones</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Select Existing Keywords</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @foreach($keywords as $keyword)
                            <label class="flex items-center space-x-2 p-3 bg-white border border-gray-200 rounded-lg hover:border-teal-300 hover:bg-teal-50 transition-all duration-200 cursor-pointer">
                                <input type="checkbox" name="existing_keywords[]" value="{{ $keyword->id }}" class="w-4 h-4 text-teal-600 rounded focus:ring-teal-500">
                                <span class="text-sm text-gray-700">{{ $keyword->keyword }}</span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Select relevant keywords that describe your research</p>
                    </div>

                    <div>
                        <label for="new_keywords" class="block text-sm font-medium text-gray-700 mb-2">Add New Keywords</label>
                        <textarea id="new_keywords" name="new_keywords" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200" placeholder="Enter keywords separated by commas (e.g., Machine Learning, AI, Neural Networks)"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Separate multiple keywords with commas</p>
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" onclick="prevStep(5)" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 font-medium">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Previous
                    </button>
                    <button type="button" onclick="nextStep(5)" class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-200 font-medium">
                        Next: Submission Details <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 6: Submission Details -->
        <div id="step6-content" class="step-content p-6 hidden">
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg p-6 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                        <i data-lucide="check-circle" class="w-6 h-6 text-gray-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Submission Details</h3>
                        <p class="text-sm text-gray-600">Final confirmations and optional reviewer assignment</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Submission History -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Previously Submitted Elsewhere? *</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="previously_submitted" value="1" class="w-4 h-4 text-gray-600 focus:ring-gray-500" required>
                                    <span class="ml-2 text-sm text-gray-700">Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="previously_submitted" value="0" class="w-4 h-4 text-gray-600 focus:ring-gray-500" required checked>
                                    <span class="ml-2 text-sm text-gray-700">No</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Funded by Outside Source? *</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="funded_by_outside_source" value="1" class="w-4 h-4 text-gray-600 focus:ring-gray-500" required>
                                    <span class="ml-2 text-sm text-gray-700">Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="funded_by_outside_source" value="0" class="w-4 h-4 text-gray-600 focus:ring-gray-500" required checked>
                                    <span class="ml-2 text-sm text-gray-700">No</span>
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
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <i data-lucide="info" class="w-5 h-5 text-blue-600 mr-2"></i>
                            <span class="text-sm font-medium text-blue-800">Optional: Assign Editor & Reviewers</span>
                        </div>
                        <p class="text-xs text-blue-600 mb-4">This section is optional. If left blank, the article will be submitted for general review.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="editor_id" class="block text-sm font-medium text-gray-700 mb-2">Assign Editor</label>
                                <select id="editor_id" name="editor_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Choose an editor (optional)...</option>
                                    @foreach($editors as $editor)
                                    <option value="{{ $editor->id }}" data-journal-id="{{ $editor->journal_id }}">
                                        {{ $editor->user->name }} - {{ $editor->journal->name ?? 'No Journal' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="editorDetails" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Editor Details</label>
                                <div class="bg-white p-3 rounded-lg border border-gray-200">
                                    <div class="space-y-1 text-xs">
                                        <div><span class="font-medium">Name:</span> <span id="editorName"></span></div>
                                        <div><span class="font-medium">Email:</span> <span id="editorEmail"></span></div>
                                        <div><span class="font-medium">Journal:</span> <span id="editorJournal"></span></div>
                                        <div><span class="font-medium">Status:</span> <span id="editorStatus"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviewer Assignment Section -->
                        <div class="mt-4">
                            <button type="button" id="loadReviewersBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                Load Reviewers for Selected Editor
                            </button>
                        </div>

                        <div id="reviewersContainer" class="hidden mt-4 space-y-3">
                            <p class="text-xs text-blue-600 mb-3">Select reviewers and provide ratings (optional)</p>
                        </div>

                        <!-- Template for reviewer cards -->
                        <div id="reviewerTemplate" class="hidden">
                            <div class="reviewer-card bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <input type="checkbox" class="reviewer-checkbox w-4 h-4 text-blue-600 rounded focus:ring-blue-500" data-reviewer-id="" name="" value="">
                                            <h5 class="font-medium text-gray-800 reviewer-name"></h5>
                                        </div>
                                        <p class="text-sm text-gray-600 reviewer-email"></p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full reviewer-expertise"></span>
                                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full reviewer-specialization"></span>
                                        </div>
                                    </div>
                                    <div class="reviewer-rating-section hidden ml-4">
                                        <div class="flex items-center space-x-2">
                                            <label class="text-sm font-medium text-gray-700">Rating:</label>
                                            <select class="reviewer-rating w-20 px-2 py-1 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" name="">
                                                <option value="">Rate</option>
                                                <option value="1">1 ★</option>
                                                <option value="2">2 ★★</option>
                                                <option value="3">3 ★★★</option>
                                                <option value="4">4 ★★★★</option>
                                                <option value="5">5 ★★★★★</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="reviewer-comments-section hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Comments</label>
                                    <textarea class="reviewer-comments w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" rows="3" name="" placeholder="Enter your review comments..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" onclick="prevStep(6)" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 font-medium">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Previous
                    </button>
                    <button type="submit" id="submitBtn" class="px-8 py-3 bg-gradient-to-r from-gray-600 to-slate-600 text-white rounded-lg hover:from-gray-700 hover:to-slate-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                        <i data-lucide="send" class="w-5 h-5 mr-2"></i>
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
<script>
$(document).ready(function() {
    // Initialize Lucide icons
    lucide.createIcons();

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

        // Reset reviewers section
        $('#reviewersContainer').addClass('hidden').empty();
    });

    // Load reviewers button click
    $('#loadReviewersBtn').click(function() {
        const editorId = $('#editor_id').val();

        if (!editorId) {
            showMessage('Please select an editor first', 'error');
            return;
        }

        $(this).prop('disabled', true).html('<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i>Loading...');
        lucide.createIcons();

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
                $('#loadReviewersBtn').prop('disabled', false).html('<i data-lucide="users" class="w-5 h-5 mr-2"></i>Load Reviewers for Selected Editor');
                lucide.createIcons();
            }
        });
    });

    // Display reviewers
    function displayReviewers(reviewers) {
        const container = $('#reviewersContainer');
        container.empty();

        if (reviewers.length === 0) {
            container.html(`
                <div class="text-center py-8">
                    <i data-lucide="user-x" class="w-8 h-8 text-gray-400 mx-auto mb-2"></i>
                    <p class="text-gray-600">No reviewers found for this editor's journal</p>
                </div>
            `);
            lucide.createIcons();
            return;
        }

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

            container.append(reviewerCard);
        });

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
    // Multi-step form navigation
    function nextStep(currentStep) {
        const currentContent = $(`#step${currentStep}-content`);
        const nextContent = $(`#step${currentStep + 1}-content`);
        const currentIndicator = $(`#step${currentStep}`);
        const nextIndicator = $(`#step${currentStep + 1}`);

        // Validate current step
        if (!validateStep(currentStep)) {
            return;
        }

        // Hide current step
        currentContent.addClass('hidden');
        currentIndicator.removeClass('active').addClass('bg-gray-300').removeClass('bg-blue-600 text-white');

        // Show next step
        nextContent.removeClass('hidden');
        nextIndicator.addClass('active').removeClass('bg-gray-300').addClass('bg-blue-600 text-white');

        // Update progress
        updateProgress();
    }

    function prevStep(currentStep) {
        const currentContent = $(`#step${currentStep}-content`);
        const prevContent = $(`#step${currentStep - 1}-content`);
        const currentIndicator = $(`#step${currentStep}`);
        const prevIndicator = $(`#step${currentStep - 1}`);

        // Hide current step
        currentContent.addClass('hidden');
        currentIndicator.removeClass('active').addClass('bg-gray-300').removeClass('bg-blue-600 text-white');

        // Show previous step
        prevContent.removeClass('hidden');
        prevIndicator.addClass('active').removeClass('bg-gray-300').addClass('bg-blue-600 text-white');

        // Update progress
        updateProgress();
    }

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
                $(this).removeClass('bg-gray-300').addClass('bg-blue-600 text-white');
            } else {
                $(this).removeClass('bg-blue-600 text-white').addClass('bg-gray-300');
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
    $('#articleSubmissionForm').submit(function(e) {
        e.preventDefault();

        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();

        // Validate all steps
        for (let i = 1; i <= 6; i++) {
            if (!validateStep(i)) {
                // Go to the step that failed validation
                showStep(i);
                return;
            }
        }

        // Disable submit button
        submitBtn.prop('disabled', true).html('<i data-lucide="loader-2" class="w-5 h-5 mr-2 animate-spin"></i>Submitting Article...');
        lucide.createIcons();

        // Submit form
        const formData = new FormData(this);

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
                if (response.success) {
                    showMessage(response.message, 'success');

                    // Reset form after delay
                    setTimeout(function() {
                        $('#articleSubmissionForm')[0].reset();
                        showStep(1); // Go back to first step
                        $('.step-content').addClass('hidden');
                        $('#step1-content').removeClass('hidden');
                        updateProgress();
                    }, 2000);
                } else {
                    showMessage('An error occurred while submitting', 'error');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    let errorMessage = 'Validation errors:\n';
                    Object.keys(errors).forEach(function(field) {
                        errorMessage += `- ${errors[field][0]}\n`;
                    });
                    showMessage(errorMessage, 'error');
                } else {
                    showMessage('An error occurred while submitting', 'error');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i data-lucide="send" class="w-5 h-5 mr-2"></i>Submit Article');
                lucide.createIcons();
            }
        });
    });

    function showStep(stepNumber) {
        $('.step-content').addClass('hidden');
        $(`#step${stepNumber}-content`).removeClass('hidden');

        $('.step-indicator').removeClass('active bg-blue-600 text-white').addClass('bg-gray-300');
        $(`#step${stepNumber}`).addClass('active bg-blue-600 text-white').removeClass('bg-gray-300');

        updateProgress();
    }

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
