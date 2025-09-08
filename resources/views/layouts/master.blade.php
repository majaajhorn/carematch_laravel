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
        <!-- Logo -->
        <a href="/dashboard" class="inline-flex items-center gap-2 font-semibold text-gray-900">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-600 text-white">CM</span>
            <span>CareMatch</span>
        </a>

        <!-- Desktop navigation -->
        <nav class="hidden sm:flex items-center gap-8">
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                Home
            </a>

            @if(auth()->user()->isJobseeker())
                <a href="{{ route('jobs.index') }}"
                    class="{{ request()->routeIs('jobs.index') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Browse Jobs
                </a>
                <a href="{{ route('jobs.saved') }}"
                    class="{{ request()->routeIs('jobs.saved') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Saved Jobs
                </a>
                <a href="{{ route('applications.index') }}"
                    class="{{ request()->routeIs('applications.index') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                    My Applications
                </a>
            @elseif(auth()->user()->isEmployer())
                <a href="{{ route('carers') }}"
                    class="{{ request()->routeIs('carers') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Browse Carers
                </a>
                <a href="{{ route('jobs.show-my-jobs') }}"
                    class="{{ request()->routeIs('jobs.show-my-jobs') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                    My Job Posts
                </a>
                <a href="{{ route('jobs.create') }}"
                    class="{{ request()->routeIs('jobs.create') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Post a Job
                </a>
            @endif

            @php
                $routeName = auth()->user()->user instanceof App\Models\Employer ? 'employer.profile.show' : 'jobseeker.profile.show';
            @endphp
            <a href="{{ route($routeName) }}"
                class="{{ request()->routeIs($routeName) ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                My Profile
            </a>

            <a href="{{ route('about') }}"
                class="{{ request()->routeIs('about') ? 'text-sm font-medium text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                About
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="inline mt-4">
                @csrf
                <button type="submit"
                    class="inline-flex items-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Log Out
                </button>
            </form>
        </nav>

        <!-- Mobile menu button -->
        <button id="menu-button"
            class="sm:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="sm:hidden hidden px-4 pb-4">
        <nav class="flex flex-col gap-4">
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'font-medium text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                Home
            </a>

            @if(auth()->user()->isJobseeker())
                <a href="{{ route('jobs.index') }}"
                    class="{{ request()->routeIs('jobs.index') ? 'font-medium text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                    Browse Jobs
                </a>
                <a href="{{ route('jobs.saved') }}"
                    class="{{ request()->routeIs('jobs.saved') ? 'font-medium text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                    Saved Jobs
                </a>
                <a href="{{ route('applications.index') }}"
                    class="{{ request()->routeIs('applications.index') ? 'font-medium text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                    My Applications
                </a>
            @elseif(auth()->user()->isEmployer())
                <a href="{{ route('carers') }}"
                    class="{{ request()->routeIs('carers') ? 'font-medium text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                    Browse Carers
                </a>
                <a href="{{ route('jobs.show-my-jobs') }}"
                    class="{{ request()->routeIs('jobs.show-my-jobs') ? 'font-medium text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                    My Job Posts
                </a>
                <a href="{{ route('jobs.create') }}"
                    class="{{ request()->routeIs('jobs.create') ? 'font-medium text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                    Post a Job
                </a>
            @endif

            <a href="{{ route($routeName) }}"
                class="{{ request()->routeIs($routeName) ? 'font-medium text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                My Profile
            </a>

            <a href="{{ route('about') }}"
                class="{{ request()->routeIs('about') ? 'font-medium text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                About
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700">
                    Log Out
                </button>
            </form>
        </nav>
    </div>
</header>

<script>
    const btn = document.getElementById('menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>


<body>
    @if (session('success'))
        <div id="success-alert"
            class="mx-auto max-w-4xl mt-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-alert" class="alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')

    <script>
        setTimeout(() => {
            document.getElementById('success-alert')?.remove();
            document.getElementById('error-alert')?.remove();
        }, 3000);
    </script>
</body>

</html>