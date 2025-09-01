@extends('layouts.master')

@section('content')

    <!-- Simple Search Form -->
    <form method="GET" action="{{ route('jobs.search') }}" class="max-w-2xl mx-auto mt-8">
        <div class="flex">
            <!-- Search Input -->
            <input type="text" name="search" value="{{ $search ?? '' }}"
                class="flex-1 px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                placeholder="Search jobs, locations, employers..." />

            <!-- Search Button -->
            <button type="submit"
                class="px-6 py-2.5 text-white bg-emerald-600 border border-emerald-600 rounded-r-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </div>

        <!-- Clear Search Button (show only when searching) -->
        @if(isset($search) && $search)
            <div class="mt-2 text-center">
                <a href="{{ route('jobs.index') }}" class="text-sm text-gray-600 hover:text-gray-800">
                    Clear search and show all jobs
                </a>
            </div>
        @endif
    </form>

    <!-- Results Section -->
    <div class="max-w-4xl mx-auto p-6">
        <!-- Results Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">
                @if(isset($search) && $search)
                    Search Results for "{{ $search }}"
                @else
                    Available Jobs
                @endif
            </h1>
            <div class="text-sm text-gray-600">
                {{ $jobs->total() }} jobs found
            </div>
        </div>

        <!-- Job Listings -->
        <div class="space-y-6">
            @forelse ($jobs as $job)
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
                        @if($job->employer && $job->employer->authParent)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                                👤 {{ $job->employer->authParent->first_name }} {{ $job->employer->authParent->last_name }}
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Description:</h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $job->description ? Str::limit($job->description, 200) : 'No description available.' }}
                        </p>
                    </div>

                    <!-- Requirements -->
                    @if($job->requirements)
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-900 mb-2">Requirements:</h3>
                            <p class="text-gray-700 leading-relaxed">
                                {{ Str::limit($job->requirements, 150) }}
                            </p>
                        </div>
                    @endif

                    <!-- View Details Button -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="/jobs/{{ $job->id }}"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                            View Full Details →
                        </a>
                    </div>


                </div>
            @empty
                <div class="text-center py-12">
                    @if(isset($search) && $search)
                        <p class="text-gray-500 text-lg">No jobs found for "{{ $search }}"</p>
                        <p class="text-gray-400 mt-2">Try searching with different keywords</p>
                        <a href="{{ route('jobs.index') }}" class="mt-4 inline-block text-emerald-600 hover:text-emerald-700">
                            View all jobs
                        </a>
                    @else
                        <p class="text-gray-500 text-lg">No jobs available at the moment.</p>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $jobs->links() }}
        </div>
    </div>

    <script>
        // Simple dropdown toggle functionality
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButton = document.getElementById('dropdown-button');
            const dropdown = document.getElementById('dropdown');

            dropdownButton.addEventListener('click', function (e) {
                e.preventDefault();
                dropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!dropdownButton.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            // Handle dropdown item selection
            const dropdownItems = dropdown.querySelectorAll('button');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function () {
                    dropdownButton.innerHTML = this.textContent + ' <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>';
                    dropdown.classList.add('hidden');
                });
            });
        });
    </script>
@endsection