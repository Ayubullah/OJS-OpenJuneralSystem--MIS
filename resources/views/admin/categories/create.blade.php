@extends('layout.app_admin')

@section('title', 'Create Category')
@section('page-title', 'Create Category')
@section('page-description', 'Add a new category to the system')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Categories</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-900">Create</span>
</li>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center mr-4">
                    <i data-lucide="folder-plus" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Create New Category</h2>
                    <p class="text-sm text-gray-600">Fill in the details below to create a new category</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Category Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror"
                    placeholder="e.g., Computer Science, Medicine, Physics" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea name="description" id="description" rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 @error('description') border-red-500 @enderror"
                    placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Provide a brief description to help users understand this category.</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.categories.index') }}" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    Cancel
                </a>
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-sm font-medium rounded-lg hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 transform hover:scale-105">
                    <i data-lucide="check" class="w-4 h-4 mr-2"></i>
                    Create Category
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

