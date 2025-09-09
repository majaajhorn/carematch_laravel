@extends('layouts.master')

@section('content')

    <!-- Search Form with Filter Button on Same Line -->
    <div class="max-w-4xl mx-auto mt-8">
        <div class="flex gap-3">
            <!-- Search Form -->
            <form method="GET" action="{{ route('jobs.index') }}" class="flex-1">
                <div class="flex">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        class="flex-1 px-4 py-2.5  text-gray-900 bg-white border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Search jobs..." />

                    <!-- Preserve filters when searching -->
                    <input type="hidden" name="location" value="{{ $location ?? '' }}">
                    <input type="hidden" name="min_salary" value="{{ $minSalary ?? '' }}">
                    <input type="hidden" name="max_salary" value="{{ $maxSalary ?? '' }}">

                    <button type="submit"
                        class="px-6 py-2.5 text-white font-medium text-base bg-emerald-600 border border-emerald-600 rounded-r-lg hover:bg-emerald-700">
                        Search
                    </button>
                </div>
            </form>

            <!-- Filter Button - Same Line -->
            <button id="openFilters" type="button" class="inline-flex items-center px-6 py-2.5 mb-4
                 border border-emerald-600 text-emerald-700 text-base font-medium rounded-lg
                 bg-transparent hover:text-emerald-800 hover:border-emerald-700
                 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 whitespace-nowrap">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M18 7H17M17 7H16M17 7V6M17 7V8M12.5 5H6C5.5286 5 5.29289 5 5.14645 5.14645C5 5.29289 5 5.5286 5 6V7.96482C5 8.2268 5 8.35779 5.05916 8.46834C5.11833 8.57888 5.22732 8.65154 5.4453 8.79687L8.4688 10.8125C9.34073 11.3938 9.7767 11.6845 10.0133 12.1267C10.25 12.5688 10.25 13.0928 10.25 14.1407V19L13.75 17.25V14.1407C13.75 13.0928 13.75 12.5688 13.9867 12.1267C14.1205 11.8765 14.3182 11.6748 14.6226 11.4415M20 7C20 8.65685 18.6569 10 17 10C15.3431 10 14 8.65685 14 7C14 5.34315 15.3431 4 17 4C18.6569 4 20 5.34315 20 7Z"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                Filters
            </button>
        </div>

        <!-- Clear Search Button (show only when searching) -->
        @if($search)
            <div class="mt-3 text-center">
                <a href="{{ route('jobs.index', array_filter(['location' => $location, 'min_salary' => $minSalary, 'max_salary' => $maxSalary])) }}"
                    class="text-sm text-gray-600 hover:text-gray-800 inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Clear search "{{ $search }}" and keep filters
                </a>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto p-6">

        <!-- Show active filters (if any) -->
        @if($location || $minSalary || $maxSalary)
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-6">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <span class="font-medium">Active filters:</span>
                    @if($location)
                        <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded">Location: {{ $location }}</span>
                    @endif
                    @if($minSalary)
                        <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded">Min: £{{ $minSalary }}</span>
                    @endif
                    @if($maxSalary)
                        <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded">Max: £{{ $maxSalary }}</span>
                    @endif
                    <a href="{{ route('jobs.index', ['search' => $search]) }}"
                        class="text-red-600 hover:text-red-800 ml-2 font-medium">Clear all filters</a>
                </div>
            </div>
        @endif

        <!-- Filter Modal -->
        <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Filter Jobs</h3>
                        <button id="closeFilters" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Content -->
                    <form method="GET" action="{{ route('jobs.index') }}" class="p-6 space-y-4">
                        <!-- Preserve search -->
                        <input type="hidden" name="search" value="{{ $search ?? '' }}">

                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Location</label>
                            <input type="text" name="location" value="{{ $location ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                placeholder="Enter location...">
                        </div>

                        <!-- Salary Range -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Salary Range</label>
                            <div class="flex items-center space-x-2 w-full">
                                <input type="number" name="min_salary" value="{{ $minSalary ?? '' }}"
                                    class="flex-1 min-w-0 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Min">
                                <span class="text-gray-500 flex-shrink-0">to</span>
                                <input type="number" name="max_salary" value="{{ $maxSalary ?? '' }}"
                                    class="flex-1 min-w-0 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Max">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-between pt-4">
                            <button type="button" onclick="resetFilters()"
                                class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Reset
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Available Jobs</h1>
            <div class="text-sm text-gray-600">{{ $jobs->total() }} jobs found</div>
        </div>

        <!-- Job Listings -->
        <div class="space-y-6">
            @forelse ($jobs as $job)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <a href="{{ route('jobs.show', $job) }}" class="hover:text-emerald-600">
                                {{ $job->title }}
                            </a>
                        </h2>
                        <span class="text-lg font-bold text-emerald-600">
                            £{{ $job->salary }} {{ $job->salary_period }}
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-4 mb-4">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
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

                    <p class="text-gray-700 mb-4">
                        {{ Str::limit($job->description, 200) }}
                    </p>

                    <a href="{{ route('jobs.show', $job) }}" class="inline-flex items-center px-4 py-2
                  border border-emerald-600 text-emerald-700 font-medium rounded-lg
                  bg-transparent hover:text-emerald-800 hover:border-emerald-700
                  focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                        View Details →
                    </a>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No jobs found matching your criteria.</p>
                    <a href="{{ route('jobs.index') }}" class="mt-4 inline-block text-emerald-600 hover:text-emerald-700">
                        View all jobs
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $jobs->appends(request()->query())->links() }}
        </div>
    </div>

    <script>
        // Modal functionality
        const modal = document.getElementById('filterModal');
        const openBtn = document.getElementById('openFilters');
        const closeBtn = document.getElementById('closeFilters');

        openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });

        function resetFilters() {
            document.querySelector('input[name="location"]').value = '';
            document.querySelector('input[name="min_salary"]').value = '';
            document.querySelector('input[name="max_salary"]').value = '';
        }
    </script>

@endsection