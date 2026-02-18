@extends('layout.app_editor')

@section('title', __('Edit Review Comment'))
@section('page-title', __('Edit Review Comment'))
@section('page-description', __('Edit and approve reviewer comment'))

@section('breadcrumb')
<li class="flex items-center">
    <i data-lucide="home" class="w-4 h-4 text-gray-400"></i>
    <span class="ml-2 text-sm font-medium text-gray-500">{{ __('Dashboard') }}</span>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('editor.submissions.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Submissions') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <a href="{{ route('editor.submissions.show', $review->submission) }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">{{ __('Submission Details') }}</a>
</li>
<li class="flex items-center">
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-2"></i>
    <span class="text-sm font-medium text-gray-500">{{ __('Edit Review') }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Edit Review Comment') }}</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            <span>{{ $review->submission->article->title ?? __('Untitled Article') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>{{ __('Reviewer') }}: {{ $review->reviewer->user->name ?? __('Unknown Reviewer') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-3"></i>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mr-3"></i>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Review Information -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Review Information') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Reviewer') }}</label>
                <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer->user->name ?? __('Unknown Reviewer') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Rating') }}</label>
                <p class="text-sm font-semibold text-gray-900">
                    @if($review->rating)
                        {{ $review->rating }}/10
                    @else
                        {{ __('Not rated') }}
                    @endif
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Review Date') }}</label>
                <p class="text-sm font-semibold text-gray-900">{{ $review->review_date?->format('F d, Y \a\t h:i A') ?? __('N/A') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Status') }}</label>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $review->editor_approved ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                    {{ $review->editor_approved ? __('Approved') : __('Pending Approval') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('editor.reviews.update', $review) }}" method="POST" id="reviewEditForm">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- General Comments Section -->
            <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-blue-50 to-purple-50">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="file-text" class="w-5 h-5 mr-2 text-purple-600"></i>
                    {{ __('General Comments') }}
                </h4>
                <p class="text-sm text-gray-600 mb-6">{{ __('Please provide detailed comments for each of the following criteria:') }}</p>
                
                <div class="space-y-6">
                    <!-- Question 1: Originality -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <label for="originality_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                            1. {{ __('Originality') }}
                        </label>
                        <p class="text-xs text-gray-600 mb-3 italic">Does the paper contain new and significant information adequate to justify publication?</p>
                        <textarea name="originality_comment" 
                                  id="originality_comment" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('originality_comment', $review->originality_comment) }}</textarea>
                    </div>

                    <!-- Question 2: Relationship to Literature -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <label for="relationship_to_literature_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                            2. {{ __('Relationship to Literature') }}
                        </label>
                        <p class="text-xs text-gray-600 mb-3 italic">Does the paper demonstrate an adequate understanding of the relevant literature in the field and cite an appropriate range of literature sources? Is any significant work ignored?</p>
                        <textarea name="relationship_to_literature_comment" 
                                  id="relationship_to_literature_comment" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('relationship_to_literature_comment', $review->relationship_to_literature_comment) }}</textarea>
                    </div>

                    <!-- Question 3: Methodology -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <label for="methodology_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                            3. {{ __('Methodology') }}
                        </label>
                        <p class="text-xs text-gray-600 mb-3 italic">Is the paper's argument built on an appropriate base of theory, concepts, or other ideas? Has the research or equivalent intellectual work on which the paper is based been well designed? Are the methods employed appropriate?</p>
                        <textarea name="methodology_comment" 
                                  id="methodology_comment" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('methodology_comment', $review->methodology_comment) }}</textarea>
                    </div>

                    <!-- Question 4: Results -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <label for="results_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                            4. {{ __('Results') }}
                        </label>
                        <p class="text-xs text-gray-600 mb-3 italic">Are results presented clearly and analyzed appropriately? Do the conclusions adequately tie together the other elements of the paper?</p>
                        <textarea name="results_comment" 
                                  id="results_comment" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('results_comment', $review->results_comment) }}</textarea>
                    </div>

                    <!-- Question 5: Implications -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <label for="implications_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                            5. {{ __('Implications for research, practice and society') }}
                        </label>
                        <p class="text-xs text-gray-600 mb-3 italic">Does the paper clearly identify any implications for research, practice and society? Does the paper bridge the gap between theory and practice? How can the research be used in practice (economic and commercial impact), teaching, influencing public policy, and research (contributing to the body of knowledge)? What is the impact on society (influencing public attitudes and quality of life)? Are these implications consistent with the findings and conclusions of the paper?</p>
                        <textarea name="implications_comment" 
                                  id="implications_comment" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('implications_comment', $review->implications_comment) }}</textarea>
                    </div>

                    <!-- Question 6: Quality of Communication -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <label for="quality_of_communication_comment" class="block text-sm font-semibold text-gray-900 mb-2">
                            6. {{ __('Quality of Communication') }}
                        </label>
                        <p class="text-xs text-gray-600 mb-3 italic">Does the paper clearly express its case, measured against the technical language of the field and the expected knowledge of the journal's readership? Has attention been paid to the clarity of expression and readability, such as sentence structure, jargon use, acronyms, etc.?</p>
                        <textarea name="quality_of_communication_comment" 
                                  id="quality_of_communication_comment" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('quality_of_communication_comment', $review->quality_of_communication_comment) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Strengths and Weaknesses Section -->
            <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-green-50 to-blue-50">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="thumbs-up" class="w-5 h-5 mr-2 text-green-600"></i>
                    {{ __('Strengths and Weaknesses') }}
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="strengths" class="block text-sm font-semibold text-gray-900 mb-2">
                            {{ __('Strengths') }}
                        </label>
                        <textarea name="strengths" 
                                  id="strengths" 
                                  rows="5"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('strengths', $review->strengths) }}</textarea>
                    </div>
                    <div>
                        <label for="weaknesses" class="block text-sm font-semibold text-gray-900 mb-2">
                            {{ __('Weaknesses') }}
                        </label>
                        <textarea name="weaknesses" 
                                  id="weaknesses" 
                                  rows="5"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('weaknesses', $review->weaknesses) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Suggestions for Improvement Section -->
            <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-yellow-50 to-orange-50">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="lightbulb" class="w-5 h-5 mr-2 text-yellow-600"></i>
                    {{ __('Suggestions for Improvement') }}
                </h4>
                <textarea name="suggestions_for_improvement" 
                          id="suggestions_for_improvement" 
                          rows="5"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">{{ old('suggestions_for_improvement', $review->suggestions_for_improvement) }}</textarea>
            </div>

            <!-- Paper Score Section -->
            <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-purple-50 to-pink-50">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="award" class="w-5 h-5 mr-2 text-purple-600"></i>
                    {{ __('Paper Score (Ten-point System)') }}
                </h4>
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="relevance_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                {{ __('Relevance') }} <span class="text-gray-500 font-normal">({{ __('Out of 5') }})</span>
                            </label>
                            <input type="number" 
                                   name="relevance_score" 
                                   id="relevance_score" 
                                   value="{{ old('relevance_score', $review->relevance_score) }}"
                                   min="0" 
                                   max="5" 
                                   step="0.1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                        </div>
                        <div>
                            <label for="originality_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                {{ __('Originality') }} <span class="text-gray-500 font-normal">({{ __('Out of 10') }})</span>
                            </label>
                            <input type="number" 
                                   name="originality_score" 
                                   id="originality_score" 
                                   value="{{ old('originality_score', $review->originality_score) }}"
                                   min="0" 
                                   max="10" 
                                   step="0.1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                        </div>
                        <div>
                            <label for="significance_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                {{ __('Significance') }} <span class="text-gray-500 font-normal">({{ __('Out of 15') }})</span>
                            </label>
                            <input type="number" 
                                   name="significance_score" 
                                   id="significance_score" 
                                   value="{{ old('significance_score', $review->significance_score) }}"
                                   min="0" 
                                   max="15" 
                                   step="0.1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                        </div>
                        <div>
                            <label for="technical_soundness_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                {{ __('Technical Soundness') }} <span class="text-gray-500 font-normal">({{ __('Out of 15') }})</span>
                            </label>
                            <input type="number" 
                                   name="technical_soundness_score" 
                                   id="technical_soundness_score" 
                                   value="{{ old('technical_soundness_score', $review->technical_soundness_score) }}"
                                   min="0" 
                                   max="15" 
                                   step="0.1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                        </div>
                        <div>
                            <label for="clarity_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                {{ __('Clarity of Presentation/Language') }} <span class="text-gray-500 font-normal">({{ __('Out of 10') }})</span>
                            </label>
                            <input type="number" 
                                   name="clarity_score" 
                                   id="clarity_score" 
                                   value="{{ old('clarity_score', $review->clarity_score) }}"
                                   min="0" 
                                   max="10" 
                                   step="0.1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                        </div>
                        <div>
                            <label for="documentation_score" class="block text-sm font-semibold text-gray-900 mb-2">
                                {{ __('Overall Documentation and APA/Chicago') }} <span class="text-gray-500 font-normal">({{ __('Out of 5') }})</span>
                            </label>
                            <input type="number" 
                                   name="documentation_score" 
                                   id="documentation_score" 
                                   value="{{ old('documentation_score', $review->documentation_score) }}"
                                   min="0" 
                                   max="5" 
                                   step="0.1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 score-input">
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <label for="total_score" class="block text-sm font-bold text-gray-900 mb-2">
                            {{ __('Total Score') }} <span class="text-gray-500 font-normal">({{ __('Out of 60') }})</span>
                        </label>
                        <input type="number" 
                               name="total_score" 
                               id="total_score" 
                               value="{{ old('total_score', $review->total_score) }}"
                               min="0" 
                               max="60" 
                               step="0.1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 font-bold text-lg text-purple-600">
                        <p class="mt-1 text-xs text-gray-500">{{ __('This will be automatically calculated based on the scores above.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Final Evaluation Section -->
            <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-indigo-50 to-blue-50">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="star" class="w-5 h-5 mr-2 text-indigo-600"></i>
                    {{ __('Final Evaluation') }}
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                        <input type="radio" name="final_evaluation" value="excellent" {{ old('final_evaluation', $review->final_evaluation) === 'excellent' ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm font-medium text-gray-900">{{ __('Excellent') }}</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                        <input type="radio" name="final_evaluation" value="very_good" {{ old('final_evaluation', $review->final_evaluation) === 'very_good' ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm font-medium text-gray-900">{{ __('Very Good') }}</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                        <input type="radio" name="final_evaluation" value="fair" {{ old('final_evaluation', $review->final_evaluation) === 'fair' ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm font-medium text-gray-900">{{ __('Fair') }}</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                        <input type="radio" name="final_evaluation" value="poor" {{ old('final_evaluation', $review->final_evaluation) === 'poor' ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm font-medium text-gray-900">{{ __('Poor') }}</span>
                    </label>
                </div>
            </div>

            <!-- Recommendation Section -->
            <div class="border border-gray-200 rounded-xl p-6 bg-gradient-to-r from-red-50 to-pink-50">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="check-circle" class="w-5 h-5 mr-2 text-red-600"></i>
                    {{ __('Recommendation') }}
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                        <input type="radio" name="recommendation" value="acceptance" {{ old('recommendation', $review->recommendation) === 'acceptance' ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm font-medium text-gray-900">{{ __('Acceptance') }}</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                        <input type="radio" name="recommendation" value="minor_revision" {{ old('recommendation', $review->recommendation) === 'minor_revision' ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm font-medium text-gray-900">{{ __('Minor Revision') }}</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                        <input type="radio" name="recommendation" value="major_revision" {{ old('recommendation', $review->recommendation) === 'major_revision' ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm font-medium text-gray-900">{{ __('Major Revision') }}</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-white transition-colors">
                        <input type="radio" name="recommendation" value="rejection" {{ old('recommendation', $review->recommendation) === 'rejection' ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm font-medium text-gray-900">{{ __('Rejection') }}</span>
                    </label>
                </div>
            </div>

            <!-- General Review Comments Field -->
            <div class="border border-gray-200 rounded-xl p-6 bg-white">
                <label for="comments" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('General Review Comments') }} <span class="text-gray-500">({{ __('Optional') }})</span>
                </label>
                <!-- Rich Text Editor Container -->
                <div id="editor-container" class="bg-white border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500" style="min-height: 300px;"></div>
                <!-- Hidden textarea to store HTML content -->
                <textarea name="comments" 
                          id="comments" 
                          style="display: none;">{{ old('comments', $review->comments) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">{{ __('Additional general comments (optional). Use the formatting toolbar to style your text.') }}</p>
            </div>

            <!-- Approve Checkbox -->
            <div class="border border-gray-200 rounded-xl p-6 bg-white">
                <label class="flex items-center space-x-3">
                    <input 
                        type="checkbox" 
                        name="approve" 
                        value="1"
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        {{ old('approve', $review->editor_approved) ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">{{ __('Approve and notify author') }}</span>
                </label>
                <p class="mt-1 text-xs text-gray-500 ml-7">{{ __('If checked, the review will be approved and the author will be notified immediately.') }}</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                <button 
                    type="submit"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    {{ __('Save Changes') }}
                </button>
                <a 
                    href="{{ route('editor.submissions.show', $review->submission) }}"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    {{ __('Cancel') }}
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Quill.js Rich Text Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Auto-calculate total score
    document.addEventListener('DOMContentLoaded', function() {
        const scoreInputs = document.querySelectorAll('.score-input');
        const totalScoreInput = document.getElementById('total_score');
        
        function calculateTotal() {
            let total = 0;
            scoreInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });
            totalScoreInput.value = total.toFixed(1);
        }
        
        scoreInputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
        });
        
        // Calculate on page load
        calculateTotal();
    });

    // Initialize Quill Rich Text Editor
    document.addEventListener('DOMContentLoaded', function() {
        const editorContainer = document.getElementById('editor-container');
        const hiddenTextarea = document.getElementById('comments');
        
        if (editorContainer && hiddenTextarea) {
            // Initialize Quill editor
            const quill = new Quill('#editor-container', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'font': [] }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'align': [] }],
                        ['blockquote', 'code-block'],
                        ['link', 'image'],
                        ['clean']
                    ]
                },
                placeholder: '{{ __('Edit the reviewer\'s comment here. You can format the text, add emphasis, and structure the content before approving it.') }}'
            });

            // Set initial content
            const initialContent = hiddenTextarea.value;
            if (initialContent) {
                // Check if it's HTML or plain text
                if (initialContent.trim().startsWith('<')) {
                    quill.root.innerHTML = initialContent;
                } else {
                    quill.setText(initialContent);
                }
            }

            // Update hidden textarea when content changes
            quill.on('text-change', function() {
                const html = quill.root.innerHTML;
                hiddenTextarea.value = html;
            });

            // Before form submission, ensure content is synced
            const form = document.getElementById('reviewEditForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const html = quill.root.innerHTML;
                    hiddenTextarea.value = html;
                });
            }
        }
    });
</script>
@endsection
