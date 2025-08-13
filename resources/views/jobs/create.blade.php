<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post a Job</title>
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

                <a href="/my_profile" class="text-sm font-medium text-gray-600 hover:text-gray-900">My Profile</a>
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

    <main class="mx-auto max-w-4xl px-4 py-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Post a New Job</h2>

            <form method="POST" action="{{ route('jobs.store') }}" class="space-y-6">
                <!-- CSRF Token - This is crucial! -->
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Job Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Job Title</label>
                        <input type="text" id="title" name="title" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text" id="location" name="location" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Salary -->
                    <div>
                        <label for="salary" class="block text-sm font-medium text-gray-700 mb-2">Salary</label>
                        <input type="text" id="salary" name="salary" required placeholder="e.g., 500"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <!-- Salary Period -->
                    <div>
                        <label for="salary_period" class="block text-sm font-medium text-gray-700 mb-2">Salary
                            Period</label>
                        <select id="salary_period" name="salary_period" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Select a period</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>

                    <!-- Employment Type -->
                    <div>
                        <label for="employment_type" class="block text-sm font-medium text-gray-700 mb-2">Employment
                            Type</label>
                        <select id="employment_type" name="employment_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Select an employment type</option>
                            <option value="full_time">Full Time</option>
                            <option value="part_time">Part Time</option>
                        </select>
                    </div>
                </div>

                <!-- Job Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Job
                        Description</label>
                    <textarea id="description" name="description" required rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Describe the job responsibilities, what you're looking for in a candidate, and any other important details..."></textarea>
                </div>

                <!-- Requirements -->
                <div>
                    <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">Requirements</label>
                    <textarea id="requirements" name="requirements" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Enter requirements separated by a new line or bullet points."></textarea>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4">

                    <button type="submit"
                        class="px-6 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Post Job
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>