@extends('layout.app_admin')

@section('title', 'Author Details')
@section('page-title', 'Author Details')
@section('page-description', 'View author information and publications')

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
    <span class="text-sm font-medium text-gray-900">{{ $author->name }}</span>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Author Info Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-2xl">{{ strtoupper(substr($author->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $author->name }}</h2>
                        <p class="text-sm text-gray-600">{{ $author->specialization ?? 'Author' }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.authors.edit', $author) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                        Edit Author
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $author->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <a href="mailto:{{ $author->email }}" class="text-blue-600 hover:text-blue-800">{{ $author->email }}</a>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Affiliation</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $author->affiliation ?? 'Not specified' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Specialization</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $author->specialization ?? 'Not specified' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">ORCID ID</dt>
                    <dd class="mt-1">
                        @if($author->orcid_id)
                            <a href="https://orcid.org/{{ $author->orcid_id }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                <i data-lucide="external-link" class="w-4 h-4 mr-1"></i>
                                {{ $author->orcid_id }}
                            </a>
                        @else
                            <span class="text-sm text-gray-500">Not provided</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Publications</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $author->articles->count() }} articles
                        </span>
                    </dd>
                </div>
                @if($author->author_contributions)
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Author Contributions</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $author->author_contributions }}</dd>
                </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $author->created_at->format('F d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $author->updated_at->format('F d, Y h:i A') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Info Note -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <i data-lucide="info" class="w-5 h-5 text-blue-600 mr-3 mt-0.5"></i>
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-blue-900">Author Submission Portal</h4>
                <p class="text-sm text-blue-700 mt-1">
                    This author can submit articles through the author portal at <strong>/author/articles</strong>. Authors can add their own keywords when submitting articles.
                </p>
            </div>
        </div>
    </div>

    <!-- Published Articles -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Published Articles</h3>
        </div>

        <div class="overflow-x-auto">
            @if($author->articles->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Journal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($author->articles as $article)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($article->title, 60) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $article->journal->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $article->manuscript_type }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($article->status === 'published') bg-green-100 text-green-800
                                @elseif($article->status === 'under_review') bg-yellow-100 text-yellow-800
                                @elseif($article->status === 'accepted') bg-blue-100 text-blue-800
                                @elseif($article->status === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $article->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="px-6 py-12 text-center">
                <i data-lucide="file-text" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No publications yet</h3>
                <p class="text-gray-500">This author hasn't published any articles.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection

