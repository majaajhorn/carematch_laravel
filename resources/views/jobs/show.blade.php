<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $job->title }}</title>
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
                <a href="/dashboard" class="text-sm font-medium text-gray-600 hover:text-gray-900">Home</a>

                {{-- Different navigation based on if the user is jobseeker or employer --}}
                @if(auth()->user()->isJobseeker())
                    <a href="/jobs" class="text-sm font-medium text-emerald-600 hover:text-gray-900">Browse Jobs</a>
                    <a href="/jobs/saved" class="text-sm font-medium text-gray-600 hover:text-gray-900">Saved Jobs</a>
                    <a href="/my_applications" class="text-sm font-medium text-gray-600 hover:text-gray-900">My
                        Applications</a>
                @elseif(auth()->user()->isEmployer())
                    <a href="/carers" class="text-sm font-medium text-gray-600 hover:text-gray-900">Browse Carers</a>
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
                    ✉︎ {{ $job->employer->authParent->email }}
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
                        <button class="bg-emerald-600 text-white font-medium px-6 py-2 rounded-lg hover:bg-emerald-700">
                            Apply
                        </button>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100">
                        @if($isSaved)
                            <form method="POST" action="{{ route('jobs.unsave', $job->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="border border-red-600 text-red-600 font-medium px-6 py-2 rounded-lg hover:bg-red-50">
                                    Remove
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('jobs.save', $job->id) }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-600 text-white font-medium px-6 py-2 rounded-lg hover:bg-blue-700">
                                    Save Job
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>

</html>