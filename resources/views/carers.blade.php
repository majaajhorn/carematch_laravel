@extends('layouts.master')

@section('content')

    <!-- Search Form with Filter Button on Same Line -->
    <div class="max-w-4xl mx-auto mt-8">
        <div class="flex gap-3">
            <!-- Search Form -->
            <form method="GET" action="{{ route('carers') }}" class="flex flex-1">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    class="flex-1 px-4 py-2.5  text-gray-900 bg-white border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    placeholder="Search carers..." />

                <!-- Preserve filters when searching -->
                <input type="hidden" name="location" value="{{ $location ?? '' }}">
                <input type="hidden" name="gender" value="{{ $gender ?? '' }}">
                <input type="hidden" name="qualification" value="{{ $qualification ?? '' }}">
                <input type="hidden" name="experience" value="{{ $experience ?? '' }}">

                <button type="submit"
                        class="px-6 py-2.5 text-white font-medium text-base bg-emerald-600 border border-emerald-600 rounded-r-lg hover:bg-emerald-700">
                        Search
                    </button>
            </form>

            <!-- Filter Button - Same Style -->
            <button id="openFilters" type="button"
                class="inline-flex items-center px-6 py-2.5
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
                <a href="{{ route('carers', array_filter(['location' => $location, 'gender' => $gender, 'qualification' => $qualification, 'experience' => $experience])) }}" 
                   class="text-sm text-gray-600 hover:text-gray-800 inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Clear search "{{ $search }}" and keep filters
                </a>
            </div>
        @endif
    </div>

    <!-- Main -->
    <main class="max-w-5xl mx-auto px-4 py-8">
        <div class="mb-8">
            <a href="{{ url()->previous() }}" class="text-emerald-600 hover:text-emerald-800 mb-6 inline-block">
                ← Back
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Browse Carers</h1>
            <p class="text-gray-600 mt-2">Find experienced care professionals for your needs</p>
        </div>

        <!-- Show active filters (if any) -->
        @if($location || $gender || $qualification || $experience)
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-6">
                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
                    <span class="font-medium">Active filters:</span>
                    @if($location)
                        <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded">Location: {{ $location }}</span>
                    @endif
                    @if($gender)
                        <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded">Gender: {{ ucfirst($gender) }}</span>
                    @endif
                    @if($qualification)
                        <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded">Qualification: {{ $qualification }}</span>
                    @endif
                    @if($experience)
                        <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded">Experience: {{ $experience }}</span>
                    @endif
                    <a href="{{ route('carers', ['search' => $search]) }}"
                        class="text-red-600 hover:text-red-800 ml-2 font-medium">Clear all filters</a>
                </div>
            </div>
        @endif

        <!-- Filter Modal -->
        <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Filter Carers</h3>
                        <button id="closeFilters" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Content -->
                    <form method="GET" action="{{ route('carers') }}" class="p-6 space-y-6">
                        <!-- Preserve search -->
                        <input type="hidden" name="search" value="{{ $search ?? '' }}">

                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Location</label>
                            <input type="text" name="location" value="{{ $location ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                placeholder="Enter location...">
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-3">Gender</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="" 
                                           {{ !$gender ? 'checked' : '' }}
                                           class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                    <span class="ml-2 text-sm text-gray-700">Any</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="female" 
                                           {{ $gender === 'female' ? 'checked' : '' }}
                                           class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                    <span class="ml-2 text-sm text-gray-700">Female</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="male" 
                                           {{ $gender === 'male' ? 'checked' : '' }}
                                           class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                    <span class="ml-2 text-sm text-gray-700">Male</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="other" 
                                           {{ $gender === 'other' ? 'checked' : '' }}
                                           class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                    <span class="ml-2 text-sm text-gray-700">Other</span>
                                </label>
                            </div>
                        </div>

                        <!-- Qualifications -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Qualifications</label>
                            <input type="text" name="qualification" value="{{ $qualification ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                placeholder="Enter qualification...">
                        </div>

                        <!-- Care Experience -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Care Experience</label>
                            <input type="text" name="experience" value="{{ $experience ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                placeholder="Enter experience type...">
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <button type="button" 
                                    onclick="resetCarerFilters()"
                                    class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                Reset Filters
                            </button>
                            <div class="flex space-x-2">
                                <button type="button" 
                                        id="cancelFilters"
                                        class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                @if($search)
                    <h2 class="text-xl font-semibold">Search Results for "{{ $search }}"</h2>
                @else
                    <h2 class="text-xl font-semibold">Available Carers</h2>
                @endif
                <p class="text-gray-600 text-sm mt-1">{{ $jobseekers->total() }} care professionals found</p>
            </div>
        </div>

        @if($jobseekers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($jobseekers as $jobseeker)
                    <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                        <!-- Header with photo and basic info -->
                        <div class="flex items-start gap-4 mb-4">
                            <!-- Profile Photo -->
                            <div class="flex-shrink-0">
                                @if($jobseeker->authParent->hasPhoto())
                                    <img src="{{ $jobseeker->authParent->photo_url }}" alt="Profile Photo"
                                        class="w-16 h-16 rounded-full object-cover">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Name and basic details -->
                            <div class="flex-1">
                                <h3 class="font-semibold text-lg text-gray-900">
                                    {{ $jobseeker->authParent->first_name }} {{ $jobseeker->authParent->last_name }}
                                </h3>

                                <div class="text-sm text-gray-600 space-y-1">
                                    @if($jobseeker->authParent->email)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                            {{ $jobseeker->authParent->email }}
                                        </div>
                                    @endif

                                    @if($jobseeker->authParent->location)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $jobseeker->authParent->location }}
                                        </div>
                                    @endif

                                    @if($jobseeker->gender)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ ucfirst($jobseeker->gender) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- About section -->
                        @if($jobseeker->about_yourself)
                            <div class="mb-4">
                                <p class="text-gray-700 text-sm leading-relaxed">
                                    {{ Str::limit($jobseeker->about_yourself, 120) }}
                                </p>
                            </div>
                        @endif

                        <!-- Experience tags -->
                        @if($jobseeker->experiences->count() > 0)
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($jobseeker->experiences->take(3) as $experience)
                                        <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">
                                            {{ $experience->job_title }}
                                        </span>
                                    @endforeach
                                    @if($jobseeker->experiences->count() > 3)
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs">
                                            +{{ $jobseeker->experiences->count() - 3 }} more
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Footer with action -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <button onclick="window.location.href='{{ route('jobseeker.show', $jobseeker->id) }}'"
                                class="inline-flex items-center px-4 py-2
                  border border-emerald-600 text-emerald-700 font-medium rounded-lg
                  bg-transparent hover:text-emerald-800 hover:border-emerald-700
                  focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                                View Profile
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $jobseekers->appends(request()->query())->links() }}
            </div>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Showing {{ $jobseekers->count() }} care professional{{ $jobseekers->count() !== 1 ? 's' : '' }}
                </p>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                @if($search || $location || $gender || $qualification || $experience)
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No carers found matching your criteria</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search and filter options.</p>
                    <a href="{{ route('carers') }}" class="mt-4 inline-block text-emerald-600 hover:text-emerald-700">
                        View all carers
                    </a>
                @else
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No carers found</h3>
                    <p class="mt-1 text-sm text-gray-500">No care professionals are currently available.</p>
                @endif
            </div>
        @endif
    </main>

    <script>
        // Modal functionality
        const modal = document.getElementById('filterModal');
        const openBtn = document.getElementById('openFilters');
        const closeBtn = document.getElementById('closeFilters');
        const cancelBtn = document.getElementById('cancelFilters');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });

        function resetCarerFilters() {
            const form = modal.querySelector('form');
            const inputs = form.querySelectorAll('input[type="text"]');
            const radios = form.querySelectorAll('input[type="radio"]');

            inputs.forEach(input => {
                if (input.name !== 'search') {
                    input.value = '';
                }
            });

            const genderAny = form.querySelector('input[name="gender"][value=""]');
            if (genderAny) {
                genderAny.checked = true;
            }
        }
    </script>

@endsection