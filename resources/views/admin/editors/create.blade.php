@extends('layout.app_admin')

@section('title', 'Create Editor')
@section('page-title', 'Create Editor')
@section('page-description', 'Add a new editor to the system')

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
    <span class="text-sm font-medium text-gray-500">Create</span>
</li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Editor Information</h2>
            <p class="mt-1 text-sm text-gray-600">Fill in the details to create a new editor</p>
        </div>

        <form action="{{ route('admin.editors.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i data-lucide="user" class="w-4 h-4 inline mr-1"></i>
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
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
                <input type="text" name="username" id="username" value="{{ old('username') }}" required
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
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
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
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password" id="password" required
                       placeholder="Enter password (min. 8 characters)"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <i data-lucide="lock" class="w-4 h-4 inline mr-1"></i>
                    Confirm Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       placeholder="Confirm password"
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
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                    Create Editor
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


