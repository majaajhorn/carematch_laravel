@extends('layouts.master')

@section('content')
    <div class="max-w-3xl mx-auto p-6">
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-6">
            <h1 class="text-xl font-semibold text-emerald-800">Application submitted successfully!</h1>
            <p class="mt-2 text-emerald-900">
                Thank you for applying<span class="whitespace-nowrap">.</span>
                @isset($job)
                    Your application for <span class="font-semibold">{{ $job->title }}</span> has been sent.
                @endisset
            </p>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                @isset($job)
                    <a href="{{ route('jobs.show', $job) }}"
                        class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                        View Job Details
                    </a>
                @endisset

                <a href="{{ route('applications.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Go to My Applications
                </a>
            </div>
        </div>
    </div>
@endsection