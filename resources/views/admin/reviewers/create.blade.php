@extends('layout.app_admin')

@section('title', 'Create Reviewer')
@section('page-title', 'Create Reviewer')
@section('page-description', 'Add a new reviewer to the system')

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
    <span class="text-sm font-medium text-gray-900">Create</span>
</li>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-indigo-50">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center mr-4">
                    <i data-lucide="user-plus" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Create New Reviewer</h2>
                    <p class="text-sm text-gray-600">Fill in the details below to add a new reviewer</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.reviewers.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- User Selection -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Select User <span class="text-red-500">*</span>
                </label>
                <select name="user_id" id="user_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('user_id') border-red-500 @enderror" required>
                    <option value="">Choose a user...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror"
                    placeholder="reviewer@example.com" required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Expertise -->
            <div>
                <label for="expertise" class="block text-sm font-medium text-gray-700 mb-2">
                    Expertise
                </label>
                <input type="text" name="expertise" id="expertise" value="{{ old('expertise') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('expertise') border-red-500 @enderror"
                    placeholder="e.g., Computational Biology, Quantum Physics">
                @error('expertise')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Specialization -->
            <div>
                <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">
                    Specialization
                </label>
                <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('specialization') border-red-500 @enderror"
                    placeholder="e.g., Machine Learning, Organic Chemistry">
                @error('specialization')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" id="status" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('status') border-red-500 @enderror" required>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
                    <i data-lucide="check" class="w-4 h-4 mr-2"></i>
                    Create Reviewer
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

