@extends('layouts.master')

@section('content')
    <main class="max-w-5xl mx-auto px-4 py-8">
        <a href="{{ url()->previous() }}" class="text-md font-medium bg-white text-emerald-700">
            ← Back
        </a>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mt-4">Applicants</h1>
            <p class="text-gray-600 mt-2">
                For: <a href="{{ route('jobs.show', $job) }}" class="text-emerald-700 hover:text-emerald-800 font-medium">
                    {{ $job->title }}
                </a>
            </p>
        </div>

        @if($applications->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($applications as $application)
                    @php
                        $jobseeker = $application->jobseeker;
                        $user = $jobseeker?->authParent;
                    @endphp

                    <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="flex-shrink-0">
                                @if($user && $user->hasPhoto())
                                    <img src="{{ $user->photo_url }}" class="w-16 h-16 rounded-full object-cover" alt="">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h3 class="font-semibold text-lg text-gray-900">
                                    {{ $user?->first_name }} {{ $user?->last_name }}
                                </h3>

                                <div class="text-sm text-gray-600 space-y-1">
                                    @if($user?->email)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                            {{ $user->email }}
                                        </div>
                                    @endif
                                    @if($user?->location)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $user->location }}
                                        </div>
                                    @endif
                                    @if($jobseeker?->gender)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ ucfirst($jobseeker->gender) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($jobseeker?->about_yourself)
                            <div class="mb-4">
                                <p class="text-gray-700 text-sm leading-relaxed">
                                    {{ Str::limit($jobseeker->about_yourself, 120) }}
                                </p>
                            </div>
                        @endif

                        @if($jobseeker && $jobseeker->experiences->count() > 0)
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($jobseeker->experiences->take(3) as $experience)
                                        <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">
                                            {{ $experience->job_title }}
                                        </span>
                                    @endforeach
                                    @if($jobseeker->experiences->count() > 3)
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs">
                                            +{{ $jobseeker->experiences->count() - 3 }} more
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="text-xs text-gray-500">
                                Applied {{ $application->created_at?->diffForHumans() }}
                            </div>

                            <a href="{{ route('applications.employer.show', $application) }}"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                View Application
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $applications->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No applicants yet</h3>
                <p class="mt-1 text-sm text-gray-500">You don’t have applications for this job yet.</p>
            </div>
        @endif
    </main>
@endsection