<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About</title>
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

                <a href="{{ route('profile.home') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">My
                    Profile</a>
                <a href="/about" class="text-sm font-medium text-emerald-600 hover:text-gray-900">About</a>

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

    <!-- About content -->
    <main class="mx-auto max-w-6xl px-6 py-16">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-emerald-600 mb-6">About CareMatch</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                <span class="text-emerald-600 font-extrabold">CareMatch</span> is a platform designed to connect
                caregivers with employers in the healthcare industry.
                Our mission is to simplify the process of finding and offering jobs in care work by providing a
                modern, user-friendly experience for both jobseekers and employers.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mt-20">
            <div class="bg-white shadow-lg rounded-2xl p-8 text-center">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">For Jobseekers</h2>
                <p class="text-gray-600 leading-relaxed">
                    Discover opportunities in healthcare tailored to your skills and preferences. Save jobs,
                    track applications, and find the right employer for you.
                </p>
            </div>

            <div class="bg-white shadow-lg rounded-2xl p-8 text-center">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">For Employers</h2>
                <p class="text-gray-600 leading-relaxed">
                    Post job offers, review caregiver profiles, and manage applications with ease. Our platform
                    helps you find the best talent quickly and effectively.
                </p>
            </div>

            <div class="bg-white shadow-lg rounded-2xl p-8 text-center">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Our Vision</h2>
                <p class="text-gray-600 leading-relaxed">
                    To revolutionize the healthcare job market by creating meaningful connections that improve
                    both career opportunities and quality of care.
                </p>
            </div>
        </div>
    </main>
</body>

</html>