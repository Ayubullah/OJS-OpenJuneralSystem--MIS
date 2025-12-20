@extends('layout.app_admin')

@section('title', 'Edit Editor')
@section('page-title', 'Edit Editor')
@section('page-description', 'Update editor information')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('admin.editors.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Editors</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Edit</span>
</li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Edit Editor Information</h2>
                    <p class="mt-1 text-sm text-gray-600">Update editor profile details</p>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center">
                        <span class="text-lg font-bold text-white">{{ substr($editor->name ?? 'E', 0, 1) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.editors.update', $editor) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i data-lucide="user" class="w-4 h-4 inline mr-1"></i>
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $editor->name) }}" required
                       placeholder="Enter full name"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    <i data-lucide="at-sign" class="w-4 h-4 inline mr-1"></i>
                    Username <span class="text-red-500">*</span>
                </label>
                <input type="text" name="username" id="username" value="{{ old('username', $editor->username) }}" required
                       placeholder="Enter username"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('username') border-red-500 @enderror">
                @error('username')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i data-lucide="mail" class="w-4 h-4 inline mr-1"></i>
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email', $editor->email) }}" required
                       placeholder="editor@example.com"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i data-lucide="lock" class="w-4 h-4 inline mr-1"></i>
                    Password <span class="text-gray-500">(leave blank to keep current password)</span>
                </label>
                <input type="password" name="password" id="password"
                       placeholder="Enter new password (min. 8 characters)"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <i data-lucide="lock" class="w-4 h-4 inline mr-1"></i>
                    Confirm Password
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       placeholder="Confirm new password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    <i data-lucide="toggle-left" class="w-4 h-4 inline mr-1"></i>
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" id="status" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('status') border-red-500 @enderror">
                    <option value="active" {{ old('status', $editor->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $editor->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.editors.index') }}" 
                   class="px-6 py-3 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                    Update Editor
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


