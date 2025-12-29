@extends('layout.app_admin')

@section('title', 'Editor Details')
@section('page-title', 'Editor Details')
@section('page-description', 'View editor information')

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
    <span class="text-sm font-medium text-gray-500">Details</span>
</li>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-indigo-50 to-purple-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl font-bold text-white">{{ substr($editor->user->name ?? 'E', 0, 1) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $editor->user->name ?? 'Unknown' }}</h1>
                        <p class="text-sm text-gray-600">{{ '@' . ($editor->user->username ?? 'N/A') }}</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mt-2
                            {{ $editor->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($editor->status) }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.editors.edit', $editor) }}" 
                       class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2 inline"></i>
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Account Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="user" class="w-5 h-5 mr-2 text-indigo-600"></i>
                    Account Information
                </h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $editor->user->name ?? 'Unknown' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Username</label>
                            <p class="text-sm font-semibold text-gray-900">{{ '@' . ($editor->user->username ?? 'N/A') }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $editor->user->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Role</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                Editor
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Status -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="activity" class="w-5 h-5 mr-2 text-indigo-600"></i>
                    Account Activity
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Account Status</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            {{ $editor->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($editor->status) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Member Since</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $editor->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $editor->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Info</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="shield" class="w-5 h-5 text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Role</p>
                            <p class="text-sm font-bold text-gray-900">Editor</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="mail" class="w-5 h-5 text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="text-sm font-bold text-gray-900">{{ $editor->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="calendar" class="w-5 h-5 text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Joined</p>
                            <p class="text-sm font-bold text-gray-900">{{ $editor->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.editors.edit', $editor) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        Edit Editor
                    </a>
                    <form action="{{ route('admin.editors.destroy', $editor) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this editor?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                            Delete Editor
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
