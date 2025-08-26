@extends('layouts.master')

@section('content')

    <div class="max-w-4xl mx-auto p-6">
        <div class="mb-6">
            @if (auth()->user()->isJobseeker())
                <a href="/jobs" class="text-emerald-600 hover:text-emerald-700">← Back to Jobs</a>
            @elseif(auth()->user()->isEmployer())
                <a href="/jobs/my-jobs" class="text-emerald-600 hover:text-emerald-700">← Back to My Jobs</a>
            @endif

        </div>

        <div class="border border-gray-200 rounded-lg p-6">
            <!-- Job Title and Salary -->
            <div class="flex justify-between items-start mb-4">
                <h1 class="text-2xl font-semibold text-gray-900">{{ $job->title }}</h1>
                <span class="text-lg font-bold text-emerald-600">£
                    {{ $job->salary }} {{ (string) $job->salary_period }}
                </span>
            </div>

            <!-- Employment Type and Location -->
            <div class="flex flex-wrap gap-4 mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ ucfirst(str_replace('_', ' ', (string) $job->employment_type)) }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                    📍 {{ $job->location }}
                </span>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                    ✉︎ {{ $job->employer->authParent->email }}
                </span>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                    Posted {{ $job->created_at->diffForHumans() }}
                </span>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <h3 class="font-semibold text-gray-900 mb-2">Description:</h3>
                <p class="text-gray-700 leading-relaxed">
                    {{ $job->description ?: 'No description available.' }}
                </p>
            </div>

            <!-- Requirements -->
            <div class="mb-4">
                <h3 class="font-semibold text-gray-900 mb-2">Requirements:</h3>
                <p class="text-gray-700 leading-relaxed">
                    {{ $job->requirements ?: 'No specific requirements listed.' }}
                </p>
            </div>

            @if(auth()->user()->isJobseeker())
                <div class="flex flex-wrap gap-4">
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        @if(!empty($hasApplied) && $hasApplied)
                            <span
                                class="inline-flex items-center rounded-lg border border-gray-300 bg-gray-100 px-6 py-2 text-sm font-medium text-gray-600">
                                Already applied
                            </span>
                        @else
                            <form method="GET" action="{{ route('applications.create', $job) }}" class="inline">
                                <button type="submit"
                                    class="bg-emerald-600 text-white font-medium px-6 py-2 rounded-lg hover:bg-emerald-700">
                                    Apply
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Saved/Unsave section stays as you had it --}}
                    <div class="mt-6 pt-4 border-t border-gray-100">

                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection