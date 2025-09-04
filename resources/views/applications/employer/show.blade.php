@extends('layouts.master')

@section('content')

    <div class="mx-auto max-w-5xl p-6">

        <a href="{{ url()->previous() }}" class="text-md font-medium bg-white text-emerald-700">
            ← Back
        </a>

        <h1 class="mb-6 text-2xl font-semibold text-gray-900 mt-5">Application</h1>

        <div class="rounded-xl border border-gray-200 bg-white p-6">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    {{-- Job title --}}
                    <h2 class="text-xl font-semibold text-gray-900">
                        <a href="{{ route('jobs.show', $application->job_id) }}" class="hover:text-emerald-700">
                            {{ $application->job?->title ?? 'Unknown Job' }}
                        </a>
                    </h2>

                    {{-- Pills --}}
                    <div class="mt-3 flex flex-wrap gap-2 text-sm text-gray-600">
                        @if($application->job?->location)
                            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1">
                                📍 {{ $application->job->location }}
                            </span>
                        @endif

                        @if($application->job?->salary)
                            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1">
                                💰 £{{ $application->job->salary }}
                                @if($application->job?->salary_period)
                                    &nbsp;{{ (string) $application->job->salary_period }}
                                @endif
                            </span>
                        @endif

                        @if($application->job?->employment_type)
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-emerald-800">
                                {{ ucfirst(str_replace('_', ' ', (string) $application->job->employment_type)) }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Right meta: applied & status --}}
                <div class="text-right text-sm text-gray-600">
                    <div>Applied {{ optional($application->created_at)->diffForHumans() }}</div>
                    <div class="mt-2">
                        <span class="mr-1 font-medium">Status:</span>
                        <span
                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $application->status->getBadgeClass() }}">
                            {{ $application->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Applicant name --}}
            <div class="mt-6">
                <div class="text-sm text-gray-500">Applicant</div>
                <div class="text-lg font-semibold text-gray-900">
                    {{ $application->jobseeker?->authParent?->first_name }}
                    {{ $application->jobseeker?->authParent?->last_name }}
                </div>
                @if($application->jobseeker?->authParent?->email)
                    <div class="text-sm text-gray-600">
                        {{ $application->jobseeker->authParent->email }}
                    </div>
                @endif
            </div>

            {{-- Cover Letter --}}
            @if(!empty($application->cover_letter))
                <div class="mt-6">
                    <h3 class="mb-2 text-base font-semibold text-gray-900">Cover Letter</h3>
                    <p class="leading-relaxed text-gray-700">
                        {{ $application->cover_letter }}
                    </p>
                </div>
            @endif

            {{-- Action buttons (match My Applications styling) --}}
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('jobseeker.show', $application->jobseeker_id) }}"
                    class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium bg-emerald-600 text-white hover:bg-emerald-700">
                    View Profile
                </a>

                @if($application->resume_path)
                    <a href="{{ Storage::disk('public')->url($application->resume_path) }}" target="_blank"
                        class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium border border-gray-300 bg-gray-100 text-gray-700">
                        Download CV
                    </a>
                @endif


            </div>
        </div>
    </div>
@endsection