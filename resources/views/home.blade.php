<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CareMatch</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-emerald-50 text-gray-800 antialiased">

    <!-- Top bar -->
    <header class="border-b border-gray-200 bg-white/70 backdrop-blur">
        <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
            <a href="/" class="inline-flex items-center gap-2 font-semibold text-gray-900">
                <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-600 text-white">CM</span>
                <span>CareMatch</span>
            </a>
            <nav class="hidden sm:flex items-center gap-3">
                <a href="/login" class="text-sm font-medium text-gray-600 hover:text-gray-900">Log In</a>
                <a href="/register"
                    class="inline-flex items-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Register
                </a>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <main class="mx-auto max-w-6xl px-4">
        <section class="py-20 sm:py-24">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">
                    Welcome to <span class="text-emerald-600">CareMatch</span>
                </h1>
                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                    This is the home page of CareMatch, where you can find features to help manage your care needs.
                    Feel free to explore the application and make use of the available resources.
                </p>

                <div class="mt-8 flex items-center justify-center gap-3">
                    <a href="/register"
                        class="inline-flex items-center rounded-xl bg-emerald-600 px-5 py-3 text-base font-semibold text-white shadow hover:bg-emerald-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2">
                        Get Started
                    </a>
                    <a href="/login"
                        class="inline-flex items-center rounded-xl border border-gray-300 px-5 py-3 text-base font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2">
                        Log In
                    </a>
                </div>
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