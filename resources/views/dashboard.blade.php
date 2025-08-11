<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-emerald-50 text-gray-800 antialiased">

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
                <a href="/jobs" class="text-sm font-medium text-gray-600 hover:text-gray-900">Browse Jobs</a>
                <a href="/my_profile" class="text-sm font-medium text-gray-600 hover:text-gray-900">My Profile</a>
                <a href="/about" class="text-sm font-medium text-gray-600 hover:text-gray-900">About</a>
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

    <!-- Hero -->
    <main class="mx-auto max-w-6xl px-4">
        <section class="py-20 sm:py-24">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">
                    Welcome <span class="text-emerald-600">{{ Auth::user()->first_name }}</span>
                </h1>
                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                    My Applications...
                </p>


            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white/70 backdrop-blur">
        <div class="mx-auto max-w-6xl px-4 py-6 text-center text-sm text-gray-500">
            © {{ now()->year }} CareMatch. All rights reserved.
        </div>
    </footer>
</body>

</html>