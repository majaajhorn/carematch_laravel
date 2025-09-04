@extends('layouts.master')

@section('content')

    <!-- Hero -->
    <main class="mx-auto max-w-6xl px-4">
        <section class="py-20 sm:py-24">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">
                    Welcome, <span class="text-emerald-600">{{ Auth::user()->first_name }}</span>!
                </h1>

                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                    Find the perfect care professional for your needs. Browse carers or post a new job.
                </p>

                {{-- List of applications --}}
                <div class="mt-10 text-left">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-semibold mb-4">Applications for your jobs</h2>

                        <a href="{{ route('applications.employer.index') }}"
                            class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700">View
                            All</a>
                    </div>


                    @if($applications->isEmpty())
                        <p class="text-gray-600">No applications yet.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach($applications as $application)
                                <li class="p-4 border rounded-lg bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p><strong>Job:</strong> {{ $application->job->title }}</p>
                                            <p><strong>Applicant:</strong>
                                                {{ $application->jobseeker?->authParent?->first_name }}
                                                {{ $application->jobseeker?->authParent?->last_name }}
                                            </p>
                                            <p><strong>Applied on:</strong> {{ $application->created_at->format('M d, Y') }}</p>
                                        </div>

                                        {{-- Status Badge --}}
                                        <div class="ml-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium {{ $application->status->getBadgeClass() }}">
                                                {{ $application->status }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Action Buttons - Only show if application is pending --}}
                                    @if($application->isPending())
                                        <div class="mt-4 flex space-x-2">
                                            {{-- Approve Button --}}
                                            <form action="{{ route('applications.approve', $application) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="px-6 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                                    onclick="return confirm('Are you sure you want to approve this application?')">
                                                    Approve
                                                </button>
                                            </form>

                                            {{-- Reject Button --}}
                                            <form action="{{ route('applications.reject', $application) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="px-6 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                                    onclick="return confirm('Are you sure you want to reject this application?')">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        {{-- Show status message for non-pending applications --}}
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-600">
                                                This application has been
                                                <strong>{{ $application->status }}</strong>.
                                            </p>
                                        </div>
                                    @endif
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