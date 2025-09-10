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
                class="{{ request()->routeIs('dashboard') ? 'text-base font-medium text-emerald-600' : 'text-base text-gray-600 hover:text-gray-900' }}">
                Home
            </a>

            @if(auth()->user()->isJobseeker())
                <a href="{{ route('jobs.index') }}"
                    class="{{ request()->routeIs('jobs.index') ? 'text-base font-medium text-emerald-600' : 'text-base text-gray-600 hover:text-gray-900' }}">
                    Browse Jobs
                </a>
                <a href="{{ route('jobs.saved') }}"
                    class="{{ request()->routeIs('jobs.saved') ? 'text-base font-medium text-emerald-600' : 'text-base text-gray-600 hover:text-gray-900' }}">
                    Saved Jobs
                </a>
                <a href="{{ route('applications.index') }}"
                    class="{{ request()->routeIs('applications.index') ? 'text-base font-medium text-emerald-600' : 'text-base text-gray-600 hover:text-gray-900' }}">
                    My Applications
                </a>
            @elseif(auth()->user()->isEmployer())
                <a href="{{ route('carers') }}"
                    class="{{ request()->routeIs('carers') ? 'text-base font-medium text-emerald-600' : 'text-base text-gray-600 hover:text-gray-900' }}">
                    Browse Carers
                </a>
                <a href="{{ route('jobs.show-my-jobs') }}"
                    class="{{ request()->routeIs('jobs.show-my-jobs') ? 'text-base font-medium text-emerald-600' : 'text-base text-gray-600 hover:text-gray-900' }}">
                    My Job Posts
                </a>
                <a href="{{ route('jobs.create') }}"
                    class="{{ request()->routeIs('jobs.create') ? 'text-base font-medium text-emerald-600' : 'text-base text-gray-600 hover:text-gray-900' }}">
                    Post a Job
                </a>
            @endif

            <a href="{{ route('about') }}"
                class="{{ request()->routeIs('about') ? 'text-base font-medium text-emerald-600' : 'text-base text-gray-600 hover:text-gray-900' }}">
                About
            </a>

            <!-- Profile Dropdown Button - Fixed to match other links -->
            <div class="relative">
                <button id="profileDropdownButton"
                    class="inline-flex items-center text-gray-600 hover:text-gray-900 focus:outline-none" type="button">
                    My Profile
                    <svg class="w-4 h-4 ml-2 transition-transform duration-200" id="profileDropdownArrow" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                @php
                    $routeName = auth()->user()->user instanceof App\Models\Employer ? 'employer.profile.show' : 'jobseeker.profile.show';
                @endphp

                <!-- Dropdown menu -->
                <div id="profileDropdownMenu"
                    class="absolute right-0 z-50 hidden w-48 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg">
                    <div class="py-1">
                        <a href="{{ route($routeName) }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs($routeName) ? 'text-emerald-600 bg-emerald-50' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            View Profile
                        </a>

                        @php
                            $editRouteName = auth()->user()->user instanceof App\Models\Employer ? 'employer.profile.edit' : 'jobseeker.profile.edit';
                        @endphp

                        <a href="{{ route($editRouteName) }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs($editRouteName) ? 'text-emerald-600 bg-emerald-50' : '' }}">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Profile
                        </a>

                        <div class="border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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

    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('profileDropdownButton');
        const menu = document.getElementById('profileDropdownMenu');
        const arrow = document.getElementById('profileDropdownArrow');

        // Toggle dropdown when button is clicked
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            const isHidden = menu.classList.contains('hidden');

            if (isHidden) {
                menu.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                menu.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!button.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        });

        // Close dropdown when pressing Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                menu.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        });
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