@extends('layouts.master')

@section('content')

    <!-- Hero -->
    <main class="mx-auto max-w-6xl px-4">
        <section class="py-20 sm:py-24">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">
                    Welcome <span class="text-emerald-600">{{ Auth::user()->first_name }}</span>!
                </h1>

                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                    Find the perfect care professional for your needs. Browse carers or post a new job.
                </p>

                {{-- List of applications --}}
                <div class="mt-10 text-left">
                    <h2 class="text-2xl font-semibold mb-4">Applications for your jobs</h2>

                    @if($applications->isEmpty())
                        <p class="text-gray-600">No applications yet.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach($applications as $application)
                                <li class="p-4 border rounded-lg bg-gray-50">
                                    <p><strong>Job:</strong> {{ $application->job->title }}</p>
                                    <p><strong>Applicant:</strong>
                                        {{ $application->jobseeker?->authParent?->first_name }}
                                        {{ $application->jobseeker?->authParent?->last_name }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-6">
                            {{ $applications->links() }}
                        </div>
                    @endif
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
@endsection