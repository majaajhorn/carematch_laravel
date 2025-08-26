@extends('layouts.master')

@section('content')
    <div class="mx-auto max-w-4xl p-6">
        <h1 class="mb-6 text-2xl font-semibold text-gray-900">My Applications</h1>

        @if ($applications->isEmpty())
            <div class="rounded-xl border border-gray-200 bg-white p-8 text-center text-gray-600">
                You haven’t applied to any jobs yet.
                <div class="mt-4">
                    <a href="{{ route('jobs.index') }}" class="text-emerald-600 hover:text-emerald-700">Browse jobs →</a>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($applications as $application)
                    <div class="rounded-xl border border-gray-200 bg-white p-5 hover:shadow-sm">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">
                                    <a href="{{ route('jobs.show', $application->job) }}" class="hover:text-emerald-700">
                                        {{ $application->job->title }}
                                    </a>
                                </h2>
                                <div class="mt-1 flex flex-wrap gap-2 text-sm text-gray-600">
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1">📍
                                        {{ $application->job->location }}</span>
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1">💰
                                        £{{ $application->job->salary }} {{ (string) $application->job->salary_period }}</span>
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', (string) $application->job->employment_type)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="text-right text-sm text-gray-600">
                                <div>Applied {{ optional($application->created_at)->diffForHumans() }}</div>
                                @if(!empty($application->status))
                                    <div class="mt-1 font-medium">
                                        Status: <span class="text-gray-800">{{ ucfirst($application->status) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if(!empty($application->cover_letter))
                            <div class="mt-4">
                                <h3 class="mb-1 text-sm font-semibold text-gray-800">Cover Letter</h3>
                                <p class="text-sm leading-relaxed text-gray-700">
                                    {{ \Illuminate\Support\Str::limit($application->cover_letter, 300) }}
                                </p>
                            </div>
                        @endif

                        <div class="mt-4 flex flex-wrap gap-3">
                            <a href="{{ route('jobs.show', $application->job) }}"
                                class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                                View Job
                            </a>

                            @if($application->resume_path)
                                <a href="{{ Storage::disk('public')->url($application->resume_path) }}" target="_blank"
                                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Download CV
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection