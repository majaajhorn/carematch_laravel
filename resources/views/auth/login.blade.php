<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Log in – CareMatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-emerald-50 text-gray-800 antialiased">

    <!-- Top bar -->
    <header class="border-b border-gray-200 bg-white/70 backdrop-blur">
        <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-semibold text-gray-900">
                <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-600 text-white">CM</span>
                <span>CareMatch</span>
            </a>
            <nav class="hidden sm:flex items-center gap-3">
                <a href="{{ route('register') }}"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900">Register</a>
            </nav>
        </div>
    </header>

    <!-- Content -->
    <main class="mx-auto max-w-6xl px-4">
        <section class="py-12 sm:py-16 grid place-items-center">
            <div class="w-full max-w-md">
                <h1 class="text-3xl font-bold text-center">Welcome back</h1>
                <p class="mt-2 text-center text-gray-600">Log in to continue.</p>

                @if ($errors->any())
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}"
                    class="mt-6 space-y-4 rounded-2xl bg-white p-6 shadow">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                            required autocomplete="email"
                            class="mt-1 w-full rounded-xl bg-gray-100 border border-gray-200 px-4 py-3
                                    text-gray-900 placeholder:text-gray-500
                                    focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Password</label>
                        <input type="password" name="password" placeholder="••••••••" required
                            autocomplete="current-password"
                            class="mt-1 w-full rounded-xl bg-gray-100 border border-gray-200 px-4 py-3
                                    text-gray-900 placeholder:text-gray-500
                                    focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40 outline-none">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="remember" value="1" class="rounded border-gray-300">
                            Remember me
                        </label>

                        <a href="{{ route('password.request') }}"
                            class="text-sm font-medium text-emerald-700 hover:underline">
                            Forgot Password?
                        </a>
                    </div>

                    <button type="submit"
                        class="w-full rounded-xl bg-emerald-600 px-4 py-2.5 text-white font-semibold shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Log in
                    </button>



                    <p class="text-center text-sm text-gray-600">
                        New here?
                        <a class="font-medium text-emerald-700 hover:underline" href="{{ route('register') }}">Create an
                            account</a>
                    </p>


                    <div class="mt-4">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">Or</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('auth.google') }}"
                                class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                                    <path fill="#4285F4"
                                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853"
                                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05"
                                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="#EA4335"
                                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                                Continue with Google
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>

</html>