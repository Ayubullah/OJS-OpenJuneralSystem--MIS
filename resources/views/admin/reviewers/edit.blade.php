@extends('layout.app_admin')

@section('title', 'Edit Reviewer')
@section('page-title', 'Edit Reviewer')
@section('page-description', 'Update reviewer information')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('admin.reviewers.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Reviewers</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-900">Edit</span>
</li>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-indigo-50">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center mr-4">
                    <i data-lucide="edit" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Edit Reviewer</h2>
                    <p class="text-sm text-gray-600">Update the reviewer information below</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.reviewers.update', $reviewer) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- User Selection -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Select User <span class="text-red-500">*</span>
                </label>
                <select name="user_id" id="user_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('user_id') border-red-500 @enderror" required>
                    <option value="">Choose a user...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $reviewer->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Journal Selection -->
            <div>
                <label for="journal_id" class="block text-sm font-medium text-gray-700 mb-2">
                    <i data-lucide="book" class="w-4 h-4 inline mr-1"></i>
                    Journal <span class="text-red-500">*</span>
                </label>
                <select name="journal_id" id="journal_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('journal_id') border-red-500 @enderror" required>
                    <option value="">Select a journal</option>
                    @foreach($journals as $journal)
                        <option value="{{ $journal->id }}" {{ old('journal_id', $reviewer->journal_id) == $journal->id ? 'selected' : '' }}>
                            {{ $journal->name }}
                        </option>
                    @endforeach
                </select>
                @error('journal_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Personal Information Section -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $reviewer->user->name ?? '') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror"
                        placeholder="Enter full name" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="username" id="username" value="{{ old('username', $reviewer->user->username ?? '') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('username') border-red-500 @enderror"
                        placeholder="Enter username" required>
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $reviewer->user->email ?? '') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror"
                        placeholder="user@example.com" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $reviewer->user->phone ?? '') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('phone') border-red-500 @enderror"
                        placeholder="+1234567890">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div class="mb-4">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                        Bio
                    </label>
                    <textarea name="bio" id="bio" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('bio') border-red-500 @enderror"
                        placeholder="Enter bio">{{ old('bio', $reviewer->user->bio ?? '') }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Address
                    </label>
                    <input type="text" name="address" id="address" value="{{ old('address', $reviewer->user->address ?? '') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('address') border-red-500 @enderror"
                        placeholder="Enter address">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City and Country -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                            City
                        </label>
                        <input type="text" name="city" id="city" value="{{ old('city', $reviewer->user->city ?? '') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('city') border-red-500 @enderror"
                            placeholder="Enter city">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                            Country
                        </label>
                        <input type="text" name="country" id="country" value="{{ old('country', $reviewer->user->country ?? '') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('country') border-red-500 @enderror"
                            placeholder="Enter country">
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        New Password <span class="text-gray-400 text-xs">(Leave blank to keep current password)</span>
                    </label>
                    <input type="password" name="password" id="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror"
                        placeholder="Enter new password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                        placeholder="Confirm new password">
                </div>
            </div>

            <!-- Reviewer Information Section -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Reviewer Information</h3>

                <!-- Reviewer Email -->
                <div class="mb-4">
                    <label for="reviewer_email" class="block text-sm font-medium text-gray-700 mb-2">
                        Reviewer Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="reviewer_email" id="reviewer_email" value="{{ old('reviewer_email', $reviewer->email) }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('reviewer_email') border-red-500 @enderror"
                        placeholder="reviewer@example.com" required>
                    @error('reviewer_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expertise -->
                <div class="mb-4">
                    <label for="expertise" class="block text-sm font-medium text-gray-700 mb-2">
                        Expertise
                    </label>
                    <input type="text" name="expertise" id="expertise" value="{{ old('expertise', $reviewer->expertise) }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('expertise') border-red-500 @enderror"
                        placeholder="e.g., Computational Biology, Quantum Physics">
                    @error('expertise')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Specialization -->
                <div class="mb-4">
                    <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">
                        Specialization
                    </label>
                    <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $reviewer->specialization) }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('specialization') border-red-500 @enderror"
                        placeholder="e.g., Machine Learning, Organic Chemistry">
                    @error('specialization')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('status') border-red-500 @enderror" required>
                        <option value="active" {{ old('status', $reviewer->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $reviewer->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.reviewers.index') }}" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    Cancel
                </a>
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-105">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Update Reviewer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection

