@extends('layout.app_reviewer')

@section('title', 'Profile Settings')
@section('page-title', 'Profile Settings')
@section('page-description', 'Manage your account settings and preferences')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <a href="{{ route('reviewer.dashboard') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Profile Settings</span>
</li>
@endsection

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    
    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-2xl p-4 shadow-sm animate-fade-in">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                <i data-lucide="check-circle" class="w-5 h-5 text-purple-600"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-purple-800">{{ session('success') }}</p>
                <p class="text-xs text-purple-600 mt-0.5">Your changes have been saved</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Profile Header Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-pink-600 to-rose-700 rounded-3xl shadow-2xl">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)"/>
            </svg>
        </div>
        
        <!-- Decorative Circles -->
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative px-8 py-10">
            <div class="flex flex-col md:flex-row items-center md:items-end gap-8">
                <!-- Profile Image Section -->
                <div class="relative group">
                    <div class="w-36 h-36 rounded-2xl bg-white/20 backdrop-blur-xl p-1.5 shadow-2xl ring-4 ring-white/30">
                        @if($user->profile_image)
                            <img src="{{ Storage::url($user->profile_image) }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-full h-full object-cover rounded-xl">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-white/30 to-white/10 rounded-xl flex items-center justify-center">
                                <span class="text-5xl font-black text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Image Upload Overlay -->
                    <div class="absolute inset-0 bg-black/50 rounded-2xl opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center backdrop-blur-sm">
                        <form action="{{ route('reviewer.profile.image.update') }}" method="POST" enctype="multipart/form-data" id="imageForm">
                            @csrf
                            @method('PATCH')
                            <label for="profile_image" class="cursor-pointer flex flex-col items-center">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-2 hover:bg-white/30 transition-colors">
                                    <i data-lucide="camera" class="w-6 h-6 text-white"></i>
                                </div>
                                <span class="text-xs text-white font-medium">Change Photo</span>
                            </label>
                            <input type="file" id="profile_image" name="profile_image" class="hidden" accept="image/*" onchange="document.getElementById('imageForm').submit()">
                        </form>
                    </div>
                    
                    <!-- Remove Image Button -->
                    @if($user->profile_image)
                    <form action="{{ route('reviewer.profile.image.remove') }}" method="POST" class="absolute -top-2 -right-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 bg-red-500 hover:bg-red-600 rounded-lg flex items-center justify-center shadow-lg transition-all duration-200 hover:scale-110">
                            <i data-lucide="x" class="w-4 h-4 text-white"></i>
                        </button>
                    </form>
                    @endif
                </div>
                
                <!-- User Info -->
                <div class="text-center md:text-left flex-1">
                    <h1 class="text-3xl font-black text-white mb-1">{{ $user->name }}</h1>
                    <p class="text-white/80 font-medium mb-3">{{ '@' . ($user->username ?? 'username') }}</p>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm text-white text-sm font-medium">
                            <i data-lucide="clipboard-check" class="w-4 h-4 mr-2"></i>
                            Reviewer
                        </span>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-green-500/30 backdrop-blur-sm text-white text-sm font-medium">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                            {{ ucfirst($user->status ?? 'Active') }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm text-white text-sm font-medium">
                            <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                            Joined {{ $user->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="hidden lg:flex items-center gap-6">
                    <div class="text-center px-6 py-4 bg-white/10 backdrop-blur-sm rounded-2xl">
                        <p class="text-3xl font-black text-white">{{ round($user->created_at->diffInDays(now())) }}</p>
                        <p class="text-xs text-white/70 font-medium mt-1">Days Active</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column - Personal Information -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Personal Information Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                            <i data-lucide="user" class="w-5 h-5 text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Personal Information</h2>
                            <p class="text-sm text-gray-500">Update your personal details</p>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('reviewer.profile.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PATCH')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="user" class="w-5 h-5 text-gray-400"></i>
                                </div>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('name') border-red-500 @enderror">
                            </div>
                            @error('name')
                                <p class="text-sm text-red-500 flex items-center"><i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Username -->
                        <div class="space-y-2">
                            <label for="username" class="block text-sm font-semibold text-gray-700">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="at-sign" class="w-5 h-5 text-gray-400"></i>
                                </div>
                                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required
                                       class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('username') border-red-500 @enderror">
                            </div>
                            @error('username')
                                <p class="text-sm text-red-500 flex items-center"><i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('email') border-red-500 @enderror">
                            </div>
                            @error('email')
                                <p class="text-sm text-red-500 flex items-center"><i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Phone -->
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-semibold text-gray-700">
                                Phone Number
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="phone" class="w-5 h-5 text-gray-400"></i>
                                </div>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                       placeholder="+1 (555) 000-0000"
                                       class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('phone') border-red-500 @enderror">
                            </div>
                            @error('phone')
                                <p class="text-sm text-red-500 flex items-center"><i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Bio -->
                        <div class="md:col-span-2 space-y-2">
                            <label for="bio" class="block text-sm font-semibold text-gray-700">
                                Bio
                            </label>
                            <div class="relative">
                                <textarea id="bio" name="bio" rows="4" 
                                          placeholder="Tell us about yourself and your reviewing expertise..."
                                          class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:bg-white transition-all duration-200 resize-none @error('bio') border-red-500 @enderror">{{ old('bio', $user->bio) }}</textarea>
                            </div>
                            <p class="text-xs text-gray-400">Max 500 characters</p>
                            @error('bio')
                                <p class="text-sm text-red-500 flex items-center"><i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Address Section -->
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center">
                            <i data-lucide="map-pin" class="w-4 h-4 mr-2 text-gray-400"></i>
                            Location Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Address -->
                            <div class="md:col-span-3 space-y-2">
                                <label for="address" class="block text-sm font-semibold text-gray-700">Address</label>
                                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}"
                                       placeholder="Street address"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:bg-white transition-all duration-200">
                            </div>
                            
                            <!-- City -->
                            <div class="space-y-2">
                                <label for="city" class="block text-sm font-semibold text-gray-700">City</label>
                                <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}"
                                       placeholder="City"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:bg-white transition-all duration-200">
                            </div>
                            
                            <!-- Country -->
                            <div class="md:col-span-2 space-y-2">
                                <label for="country" class="block text-sm font-semibold text-gray-700">Country</label>
                                <input type="text" id="country" name="country" value="{{ old('country', $user->country) }}"
                                       placeholder="Country"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:bg-white transition-all duration-200">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Right Column - Security & Info -->
        <div class="space-y-8">
            
            <!-- Change Password Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                            <i data-lucide="lock" class="w-5 h-5 text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Security</h2>
                            <p class="text-sm text-gray-500">Change your password</p>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('reviewer.profile.password.update') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <!-- Current Password -->
                    <div class="space-y-2">
                        <label for="current_password" class="block text-sm font-semibold text-gray-700">Current Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="key" class="w-5 h-5 text-gray-400"></i>
                            </div>
                            <input type="password" id="current_password" name="current_password" required
                                   placeholder="Enter current password"
                                   class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('current_password') border-red-500 @enderror">
                        </div>
                        @error('current_password')
                            <p class="text-sm text-red-500 flex items-center"><i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- New Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">New Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                   placeholder="Enter new password"
                                   class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('password') border-red-500 @enderror">
                        </div>
                        @error('password')
                            <p class="text-sm text-red-500 flex items-center"><i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm New Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   placeholder="Confirm new password"
                                   class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:bg-white transition-all duration-200">
                        </div>
                    </div>
                    
                    <!-- Password Requirements -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-gray-600 mb-2">Password Requirements:</p>
                        <ul class="space-y-1">
                            <li class="text-xs text-gray-500 flex items-center">
                                <i data-lucide="check-circle" class="w-3 h-3 mr-2 text-gray-400"></i>
                                Minimum 8 characters
                            </li>
                            <li class="text-xs text-gray-500 flex items-center">
                                <i data-lucide="check-circle" class="w-3 h-3 mr-2 text-gray-400"></i>
                                Mix of letters and numbers
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i data-lucide="shield-check" class="w-5 h-5 mr-2"></i>
                        Update Password
                    </button>
                </form>
            </div>
            
            <!-- Account Info Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                            <i data-lucide="info" class="w-5 h-5 text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Account Info</h2>
                            <p class="text-sm text-gray-500">Your account details</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <i data-lucide="user" class="w-5 h-5 text-gray-400 mr-3"></i>
                            <span class="text-sm text-gray-600">Account ID</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">#{{ $user->id }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <i data-lucide="clipboard-check" class="w-5 h-5 text-gray-400 mr-3"></i>
                            <span class="text-sm text-gray-600">Role</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-purple-100 text-purple-800 text-xs font-semibold">
                            Reviewer
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <i data-lucide="activity" class="w-5 h-5 text-gray-400 mr-3"></i>
                            <span class="text-sm text-gray-600">Status</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-green-100 text-green-800 text-xs font-semibold">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                            {{ ucfirst($user->status ?? 'Active') }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <i data-lucide="calendar" class="w-5 h-5 text-gray-400 mr-3"></i>
                            <span class="text-sm text-gray-600">Member Since</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center">
                            <i data-lucide="clock" class="w-5 h-5 text-gray-400 mr-3"></i>
                            <span class="text-sm text-gray-600">Last Updated</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    (function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    })();
</script>
@endsection

