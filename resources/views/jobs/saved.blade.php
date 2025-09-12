@extends('layouts.master')

@section('content')

    <div class="max-w-6xl mx-auto p-6">
        <!-- Page Header -->
        <div class="mb-8">
            <a href="{{ route('jobs.index') }}" class="text-emerald-600 hover:text-emerald-700 mb-4 inline-block">← Back to
                Browse Jobs</a>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Saved Jobs</h1>
            <p class="text-gray-600">Jobs you've saved for later consideration</p>
        </div>

        <!-- Error Messages -->
        @if(session('message'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                <p class="text-emerald-800">{{ session('message') }}</p>
            </div>
        @endif

        <!-- Saved Jobs List -->
        @if($savedJobs->count() > 0)
            <div class="space-y-6">
                @foreach($savedJobs as $savedJob)
                    @php
                        $filled = $savedJob->job->applications()
                            ->where('status', \App\Enums\ApplicationStatus::Approved)
                            ->exists();
                    @endphp

                    <div class="relative border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow overflow-hidden
                                    {{ $filled ? 'cursor-not-allowed' : '' }}">

                        {{-- Overlay + ribbon when filled --}}
                        @if($filled)
                            <div class="absolute inset-0 bg-white/60 pointer-events-none z-10"></div>
                            <div class="absolute top-3 right-3 z-20">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-800 text-white">
                                    Position filled
                                </span>
                            </div>
                        @endif

                        {{-- Card content (blurred when filled) --}}
                        <div class="{{ $filled ? 'blur-sm select-none' : '' }}">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                        {{-- Conditional link: clickable only if not filled --}}
                                        @if($filled)
                                            <span class="cursor-not-allowed text-gray-500">
                                                {{ $savedJob->job->title }}
                                            </span>
                                        @else
                                            <a href="{{ route('jobs.show', $savedJob->job) }}" class="hover:text-emerald-600">
                                                {{ $savedJob->job->title }}
                                            </a>
                                        @endif
                                    </h2>

                                    <div class="flex flex-wrap gap-4 mb-3 py-3">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                                            {{ ucfirst(str_replace('_', ' ', (string) $savedJob->job->employment_type)) }}
                                        </span>
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                            📍 {{ $savedJob->job->location }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            Posted
                                            {{ $savedJob->job->posted_date ? $savedJob->job->posted_date->diffForHumans() : 'Recently' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="ml-4 text-right">
                                    <span class="text-lg font-bold {{ $filled ? 'text-gray-400' : 'text-emerald-600' }}">
                                        £{{ $savedJob->job->salary }} {{ (string) $savedJob->job->salary_period }}
                                    </span>
                                </div>
                            </div>

                            <p class="text-gray-700 mb-4 line-clamp-2">
                                {{ Str::limit($savedJob->job->description ?: 'No description available.', 150) }}
                            </p>

                            <div class="mt-4 flex items-center gap-3">
                                {{-- View Details: disabled if filled --}}
                                @if($filled)
                                    <span
                                        class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border bg-gray-100 text-gray-500 cursor-not-allowed">
                                        View Details
                                    </span>
                                @else
                                    <a href="{{ route('jobs.show', $savedJob->job) }}"
                                        class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border bg-gray-100 text-gray-700 hover:bg-gray-200">
                                        View Details
                                    </a>
                                @endif

                                {{-- Apply button: different states --}}
                                @if($savedJob->job->has_applied)
                                    <span
                                        class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border border border-gray-300 bg-gray-100 text-gray-600 cursor-not-allowed">
                                        Already applied
                                    </span>
                                @elseif($filled)
                                    <span
                                        class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border border border-gray-300 bg-gray-100 text-gray-600 cursor-not-allowed">
                                        Position filled
                                    </span>
                                @else
                                    <form method="GET" action="{{ route('applications.create', $savedJob->job) }}" class="inline">
                                        <button type="submit"
                                            class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border bg-emerald-600 text-white hover:bg-emerald-700 transition-colors">
                                            Apply Now
                                        </button>
                                    </form>
                                @endif

                                {{-- Remove button: always active --}}
                                <form method="POST" action="{{ route('jobs.unsave', $savedJob->job->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to remove this job from your saved jobs?')"
                                        class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border border border-red-600 text-red-600 hover:bg-red-50 transition-colors">
                                        Remove
                                    </button>
                                </form>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-500">
                                    Saved {{ $savedJob->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mb-4">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No saved jobs yet</h3>
                <p class="text-gray-600 mb-4">Start browsing jobs and save the ones you're interested in!</p>
                <a href="/jobs"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700">
                    Browse Jobs
                </a>
            </div>
        @endif
    </div>
@endsection