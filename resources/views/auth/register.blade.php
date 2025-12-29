<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register & Submit Article - OJS</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <style>
        * {
            font-family: 'Outfit', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 40px -10px rgba(102, 126, 234, 0.5);
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center shadow-lg">
                        <i data-lucide="book-open" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-3xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">OJS</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Register as Author & Submit Article</h1>
                <p class="text-gray-600">Create your account and submit your research article in one step</p>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-3"></i>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 mr-3"></i>
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="p-8 space-y-8">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="border-b border-gray-200 pb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <i data-lucide="user" class="w-5 h-5 text-indigo-600"></i>
                            </span>
                            Personal Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                    placeholder="Dr. John Smith"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('name') border-red-500 bg-red-50 @enderror">
                                @error('name')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Username <span class="text-red-500">*</span>
                                </label>
                                <input id="username" name="username" type="text" value="{{ old('username') }}" required
                                    placeholder="johndoe"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('username') border-red-500 bg-red-50 @enderror">
                                @error('username')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                    placeholder="name@example.com"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('email') border-red-500 bg-red-50 @enderror">
                                @error('email')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="password" name="password" type="password" required
                                        placeholder="Minimum 8 characters"
                                        class="w-full px-4 py-3 pr-32 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('password') border-red-500 bg-red-50 @enderror">
                                    <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center space-x-1">
                                        <button type="button" onclick="togglePasswordVisibility('password')" 
                                            class="p-2 text-gray-400 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg transition-all duration-200"
                                            title="Show/Hide Password">
                                            <i data-lucide="eye" id="password-eye-icon" class="w-5 h-5"></i>
                                        </button>
                                        <button type="button" onclick="generatePassword()" 
                                            class="px-3 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-xs font-semibold rounded-lg hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 active:scale-95 flex items-center space-x-1 shadow-md"
                                            title="Generate Strong Password">
                                            <i data-lucide="refresh-cw" id="password-generate-icon" class="w-4 h-4"></i>
                                            <span>Generate</span>
                                        </button>
                                    </div>
                                </div>
                                <div id="password-strength" class="mt-2 hidden">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="text-xs font-medium text-gray-600">Password Strength:</span>
                                        <span id="password-strength-text" class="text-xs font-semibold"></span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div id="password-strength-bar" class="h-2 rounded-full transition-all duration-500 ease-out"></div>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="password_confirmation" name="password_confirmation" type="password" required
                                        placeholder="Confirm your password"
                                        class="w-full px-4 py-3 pr-12 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200">
                                    <button type="button" onclick="togglePasswordVisibility('password_confirmation')" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg transition-all duration-200"
                                        title="Show/Hide Password">
                                        <i data-lucide="eye" id="password_confirmation-eye-icon" class="w-5 h-5"></i>
                                    </button>
                                </div>
                                <div id="password-match" class="mt-2 hidden">
                                    <p id="password-match-text" class="text-xs font-medium"></p>
                                </div>
                            </div>

                            <!-- Affiliation -->
                            <div>
                                <label for="affiliation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Affiliation
                                </label>
                                <input id="affiliation" name="affiliation" type="text" value="{{ old('affiliation') }}"
                                    placeholder="University of California"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('affiliation') border-red-500 bg-red-50 @enderror">
                                @error('affiliation')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Specialization -->
                            <div>
                                <label for="specialization" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Specialization
                                </label>
                                <input id="specialization" name="specialization" type="text" value="{{ old('specialization') }}"
                                    placeholder="e.g., Molecular Biology"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('specialization') border-red-500 bg-red-50 @enderror">
                                @error('specialization')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- ORCID ID -->
                        <div class="mt-6">
                            <label for="orcid_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                ORCID ID
                            </label>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-4 py-3 border border-r-0 border-gray-200 bg-gray-50 text-gray-500 text-sm rounded-l-xl">
                                    <i data-lucide="link" class="w-4 h-4 mr-2"></i>
                                    https://orcid.org/
                                </span>
                                <input id="orcid_id" name="orcid_id" type="text" value="{{ old('orcid_id') }}"
                                    placeholder="0000-0000-0000-0000"
                                    class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-r-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('orcid_id') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('orcid_id')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Author Contributions -->
                        <div class="mt-6">
                            <label for="author_contributions" class="block text-sm font-semibold text-gray-700 mb-2">
                                Author Contributions
                            </label>
                            <textarea id="author_contributions" name="author_contributions" rows="3"
                                placeholder="Describe your specific contributions to research (optional)..."
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 resize-none @error('author_contributions') border-red-500 bg-red-50 @enderror">{{ old('author_contributions') }}</textarea>
                            @error('author_contributions')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Basic Information Section -->
                    <div class="border-b border-gray-200 pb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-blue-600 font-bold">1</span>
                            </span>
                            Basic Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Article Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Article Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    placeholder="Enter the full title of your article"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('title') border-red-500 bg-red-50 @enderror">
                                @error('title')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Target Journal -->
                            <div>
                                <label for="journal_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Target Journal <span class="text-red-500">*</span>
                                </label>
                                <select name="journal_id" id="journal_id" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('journal_id') border-red-500 bg-red-50 @enderror">
                                    <option value="">Select a journal...</option>
                                    @foreach($journals as $journal)
                                    <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>
                                        {{ $journal->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('journal_id')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select name="category_id" id="category_id" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('category_id') border-red-500 bg-red-50 @enderror">
                                    <option value="">Select a category...</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Manuscript Type -->
                            <div class="md:col-span-2">
                                <label for="manuscript_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Manuscript Type <span class="text-red-500">*</span>
                                </label>
                                <select name="manuscript_type" id="manuscript_type" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('manuscript_type') border-red-500 bg-red-50 @enderror">
                                    <option value="Research Article" {{ old('manuscript_type') == 'Research Article' ? 'selected' : '' }}>Research Article</option>
                                    <option value="Review Article" {{ old('manuscript_type') == 'Review Article' ? 'selected' : '' }}>Review Article</option>
                                    <option value="Case Study" {{ old('manuscript_type') == 'Case Study' ? 'selected' : '' }}>Case Study</option>
                                    <option value="Short Communication" {{ old('manuscript_type') == 'Short Communication' ? 'selected' : '' }}>Short Communication</option>
                                    <option value="Letter to Editor" {{ old('manuscript_type') == 'Letter to Editor' ? 'selected' : '' }}>Letter to Editor</option>
                                </select>
                                @error('manuscript_type')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Abstract and Content Details Section -->
                    <div class="border-b border-gray-200 pb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-green-600 font-bold">2</span>
                            </span>
                            Abstract and Content Details
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Abstract -->
                            <div>
                                <label for="abstract" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Abstract <span class="text-red-500">*</span>
                                </label>
                                <textarea name="abstract" id="abstract" rows="6" required
                                    placeholder="Enter the abstract of your article..."
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 resize-none @error('abstract') border-red-500 bg-red-50 @enderror">{{ old('abstract') }}</textarea>
                                @error('abstract')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Word Count -->
                                <div>
                                    <label for="word_count" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Word Count <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="word_count" id="word_count" value="{{ old('word_count') }}" min="0" required
                                        placeholder="5000"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('word_count') border-red-500 bg-red-50 @enderror">
                                    @error('word_count')
                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Number of Tables -->
                                <div>
                                    <label for="number_of_tables" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Number of Tables
                                    </label>
                                    <input type="number" name="number_of_tables" id="number_of_tables" value="{{ old('number_of_tables', 0) }}" min="0"
                                        placeholder="0"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('number_of_tables') border-red-500 bg-red-50 @enderror">
                                    @error('number_of_tables')
                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Number of Figures -->
                                <div>
                                    <label for="number_of_figures" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Number of Figures
                                    </label>
                                    <input type="number" name="number_of_figures" id="number_of_figures" value="{{ old('number_of_figures', 0) }}" min="0"
                                        placeholder="0"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('number_of_figures') border-red-500 bg-red-50 @enderror">
                                    @error('number_of_figures')
                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Manuscript File Section -->
                    <div class="border-b border-gray-200 pb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-purple-600 font-bold">3</span>
                            </span>
                            Manuscript File
                        </h3>

                        <div>
                            <label for="manuscript_file" class="block text-sm font-semibold text-gray-700 mb-2">
                                Upload Manuscript File <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex items-center justify-center px-6 py-12 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 transition-colors duration-200 bg-gray-50">
                                <div class="space-y-2 text-center">
                                    <i data-lucide="upload" class="w-12 h-12 text-gray-400 mx-auto"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="manuscript_file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 px-4 py-2 border border-gray-300 rounded-lg">
                                            <span>Upload a file</span>
                                            <input id="manuscript_file" name="manuscript_file" type="file" class="sr-only" accept=".pdf,.doc,.docx" required onchange="updateFileName(this)">
                                        </label>
                                        <p class="pl-3 py-2">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 10MB</p>
                                    <p id="file-name" class="text-sm font-medium text-indigo-600 mt-2"></p>
                                </div>
                            </div>
                            @error('manuscript_file')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Keywords Section -->
                    <div class="border-b border-gray-200 pb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-indigo-600 font-bold">4</span>
                            </span>
                            Keywords
                        </h3>

                        <div class="space-y-4">
                            <!-- Existing Keywords -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Select Existing Keywords
                                </label>
                                <div class="border border-gray-200 rounded-xl p-4 max-h-48 overflow-y-auto bg-gray-50">
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                        @foreach($keywords as $keyword)
                                        <label class="flex items-center p-2 hover:bg-white rounded-lg cursor-pointer border border-gray-200">
                                            <input type="checkbox" name="keywords[]" value="{{ $keyword->id }}" 
                                                class="text-indigo-600 focus:ring-indigo-500 rounded">
                                            <span class="ml-2 text-sm text-gray-700">{{ $keyword->keyword }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- New Keywords -->
                            <div>
                                <label for="new_keywords" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Add New Keywords
                                </label>
                                <input type="text" name="new_keywords" id="new_keywords" value="{{ old('new_keywords') }}" 
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200"
                                    placeholder="Enter keywords separated by commas (e.g., Machine Learning, AI, Neural Networks)">
                                <p class="mt-1 text-sm text-gray-500">Separate multiple keywords with commas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submission Details Section -->
                    <div class="pb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-orange-600 font-bold">5</span>
                            </span>
                            Submission Details
                        </h3>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Previously Submitted -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Previously Submitted Elsewhere? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="radio" name="previously_submitted" value="Yes" {{ old('previously_submitted') == 'Yes' ? 'checked' : '' }} 
                                                class="text-indigo-600 focus:ring-indigo-500" required>
                                            <span class="ml-2 text-sm text-gray-700">Yes</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="previously_submitted" value="No" {{ old('previously_submitted') == 'No' ? 'checked' : '' }} 
                                                class="text-indigo-600 focus:ring-indigo-500" required>
                                            <span class="ml-2 text-sm text-gray-700">No</span>
                                        </label>
                                    </div>
                                    @error('previously_submitted')
                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Funded by Outside Source -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Funded by Outside Source? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="radio" name="funded_by_outside_source" value="Yes" {{ old('funded_by_outside_source') == 'Yes' ? 'checked' : '' }} 
                                                class="text-indigo-600 focus:ring-indigo-500" required>
                                            <span class="ml-2 text-sm text-gray-700">Yes</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="funded_by_outside_source" value="No" {{ old('funded_by_outside_source') == 'No' ? 'checked' : '' }} 
                                                class="text-indigo-600 focus:ring-indigo-500" required>
                                            <span class="ml-2 text-sm text-gray-700">No</span>
                                        </label>
                                    </div>
                                    @error('funded_by_outside_source')
                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirmations -->
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 space-y-4">
                                <label class="flex items-start">
                                    <input type="radio" name="confirm_not_published_elsewhere" value="Yes" {{ old('confirm_not_published_elsewhere', 'Yes') == 'Yes' ? 'checked' : '' }} 
                                        class="mt-1 text-indigo-600 focus:ring-indigo-500" required>
                                    <span class="ml-3 text-sm text-gray-700">
                                        <strong>I confirm</strong> that this manuscript has not been published elsewhere and is not under consideration by another journal. <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                @error('confirm_not_published_elsewhere')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror

                                <label class="flex items-start">
                                    <input type="radio" name="confirm_prepared_as_per_guidelines" value="Yes" {{ old('confirm_prepared_as_per_guidelines', 'Yes') == 'Yes' ? 'checked' : '' }} 
                                        class="mt-1 text-indigo-600 focus:ring-indigo-500" required>
                                    <span class="ml-3 text-sm text-gray-700">
                                        <strong>I confirm</strong> that this manuscript has been prepared according to the journal's guidelines for authors. <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                @error('confirm_prepared_as_per_guidelines')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('login') }}" 
                            class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            Already have an account? Sign in
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center px-8 py-3 btn-gradient text-white text-sm font-semibold rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                            <span>Register & Submit Article</span>
                            <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Update file name display
        function updateFileName(input) {
            const fileName = input.files[0]?.name;
            const fileNameDisplay = document.getElementById('file-name');
            if (fileName) {
                fileNameDisplay.textContent = `Selected: ${fileName}`;
            } else {
                fileNameDisplay.textContent = '';
            }
        }

        // Password generation and strength checking
        function generatePassword() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const generateIcon = document.getElementById('password-generate-icon');
            
            // Add rotation animation with pulse effect
            generateIcon.style.animation = 'spin 0.6s ease-in-out';
            generateIcon.parentElement.style.transform = 'scale(1.1)';
            
            setTimeout(() => {
                generateIcon.style.animation = '';
                generateIcon.parentElement.style.transform = 'scale(1)';
            }, 600);
            
            // Generate strong password (16 characters)
            const length = 16;
            const lowercase = 'abcdefghijklmnopqrstuvwxyz';
            const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const numbers = '0123456789';
            const special = '!@#$%^&*()_+-=[]{}|;:,.<>?';
            const allChars = lowercase + uppercase + numbers + special;
            
            let password = '';
            
            // Ensure at least one of each type for strong password
            password += lowercase[Math.floor(Math.random() * lowercase.length)];
            password += uppercase[Math.floor(Math.random() * uppercase.length)];
            password += numbers[Math.floor(Math.random() * numbers.length)];
            password += special[Math.floor(Math.random() * special.length)];
            
            // Fill the rest randomly
            for (let i = password.length; i < length; i++) {
                password += allChars[Math.floor(Math.random() * allChars.length)];
            }
            
            // Shuffle the password using Fisher-Yates algorithm
            password = password.split('');
            for (let i = password.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [password[i], password[j]] = [password[j], password[i]];
            }
            password = password.join('');
            
            // Animate password appearance with fade effect
            passwordInput.style.opacity = '0.3';
            passwordInput.style.transform = 'translateX(-5px)';
            
            setTimeout(() => {
                passwordInput.value = password;
                confirmPasswordInput.value = password; // Auto-fill confirm password
                passwordInput.style.opacity = '1';
                passwordInput.style.transform = 'translateX(0)';
                passwordInput.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                
                // Trigger input events to check strength and match
                passwordInput.dispatchEvent(new Event('input'));
                confirmPasswordInput.dispatchEvent(new Event('input'));
                
                // Add success pulse animation
                passwordInput.style.boxShadow = '0 0 0 3px rgba(99, 102, 241, 0.3)';
                setTimeout(() => {
                    passwordInput.style.boxShadow = '';
                }, 500);
            }, 300);
        }

        // Toggle password visibility
        function togglePasswordVisibility(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-eye-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            let strengthText = '';
            let strengthColor = '';
            
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthTextEl = document.getElementById('password-strength-text');
            const strengthDiv = document.getElementById('password-strength');
            
            if (password.length === 0) {
                strengthDiv.classList.add('hidden');
                return;
            }
            
            strengthDiv.classList.remove('hidden');
            
            if (strength <= 2) {
                strengthText = 'Weak';
                strengthColor = 'bg-red-500';
                strengthBar.style.width = '33%';
            } else if (strength === 3) {
                strengthText = 'Fair';
                strengthColor = 'bg-yellow-500';
                strengthBar.style.width = '50%';
            } else if (strength === 4) {
                strengthText = 'Good';
                strengthColor = 'bg-blue-500';
                strengthBar.style.width = '75%';
            } else {
                strengthText = 'Strong';
                strengthColor = 'bg-green-500';
                strengthBar.style.width = '100%';
            }
            
            strengthBar.className = `h-2 rounded-full transition-all duration-300 ${strengthColor}`;
            strengthTextEl.textContent = strengthText;
            strengthTextEl.className = `text-xs font-semibold ${strengthColor.replace('bg-', 'text-')}`;
        }

        // Add CSS animation for spin
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .password-generate-btn:active {
                transform: scale(0.95);
            }
        `;
        document.head.appendChild(style);

        // Check password match
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchDiv = document.getElementById('password-match');
            const matchText = document.getElementById('password-match-text');
            
            if (confirmPassword.length === 0) {
                matchDiv.classList.add('hidden');
                return;
            }
            
            matchDiv.classList.remove('hidden');
            
            if (password === confirmPassword) {
                matchText.textContent = '✓ Passwords match';
                matchText.className = 'text-xs font-medium text-green-600 flex items-center';
                matchText.innerHTML = '<i data-lucide="check-circle" class="w-4 h-4 mr-1"></i> Passwords match';
                lucide.createIcons();
            } else {
                matchText.textContent = '✗ Passwords do not match';
                matchText.className = 'text-xs font-medium text-red-600 flex items-center';
                matchText.innerHTML = '<i data-lucide="x-circle" class="w-4 h-4 mr-1"></i> Passwords do not match';
                lucide.createIcons();
            }
        }

        // Listen for password input changes
        document.getElementById('password').addEventListener('input', function(e) {
            checkPasswordStrength(e.target.value);
            checkPasswordMatch();
        });

        // Listen for confirm password input changes
        document.getElementById('password_confirmation').addEventListener('input', function(e) {
            checkPasswordMatch();
        });

        // Also check on page load if there's a value
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.value) {
                checkPasswordStrength(passwordInput.value);
                checkPasswordMatch();
            }
        });
    </script>
</body>
</html>
