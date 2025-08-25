<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<!-- Top bar -->
<header class="border-b border-gray-200 bg-white/70 backdrop-blur">
    <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
        <a href="/dashboard" class="inline-flex items-center gap-2 font-semibold text-gray-900">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-600 text-white">CM</span>
            <span>CareMatch</span>
        </a>
        <nav class="hidden sm:flex items-center gap-8">
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">Home</a>

            {{-- Different navigation based on if the user is jobseeker or employer --}}
            @if(auth()->user()->isJobseeker())
                <a href="{{ route('jobs.index') }}"
                    class="{{ request()->routeIs('jobs.index') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">Browse
                    Jobs</a>
                <a href="{{ route('jobs.saved') }}"
                    class="{{ request()->routeIs('jobs.saved') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }} ">Saved
                    Jobs</a>
                <a href="{{ route('applications.index') }}"
                    class="{{ request()->routeIs('applications.index') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }} ">My
                    Applications</a>
            @elseif(auth()->user()->isEmployer())
                <a href="{{ route('carers') }}"
                    class="{{ request()->routeIs('carers') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">Browse
                    Carers</a>
                <a href="{{ route('jobs.show-my-jobs') }}"
                    class="{{ request()->routeIs('jobs.show-my-jobs') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">My
                    Job Posts</a>
                <a href="{{ route('jobs.create') }}"
                    class="{{ request()->routeIs('jobs.create') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">Post
                    a Job</a>
            @endif

            @php
                $routeName = auth()->user()->user instanceof App\Models\Employer ? 'employer.profile.show' : 'jobseeker.profile.show';
            @endphp
            <a href="{{ route($routeName) }}"
                class="{{ request()->routeIs($routeName) ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">My
                Profile</a>
            <a href="{{ route('about') }}"
                class="{{ request()->routeIs('about') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">About</a>

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

<body>
    @if ($errors->any())
        <div class="alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</body>

</html>