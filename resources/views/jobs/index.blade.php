@extends('layouts.master')

@section('content')

    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Available Jobs</h1>

        <div class="space-y-6">
            @foreach ($jobs as $job)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <!-- Job Title and Salary -->
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <a href="/jobs/{{ $job->id }}" class="hover:text-emerald-600">
                                {{ $job->title }}
                            </a>
                        </h2>
                        <span class="text-lg font-bold text-emerald-600">£
                            {{ $job->salary }} {{ (string) $job->salary_period }}
                        </span>
                    </div>

                    <!-- Employment Type and Location -->
                    <div class="flex flex-wrap gap-4 mb-4">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst(str_replace('_', ' ', (string) $job->employment_type)) }}
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                            📍 {{ $job->location }}
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                            Posted {{ $job->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Description:</h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $job->description ? Str::limit($job->description, 200) : 'No description available.' }}
                        </p>
                    </div>

                    <!-- Requirements -->
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Requirements:</h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $job->requirements ? Str::limit($job->requirements, 150) : 'No specific requirements listed.' }}
                        </p>
                    </div>

                    <!-- View Details Button -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="/jobs/{{ $job->id }}"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                            View Full Details →
                        </a>
                    </div>
                </div>
            @endforeach

            @if($jobs->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No jobs available at the moment.</p>
                </div>
            @endif
        </div>
    </div>
@endsection