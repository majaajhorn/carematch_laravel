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
                <a href="/dashboard" class="text-sm font-medium text-gray-600 hover:text-gray-900">Home</a>

                {{-- Different navigation based on if the user is jobseeker or employer --}}
                @if(auth()->user()->isJobseeker())
                    <a href="/jobs" class="text-sm font-medium text-gray-600 hover:text-gray-900">Browse Jobs</a>
                    <a href="/jobs/saved" class="text-sm font-medium text-gray-600 hover:text-gray-900">Saved Jobs</a>
                    <a href="/my_applications" class="text-sm font-medium text-gray-600 hover:text-gray-900">My
                        Applications</a>
                @elseif(auth()->user()->isEmployer())
                    <a href="/carers" class="text-sm font-medium text-gray-600 hover:text-gray-900">Browse Carers</a>
                    <a href="/jobs/my-jobs" class="text-sm font-medium text-gray-600 hover:text-gray-900">My Job Posts</a>
                    <a href="/jobs/create" class="text-sm font-medium text-gray-600 hover:text-gray-900">Post a Job</a>
                @endif

                <a href="/profile" class="text-sm font-medium text-gray-600 hover:text-gray-900">My Profile</a>
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
    <main class="max-w-4xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Browse Carers</h1>

        @if($jobseekers->count() > 0)
            <ul class="space-y-3">
                @foreach($jobseekers as $jobseeker)
                    <li class="bg-white border rounded-lg p-4">
                        <div class="font-medium">
                            {{ $jobseeker->authParent->first_name }} {{ $jobseeker->authParent->last_name }}
                        </div>
                        @if($jobseeker->authParent->location)
                            <div class="text-sm text-gray-600">
                                📍 {{ $jobseeker->authParent->location }}
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>

            <p class="mt-4 text-sm text-gray-600">
                Showing {{ $jobseekers->count() }} care professional{{ $jobseekers->count() !== 1 ? 's' : '' }}
            </p>
        @else
            <p class="text-gray-700">No carers found.</p>
        @endif
    </main>
</body>

</html>