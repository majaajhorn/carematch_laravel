@extends('layouts.master')

@section('content')

    <!-- Hero -->
    <main class="mx-auto max-w-6xl px-4">
        <section class="py-20 sm:py-24">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">
                    Welcome <span class="text-emerald-600">{{ Auth::user()->first_name }}</span>!
                </h1>

                {{-- Different content based on user type --}}
                @if(auth()->user()->isJobseeker())
                    <p class="mt-4 text-lg leading-relaxed text-gray-600">
                        Ready to find your next care opportunity? Browse available jobs and apply today.
                    </p>
                @elseif(auth()->user()->isEmployer())
                    <p class="mt-4 text-lg leading-relaxed text-gray-600">
                        Find the perfect care professional for your needs. Browse carers or post a new job.
                    </p>
                @endif
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white/70 backdrop-blur">
        <div class="mx-auto max-w-6xl px-4 py-6 text-center text-sm text-gray-500">
            © {{ now()->year }} CareMatch. All rights reserved.
        </div>
    </footer>
@endsection