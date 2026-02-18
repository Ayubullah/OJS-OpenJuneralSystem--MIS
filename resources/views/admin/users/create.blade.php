@extends('layout.app_admin')

@section('title', __('Create New User'))
@section('page-title', __('Create User'))
@section('page-description', __('Add a new user to the system'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Users') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ __('Create') }}</span>
</li>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mr-4">
                    <i data-lucide="user-plus" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('Create New User') }}</h1>
                    <p class="text-sm text-gray-600">{{ __('Add a new user to your Kardan Journal Operating System') }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-8">
            @csrf

            <!-- Personal Information -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">{{ __('Personal Information') }}</h3>
                
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700">
                        {{ __('Full Name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('name') border-red-300 @enderror"
                           placeholder="{{ __('Enter full name') }}"
                           required>
                    @error('name')
                    <p class="text-sm text-red-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Username -->
                <div class="space-y-2">
                    <label for="username" class="block text-sm font-semibold text-gray-700">
                        {{ __('Username') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           value="{{ old('username') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('username') border-red-300 @enderror"
                           placeholder="{{ __('Enter username') }}"
                           required>
                    @error('username')
                    <p class="text-sm text-red-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-gray-700">
                        {{ __('Email Address') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('email') border-red-300 @enderror"
                           placeholder="{{ __('Enter email address') }}"
                           required>
                    @error('email')
                    <p class="text-sm text-red-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

            </div>

            <!-- Account Settings -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">{{ __('Account Settings') }}</h3>
                
                <!-- Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            {{ __('Password') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('password') border-red-300 @enderror"
                                   placeholder="{{ __('Enter password') }}"
                                   required>
                            <i data-lucide="lock" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                        </div>
                        @error('password')
                        <p class="text-sm text-red-600 flex items-center">
                            <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                            {{ __('Confirm Password') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="{{ __('Confirm password') }}"
                                   required>
                            <i data-lucide="lock" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <!-- Role and Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Role Selection -->
                    <div class="space-y-2">
                        <label for="role" class="block text-sm font-semibold text-gray-700">
                            {{ __('Role') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="role" 
                                    name="role"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('role') border-red-300 @enderror"
                                    required>
                                <option value="">{{ __('Select a role') }}</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>{{ __('Administrator') }}</option>
                                <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>{{ __('Editor') }}</option>
                                <option value="reviewer" {{ old('role') === 'reviewer' ? 'selected' : '' }}>{{ __('Reviewer') }}</option>
                                <option value="author" {{ old('role') === 'author' ? 'selected' : '' }}>{{ __('Author') }}</option>
                            </select>
                            <i data-lucide="shield" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                        </div>
                        @error('role')
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
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('status') border-red-300 @enderror"
                                    required>
                                <option value="">{{ __('Select status') }}</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
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
            </div>

            <!-- Editor Specific Fields -->
            <div id="editor-fields" class="space-y-6 hidden">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">{{ __('Editor Information') }}</h3>

                <!-- Journal Selection -->
                <div class="space-y-2">
                    <label for="journal_id" class="block text-sm font-semibold text-gray-700">
                        {{ __('Journal') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="journal_id"
                                name="journal_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('journal_id') border-red-300 @enderror">
                            <option value="">{{ __('Select a journal') }}</option>
                            @foreach($journals as $journal)
                                <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>
                                    {{ $journal->name }}
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
            </div>

            <!-- Reviewer Specific Fields -->
            <div id="reviewer-fields" class="space-y-6 hidden">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">{{ __('Reviewer Information') }}</h3>

                <!-- Journal Selection -->
                <div class="space-y-2">
                    <label for="reviewer_journal_id" class="block text-sm font-semibold text-gray-700">
                        {{ __('Journal') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="reviewer_journal_id"
                                name="journal_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('journal_id') border-red-300 @enderror">
                            <option value="">{{ __('Select a journal') }}</option>
                            @foreach($journals as $journal)
                                <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>
                                    {{ $journal->name }}
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

                <!-- Reviewer Email -->
                <div class="space-y-2">
                    <label for="reviewer_email" class="block text-sm font-semibold text-gray-700">
                        {{ __('Reviewer Email') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="email"
                               id="reviewer_email"
                               name="reviewer_email"
                               value="{{ old('reviewer_email') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('reviewer_email') border-red-300 @enderror"
                               placeholder="{{ __('Enter reviewer email address') }}">
                        <i data-lucide="mail" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                    </div>
                    @error('reviewer_email')
                    <p class="text-sm text-red-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Expertise and Specialization -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="expertise" class="block text-sm font-semibold text-gray-700">
                            {{ __('Expertise') }}
                        </label>
                        <input type="text"
                               id="expertise"
                               name="expertise"
                               value="{{ old('expertise') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('expertise') border-red-300 @enderror"
                               placeholder="{{ __('e.g., Computational Biology, Quantum Physics') }}">
                        @error('expertise')
                        <p class="text-sm text-red-600 flex items-center">
                            <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="specialization" class="block text-sm font-semibold text-gray-700">
                            {{ __('Specialization') }}
                        </label>
                        <input type="text"
                               id="specialization"
                               name="specialization"
                               value="{{ old('specialization') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('specialization') border-red-300 @enderror"
                               placeholder="{{ __('e.g., Machine Learning, Organic Chemistry') }}">
                        @error('specialization')
                        <p class="text-sm text-red-600 flex items-center">
                            <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Information (for admin role) -->
            <div id="additional-fields" class="space-y-6 hidden">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">{{ __('Additional Information') }}</h3>

                <!-- Website -->
                <div class="space-y-2">
                    <label for="website" class="block text-sm font-semibold text-gray-700">
                        {{ __('Website') }}
                    </label>
                    <div class="relative">
                        <input type="url"
                               id="website"
                               name="website"
                               value="{{ old('website') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('website') border-red-300 @enderror"
                               placeholder="{{ __('https://example.com') }}">
                        <i data-lucide="globe" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                    </div>
                    @error('website')
                    <p class="text-sm text-red-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i data-lucide="user-plus" class="w-4 h-4 mr-2 inline"></i>
                    {{ __('Create User') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Role-based form field toggling
    document.getElementById('role').addEventListener('change', function() {
        const selectedRole = this.value;
        const editorFields = document.getElementById('editor-fields');
        const reviewerFields = document.getElementById('reviewer-fields');
        const additionalFields = document.getElementById('additional-fields');

        // Hide all conditional fields first
        editorFields.classList.add('hidden');
        reviewerFields.classList.add('hidden');
        additionalFields.classList.add('hidden');

        // Show relevant fields based on selected role
        if (selectedRole === 'editor') {
            editorFields.classList.remove('hidden');
        } else if (selectedRole === 'reviewer') {
            reviewerFields.classList.remove('hidden');
        } else if (selectedRole === 'admin') {
            additionalFields.classList.remove('hidden');
        }
    });

    // Trigger change event on page load to show fields if role is pre-selected
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        if (roleSelect.value) {
            roleSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection
