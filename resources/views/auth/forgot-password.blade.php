<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Forgot Password – CareMatch</title>
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
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Back to
                    Login</a>
            </nav>
        </div>
    </header>

    <!-- Content -->
    <main class="mx-auto max-w-6xl px-4">
        <section class="py-12 sm:py-16 grid place-items-center">
            <div class="w-full max-w-md">
                <h1 class="text-3xl font-bold text-center">Forgot Password?</h1>
                <p class="mt-2 text-center text-gray-600">Enter your email to receive a reset link.</p>

                {{-- Show success message if email was sent --}}
                @if (session('status'))
                    <div class="mt-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Show error messages --}}
                @if ($errors->any())
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                {{-- The form now sends to password.email route --}}
                <form method="POST" action="{{ route('password.email') }}"
                    class="mt-6 space-y-4 rounded-2xl bg-white p-6 shadow">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                            class="mt-1 w-full rounded-xl bg-gray-100 border border-gray-200 px-4 py-3
                                    text-gray-900 placeholder:text-gray-500
                                    focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40 outline-none">
                    </div>

                    <button type="submit"
                        class="w-full rounded-xl bg-emerald-600 px-4 py-2.5 text-white font-semibold shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Send Reset Link
                    </button>

                    <p class="text-center text-sm text-gray-600">
                        Remember your password?
                        <a class="font-medium text-emerald-700 hover:underline" href="{{ route('login') }}">Back to
                            Login</a>
                    </p>
                </form>
            </div>
        </section>
    </main>
</body>

</html>