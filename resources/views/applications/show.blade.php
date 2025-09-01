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
                                <div class="mt-1 flex flex-wrap gap-2 text-sm text-gray-600 py-3">
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1">📍
                                        {{ $application->job->location }}</span>
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1">💰
                                        £{{ $application->job->salary }} {{ (string) $application->job->salary_period }}</span>
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', (string) $application->job->employment_type)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="text-right text-sm text-gray-600 py-4 ">
                                <div>Applied {{ optional($application->created_at)->diffForHumans() }}</div>
                                @if(!empty($application->status))
                                    <div class="mt-1 font-medium">
                                        Status: <span
                                            class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium {{ $application->status->getBadgeClass() }}">
                                            {{ $application->status }}
                                        </span>
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

                        <div class="mt-4 flex items-center gap-3">
                            <a href="{{ route('jobs.show', $application->job) }}"
                                class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border bg-emerald-600 text-white hover:bg-emerald-700">
                                View Job
                            </a>

                            @if($application->resume_path)
                                <a href="{{ Storage::disk('public')->url($application->resume_path) }}" target="_blank"
                                    class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border border border-gray-300 bg-gray-100 text-gray-600">
                                    Download CV
                                </a>
                            @endif

                            <form method="POST" action="{{ route('applications.destroy', $application->job_id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to withdraw from this application?')"
                                    class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border border border-red-600 text-red-600 hover:bg-red-50 mt-4">
                                    Withdraw
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection