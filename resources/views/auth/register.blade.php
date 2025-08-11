<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Register – CareMatch</title>
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
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Log In</a>
            </nav>
        </div>
    </header>

    <!-- Content -->
    <main class="mx-auto max-w-6xl px-4">
        <section class="py-12 sm:py-16 grid place-items-center">
            <div class="w-full max-w-md">
                <h1 class="text-3xl font-bold text-center">Create your account</h1>
                <p class="mt-2 text-center text-gray-600">It’s quick and easy.</p>

                @if ($errors->any())
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}"
                    class="mt-6 space-y-4 rounded-2xl bg-white p-6 shadow">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium">First name</label>
                        <input name="first_name" value="{{ old('first_name') }}" placeholder="First name" required
                            class="mt-1 w-full rounded-xl bg-gray-100 border border-gray-200 px-4 py-3
                                        text-gray-900 placeholder:text-gray-500
                                        focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40 outline-none"
                            autocomplete="given-name">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Last name</label>
                        <input name="last_name" value="{{ old('last_name') }}" placeholder="Last name" required
                            class="mt-1 w-full rounded-xl bg-gray-100 border border-gray-200 px-4 py-3
                                        text-gray-900 placeholder:text-gray-500
                                        focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40 outline-none" autocomplete="family-name">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                            required
                            class="mt-1 w-full rounded-xl bg-gray-100 border border-gray-200 px-4 py-3
                                        text-gray-900 placeholder:text-gray-500
                                        focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40 outline-none"
                            autocomplete="email">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Password</label>
                        <input type="password" name="password" placeholder="••••••••" required
                            class="mt-1 w-full rounded-xl bg-gray-100 border border-gray-200 px-4 py-3
                                        text-gray-900 placeholder:text-gray-500
                                        focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40 outline-none" autocomplete="new-password">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Confirm password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••"
                            class="mt-1 w-full rounded-xl bg-gray-100 border border-gray-200 px-4 py-3
                                        text-gray-900 placeholder:text-gray-500
                                        focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40 outline-none" autocomplete="new-password">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">I am a</label>

                        <div class="mt-2 grid grid-cols-2 gap-3">
                            <label
                                class="flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-100 px-4 py-3 cursor-pointer">
                                <input type="radio" name="role" value="jobseeker" class="h-4 w-4 text-emerald-600"
                                    @checked(old('role') === 'jobseeker') required>
                                <span class="text-sm">Jobseeker</span>
                            </label>

                            <label
                                class="flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-100 px-4 py-3 cursor-pointer">
                                <input type="radio" name="role" value="employer" class="h-4 w-4 text-emerald-600"
                                    @checked(old('role') === 'employer') required>
                                <span class="text-sm">Employer</span>
                            </label>
                        </div>

                        @error('role')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <button type="submit"
                        class="w-full rounded-xl bg-emerald-600 px-4 py-2.5 text-white font-semibold shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Create account
                    </button>

                    <p class="text-center text-sm text-gray-600">
                        Already have an account?
                        <a class="font-medium text-emerald-700 hover:underline" href="{{ route('login') }}">Log in</a>
                    </p>
                </form>
            </div>
        </section>
    </main>
</body>

</html>