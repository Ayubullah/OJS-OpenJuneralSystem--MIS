@extends('layout.app_admin')

@section('title', __('Users Management'))
@section('page-title', __('Users'))
@section('page-description', __('Manage all users in the system'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ __('Users') }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Users Management') }}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('Manage all users and their roles') }}</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                {{ __('Add New User') }}
            </a>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               placeholder="Search by name, email, or username..." 
                               class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                    </div>
                </div>

                <!-- Role Filter -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select id="role" 
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="all">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                        <option value="reviewer">Reviewer</option>
                        <option value="author">Author</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status" 
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3">
                <button type="button" onclick="clearFilters()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    <i data-lucide="x" class="w-4 h-4 inline mr-1"></i>
                    Clear
                </button>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            </div>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Users Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="usersGrid">
        @forelse($users as $user)
        <div class="user-card bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group"
             data-name="{{ strtolower($user->name) }}"
             data-email="{{ strtolower($user->email) }}"
             data-username="{{ strtolower($user->username ?? '') }}"
             data-role="{{ $user->role }}"
             data-status="{{ $user->status }}">
            <!-- User Header -->
            <div class="p-6 pb-4">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center">
                            <span class="text-lg font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors duration-200">
                                {{ $user->name }}
                            </h3>
                            <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                            <p class="text-xs text-gray-400">{{ '@' . ($user->username ?? 'N/A') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                               ($user->role === 'editor' ? 'bg-blue-100 text-blue-800' : 
                               ($user->role === 'reviewer' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800')) }}">
                            {{ __(ucfirst($user->role)) }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ __(ucfirst($user->status)) }}
                        </span>
                    </div>
                </div>

                <!-- User Stats -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-lg font-bold text-gray-900">{{ rand(0, 50) }}</p>
                        <p class="text-xs text-gray-500">{{ __('Articles') }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-lg font-bold text-gray-900">{{ rand(0, 20) }}</p>
                        <p class="text-xs text-gray-500">{{ __('Reviews') }}</p>
                    </div>
                </div>

                <!-- Reviewer Info (if applicable) -->
                @if($user->reviewer)
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <i data-lucide="award" class="w-4 h-4"></i>
                    <span>{{ __('Expertise') }}: {{ $user->reviewer->expertise ?? __('General') }}</span>
                </div>
                @endif
            </div>

            <!-- User Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <div class="flex items-center space-x-1">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.users.show', $user) }}" 
                           class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="users" class="w-8 h-8 text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No users found') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('Get started by creating your first user.') }}</p>
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                    {{ __('Add New User') }}
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- No Results Message (Hidden by default) -->
    <div id="noResults" class="hidden">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i data-lucide="search-x" class="w-8 h-8 text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No results found</h3>
            <p class="text-gray-500 mb-6">Try adjusting your search or filter criteria.</p>
            <button onclick="clearFilters()" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                Clear Filters
            </button>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="flex items-center justify-center">
        {{ $users->links() }}
    </div>
    @endif
</div>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Filter functionality
    function filterUsers() {
        const searchTerm = document.getElementById('search').value.toLowerCase().trim();
        const roleFilter = document.getElementById('role').value;
        const statusFilter = document.getElementById('status').value;
        const userCards = document.querySelectorAll('.user-card');
        const noResults = document.getElementById('noResults');
        let visibleCount = 0;

        userCards.forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const email = card.getAttribute('data-email') || '';
            const username = card.getAttribute('data-username') || '';
            const role = card.getAttribute('data-role') || '';
            const status = card.getAttribute('data-status') || '';
            
            const matchesSearch = !searchTerm || 
                name.includes(searchTerm) || 
                email.includes(searchTerm) || 
                username.includes(searchTerm);
            
            const matchesRole = roleFilter === 'all' || role === roleFilter;
            const matchesStatus = statusFilter === 'all' || status === statusFilter;

            if (matchesSearch && matchesRole && matchesStatus) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }

    function clearFilters() {
        document.getElementById('search').value = '';
        document.getElementById('role').value = 'all';
        document.getElementById('status').value = 'all';
        filterUsers();
    }

    // Add event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const roleSelect = document.getElementById('role');
        const statusSelect = document.getElementById('status');

        if (searchInput) {
            searchInput.addEventListener('input', filterUsers);
        }
        if (roleSelect) {
            roleSelect.addEventListener('change', filterUsers);
        }
        if (statusSelect) {
            statusSelect.addEventListener('change', filterUsers);
        }
    });
</script>
@endsection
