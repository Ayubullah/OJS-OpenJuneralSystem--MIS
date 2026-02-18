@extends('layout.app_admin')

@section('title', 'Create New Journal')
@section('page-title', 'Create Journal')
@section('page-description', 'Add a new journal to the system')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('admin.journals.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Journals</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Create</span>
</li>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-purple-50">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center mr-4">
                    <i data-lucide="book" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Create New Journal</h1>
                    <p class="text-sm text-gray-600">Add a new journal to your Kardan Journal Operating System</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.journals.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Journal Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Journal Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('name') border-red-300 @enderror"
                       placeholder="Enter journal name"
                       required>
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- ISSN -->
            <div>
                <label for="issn" class="block text-sm font-medium text-gray-700 mb-2">
                    ISSN <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="issn" 
                       name="issn" 
                       value="{{ old('issn') }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('issn') border-red-300 @enderror"
                       placeholder="e.g., 1234-5678"
                       required>
                @error('issn')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('description') border-red-300 @enderror"
                          placeholder="Enter journal description">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" 
                        name="status"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('status') border-red-300 @enderror"
                        required>
                    <option value="">Select status</option>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.journals.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                    <i data-lucide="save" class="w-4 h-4 mr-2 inline"></i>
                    Create Journal
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
