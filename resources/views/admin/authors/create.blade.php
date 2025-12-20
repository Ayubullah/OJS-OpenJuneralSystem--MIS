@extends('layout.app_admin')

@section('title', 'Create Author')
@section('page-title', 'Create Author')
@section('page-description', 'Add a new author to the system')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('admin.authors.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Authors</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-900">Create</span>
</li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center mr-4">
                    <i data-lucide="user-plus" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Create New Author</h2>
                    <p class="text-sm text-gray-600">Fill in the details below to add a new author</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.authors.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror"
                        placeholder="e.g., Dr. John Smith" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror"
                        placeholder="author@university.edu" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Affiliation -->
                <div>
                    <label for="affiliation" class="block text-sm font-medium text-gray-700 mb-2">
                        Affiliation
                    </label>
                    <input type="text" name="affiliation" id="affiliation" value="{{ old('affiliation') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('affiliation') border-red-500 @enderror"
                        placeholder="e.g., University of California">
                    @error('affiliation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Specialization -->
                <div>
                    <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">
                        Specialization
                    </label>
                    <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('specialization') border-red-500 @enderror"
                        placeholder="e.g., Molecular Biology">
                    @error('specialization')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ORCID ID -->
                <div class="md:col-span-2">
                    <label for="orcid_id" class="block text-sm font-medium text-gray-700 mb-2">
                        ORCID ID
                    </label>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-3 py-2 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm rounded-l-lg">
                            <i data-lucide="link" class="w-4 h-4 mr-1"></i>
                            https://orcid.org/
                        </span>
                        <input type="text" name="orcid_id" id="orcid_id" value="{{ old('orcid_id') }}" 
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('orcid_id') border-red-500 @enderror"
                            placeholder="0000-0000-0000-0000">
                    </div>
                    @error('orcid_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Author's unique ORCID identifier</p>
                </div>

                <!-- Author Contributions -->
                <div class="md:col-span-2">
                    <label for="author_contributions" class="block text-sm font-medium text-gray-700 mb-2">
                        Author Contributions
                    </label>
                    <textarea name="author_contributions" id="author_contributions" rows="4" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('author_contributions') border-red-500 @enderror"
                        placeholder="Describe the author's specific contributions to research...">{{ old('author_contributions') }}</textarea>
                    @error('author_contributions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Optional: Describe specific contributions to the research</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.authors.index') }}" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    Cancel
                </a>
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                    <i data-lucide="check" class="w-4 h-4 mr-2"></i>
                    Create Author
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

