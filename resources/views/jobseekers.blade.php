<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Browse Carers</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <!-- Top bar -->
    <header class="border-b border-gray-200 bg-white/70 backdrop-blur">
        <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
            <a href="/dashboard" class="inline-flex items-center gap-2 font-semibold text-gray-900">
                <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-600 text-white">CM</span>
                <span>CareMatch</span>
            </a>
            <nav class="hidden sm:flex items-center gap-8">
                <a href="/dashboard" class="text-sm font-medium text-gray-60 hover:text-gray-900">Home</a>

                {{-- Different navigation based on if the user is jobseeker or employer --}}
                @if(auth()->user()->isJobseeker())
                    <a href="/jobs" class="text-sm font-medium text-gray-600 hover:text-gray-900">Browse Jobs</a>
                    <a href="/jobs/saved" class="text-sm font-medium text-gray-600 hover:text-gray-900">Saved Jobs</a>
                    <a href="/my_applications" class="text-sm font-medium text-gray-600 hover:text-gray-900">My
                        Applications</a>
                @elseif(auth()->user()->isEmployer())
                    <a href="/carers" class="text-sm font-medium text-emerald-600 hover:text-gray-900">Browse Carers</a>
                    <a href="/jobs/my-jobs" class="text-sm font-medium text-gray-600 hover:text-gray-900">My Job Posts</a>
                    <a href="/jobs/create" class="text-sm font-medium text-gray-600 hover:text-gray-900">Post a Job</a>
                @endif

                <a href="{{ route('profile.home') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">My
                    Profile</a>
                <a href="/about" class="text-sm font-medium text-gray-600 hover:text-gray-900">About</a>

                <!-- Logout form -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Log Out
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <!-- Main -->
    <main class="max-w-5xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Browse Carers</h1>
            <p class="text-gray-600 mt-2">Find experienced care professionals for your needs</p>
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
                            <div class="text-xs text-gray-500">
                                Available for hire
                            </div>
                            <button onclick="window.location.href='{{ route('jobseeker.show', $jobseeker->id) }}'"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                View Profile
                            </button>
                        </div>
                    </div>
                @endforeach
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
                <h3 class="mt-2 text-sm font-medium text-gray-900">No carers found</h3>
                <p class="mt-1 text-sm text-gray-500">No care professionals are currently available.</p>
            </div>
        @endif
    </main>
</body>

</html>