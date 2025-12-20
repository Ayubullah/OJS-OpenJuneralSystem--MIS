@extends('layout.app_editor')

@section('title', 'Assign Reviewer')
@section('page-title', 'Assign Reviewer')
@section('page-description', 'Send submission to reviewer for review')

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">Dashboard</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('editor.submissions.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Submissions</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">Assign Reviewer</span>
</li>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Submission Info Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="px-8 py-6 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center mr-4">
                    <i data-lucide="file-text" class="w-6 h-6 text-white"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-900">{{ $submission->article->title ?? 'Untitled Article' }}</h2>
                    <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                        <span class="flex items-center">
                            <i data-lucide="book" class="w-4 h-4 mr-1"></i>
                            {{ $submission->article->journal->name ?? 'Unknown Journal' }}
                        </span>
                        <span class="flex items-center">
                            <i data-lucide="user" class="w-4 h-4 mr-1"></i>
                            {{ $submission->author->name ?? 'Unknown Author' }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Version {{ $submission->version_number }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Reviewer Form -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-red-50">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center mr-4">
                    <i data-lucide="user-check" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Assign Reviewers</h1>
                    <p class="text-sm text-gray-600">Select one or more reviewers to review this submission</p>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        @if(session('error'))
        <div class="mx-8 mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mr-3"></i>
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <form action="{{ route('editor.submissions.assign-reviewer.store', $submission) }}" method="POST" class="p-8 space-y-8">
            @csrf

            <!-- Previous Reviewers by Version - Horizontal Layout -->
            @if($allSubmissions->count() > 0 && $allSubmissions->sum(fn($s) => $s->reviews->count()) > 0)
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <i data-lucide="history" class="w-5 h-5 mr-2 text-orange-600"></i>
                        Review History by Version
                    </h3>
                    <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Click version to select reviewers</span>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($allSubmissions as $sub)
                        @if($sub->reviews->count() > 0)
                        @php
                            // Only include reviewer IDs who haven't given 10/10 rating for the current submission
                            $enabledReviewerIds = $sub->reviews->filter(function($review) use ($submission) {
                                // Check if this reviewer has given 10/10 for the current submission
                                $currentSubmissionReview = $submission->reviews->where('reviewer_id', $review->reviewer_id)->first();
                                return !$currentSubmissionReview || 
                                       $currentSubmissionReview->rating === null || 
                                       (float)$currentSubmissionReview->rating != 10.0;
                            })->pluck('reviewer_id')->implode(',');
                        @endphp
                        <div class="version-card group bg-gradient-to-br from-white to-gray-50 rounded-xl p-5 border-2 border-gray-200 hover:border-orange-400 hover:shadow-xl cursor-pointer transition-all duration-300 transform hover:-translate-y-1" 
                             data-version="{{ $sub->version_number }}"
                             data-reviewer-ids="{{ $enabledReviewerIds }}">
                            <!-- Version Header -->
                            <div class="flex items-center justify-between mb-4 pb-3 border-b-2 border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                                        <span class="text-sm font-bold text-white">V{{ $sub->version_number }}</span>
                                    </div>
                                    @if($sub->id == $submission->id)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-md">
                                        Current
                                    </span>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-semibold text-gray-600">{{ $sub->submission_date->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-400">{{ $sub->reviews->count() }} {{ $sub->reviews->count() == 1 ? 'reviewer' : 'reviewers' }}</p>
                                </div>
                            </div>
                            
                            <!-- Reviewers List -->
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($sub->reviews as $review)
                                <div class="flex items-center justify-between bg-white rounded-lg p-2.5 border border-gray-100 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center space-x-2 flex-1 min-w-0">
                                        <div class="w-7 h-7 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <span class="text-xs font-bold text-white">{{ substr($review->reviewer->user->name ?? $review->reviewer->email, 0, 1) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-gray-900 truncate">{{ $review->reviewer->user->name ?? $review->reviewer->email }}</p>
                                            @if($review->review_date)
                                            <p class="text-xs text-gray-500">Due: {{ $review->review_date->format('M d') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($review->rating)
                                        @if((float)$review->rating == 10.0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700 flex-shrink-0">
                                            <i data-lucide="award" class="w-3 h-3 mr-1"></i>
                                            Review Complete
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 flex-shrink-0">
                                            <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                                            {{ $review->rating }}/10
                                        </span>
                                        @endif
                                    @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 flex-shrink-0">
                                        <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                        Pending
                                    </span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Click Indicator -->
                            <div class="mt-3 pt-3 border-t border-gray-200 flex items-center justify-center">
                                <span class="text-xs text-orange-600 font-medium flex items-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i data-lucide="mouse-pointer-click" class="w-3 h-3 mr-1"></i>
                                    Click to select all
                                </span>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Reviewer Selection -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <label class="block text-lg font-bold text-gray-900 flex items-center">
                        <i data-lucide="users" class="w-5 h-5 mr-2 text-orange-600"></i>
                        Select Reviewers <span class="text-red-500">*</span>
                    </label>
                    @if($reviewers->count() > 0)
                    <button type="button" 
                            id="selectAllReviewers"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-orange-600 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                        <i data-lucide="check-square" class="w-4 h-4 mr-2"></i>
                        Select All
                    </button>
                    @endif
                </div>
                
                @if($reviewers->isEmpty())
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4">
                    <div class="flex items-center">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600 mr-3"></i>
                        <p class="text-sm font-medium text-yellow-800">No active reviewers available. Please add reviewers first.</p>
                    </div>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($reviewers as $reviewer)
                    @php
                        $reviewerReviews = $submission->reviews->where('reviewer_id', $reviewer->id);
                        $reviewCount = $reviewerReviews->count();
                        // Check if this reviewer has given 10/10 rating for this submission
                        $hasRatedTen = $reviewerReviews->contains(function($review) {
                            return $review->rating !== null && (float)$review->rating == 10.0;
                        });
                    @endphp
                    <label class="reviewer-card flex flex-col p-4 bg-gradient-to-br from-white to-gray-50 rounded-xl border-2 {{ $hasRatedTen ? 'border-purple-300 opacity-75 cursor-not-allowed' : 'border-gray-200 hover:border-orange-400 hover:shadow-lg cursor-pointer' }} transition-all duration-200 {{ !$hasRatedTen ? 'transform hover:-translate-y-1' : '' }}">
                        <div class="flex items-start">
                            <input type="checkbox" 
                                   name="reviewer_ids[]" 
                                   value="{{ $reviewer->id }}"
                                   {{ old('reviewer_ids') && in_array($reviewer->id, old('reviewer_ids')) ? 'checked' : '' }}
                                   {{ $hasRatedTen ? 'disabled' : '' }}
                                   class="mt-1 w-5 h-5 text-orange-600 focus:ring-orange-500 rounded border-gray-300 reviewer-checkbox {{ $hasRatedTen ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <div class="ml-3 flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                                                <span class="text-sm font-bold text-white">{{ substr($reviewer->user->name ?? $reviewer->email, 0, 1) }}</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-bold text-gray-900 truncate">
                                                    {{ $reviewer->user->name ?? $reviewer->email }}
                                                </p>
                                            </div>
                                        </div>
                                        @if($reviewer->specialization)
                                        <p class="text-xs font-medium text-gray-700 mb-1">
                                            <i data-lucide="briefcase" class="w-3 h-3 inline mr-1"></i>
                                            {{ $reviewer->specialization }}
                                        </p>
                                        @endif
                                        @if($reviewer->expertise)
                                        <p class="text-xs text-gray-500">
                                            <i data-lucide="award" class="w-3 h-3 inline mr-1"></i>
                                            {{ $reviewer->expertise }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                @if($reviewCount > 0)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    @if($hasRatedTen)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                        <i data-lucide="award" class="w-3 h-3 mr-1"></i>
                                        Review Complete (10/10)
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                        <i data-lucide="file-text" class="w-3 h-3 mr-1"></i>
                                        {{ $reviewCount }} {{ $reviewCount == 1 ? 'review' : 'reviews' }}
                                    </span>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @endif
                
                @error('reviewer_ids')
                <div class="bg-red-50 border-2 border-red-200 rounded-xl p-3">
                    <p class="text-sm text-red-600 flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-2"></i>
                        {{ $message }}
                    </p>
                </div>
                @enderror
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <i data-lucide="info" class="w-3 h-3 mr-1"></i>
                    You can select multiple reviewers to assign them all at once.
                </p>
            </div>

            <!-- Review Deadline (Optional) -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-100">
                <label for="deadline" class="block text-sm font-bold text-gray-900 mb-3 flex items-center">
                    <i data-lucide="calendar" class="w-5 h-5 mr-2 text-blue-600"></i>
                    Review Deadline (Optional)
                </label>
                <div class="relative">
                    <input type="date" 
                           id="deadline" 
                           name="deadline" 
                           value="{{ old('deadline') }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('deadline') border-red-300 @enderror shadow-sm">
                </div>
                @error('deadline')
                <p class="text-sm text-red-600 flex items-center mt-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                    {{ $message }}
                </p>
                @enderror
                <p class="text-xs text-gray-600 mt-2 flex items-center">
                    <i data-lucide="info" class="w-3 h-3 mr-1"></i>
                    Set a deadline for reviewers to complete the review
                </p>
            </div>

            <!-- Info Box -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 mr-4 shadow-md">
                        <i data-lucide="info" class="w-5 h-5 text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-green-900 mb-2 text-sm">What happens when you assign reviewers:</p>
                        <ul class="space-y-2 text-sm text-green-800">
                            <li class="flex items-start">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>A review record will be created for each selected reviewer</span>
                            </li>
                            <li class="flex items-start">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>The submission status will be updated to "Under Review" (if currently "Submitted")</span>
                            </li>
                            <li class="flex items-start">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>All selected reviewers will be able to access and review this submission</span>
                            </li>
                            <li class="flex items-start">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>Reviewers can be assigned multiple times for different review rounds</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-100">
                <a href="{{ route('editor.submissions.show', $submission) }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        id="submitBtn"
                        class="px-8 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white text-sm font-semibold rounded-xl hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                        {{ $reviewers->isEmpty() ? 'disabled' : '' }}>
                    <i data-lucide="send" class="w-4 h-4 mr-2 inline"></i>
                    Assign Reviewers
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Select All functionality
    const selectAllBtn = document.getElementById('selectAllReviewers');
    const reviewerCheckboxes = document.querySelectorAll('.reviewer-checkbox');
    const submitBtn = document.getElementById('submitBtn');

    if (selectAllBtn) {
        let allSelected = false;
        
        selectAllBtn.addEventListener('click', function() {
            allSelected = !allSelected;
            reviewerCheckboxes.forEach(checkbox => {
                if (!checkbox.disabled) {
                    checkbox.checked = allSelected;
                }
            });
            selectAllBtn.textContent = allSelected ? 'Deselect All' : 'Select All';
            updateSubmitButton();
        });
    }

    // Update submit button state based on selected checkboxes
    function updateSubmitButton() {
        const checkedBoxes = document.querySelectorAll('.reviewer-checkbox:checked');
        if (submitBtn) {
            submitBtn.disabled = checkedBoxes.length === 0;
        }
    }

    // Add event listeners to checkboxes
    reviewerCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSubmitButton);
    });

    // Initial check
    updateSubmitButton();

    // Version card click functionality
    const versionCards = document.querySelectorAll('.version-card');
    versionCards.forEach(card => {
        card.addEventListener('click', function() {
            const reviewerIds = this.getAttribute('data-reviewer-ids').split(',').filter(id => id !== '');
            
            // Select all reviewers from this version (only enabled ones)
            reviewerIds.forEach(reviewerId => {
                const checkbox = document.querySelector(`input[name="reviewer_ids[]"][value="${reviewerId}"]`);
                if (checkbox && !checkbox.disabled) {
                    checkbox.checked = true;
                }
            });
            
            // Update submit button state
            updateSubmitButton();
            
            // Visual feedback
            this.classList.add('ring-2', 'ring-orange-500');
            setTimeout(() => {
                this.classList.remove('ring-2', 'ring-orange-500');
            }, 1000);
            
            // Scroll to reviewer selection area
            const reviewerArea = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2');
            if (reviewerArea) {
                reviewerArea.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'nearest' 
                });
            }
        });
    });
</script>
@endsection

