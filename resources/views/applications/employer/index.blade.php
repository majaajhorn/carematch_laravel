@extends('layouts.master')

@section('content')
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">All Applications</h1>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Job Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Applicant</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Applied Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($applications as $application)
                        <tr class="hover:bg-gray-50">
                            {{-- Job Title --}}
                            <td class="px-6 py-4">
                                <a href="{{ route('jobs.show', $application->job_id) }}"
                                    class="text-gray-900 font-medium hover:text-emerald-600">
                                    {{ $application->job?->title ?? 'Unknown Job' }}
                                </a>
                            </td>

                            {{-- Applicant --}}
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">
                                    {{ $application->jobseeker?->authParent?->first_name }}
                                    {{ $application->jobseeker?->authParent?->last_name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $application->jobseeker?->authParent?->email }}
                                </div>
                            </td>

                            {{-- Applied Date --}}
                            <td class="px-6 py-4 text-gray-700">
                                {{ $application->created_at->format('j M Y') }}
                            </td>

                            {{-- Status - Make badge same height as buttons --}}
                            <td class="px-6 py-0 align-middle">
                                <div class="h-10 flex items-center">
                                    <span
                                        class="inline-flex h-8 items-center px-3 rounded-full text-xs font-semibold {{ $application->status->getBadgeClass() }}">
                                        {{ $application->status }}
                                    </span>
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-0 w-56 whitespace-nowrap align-middle">
                                <div class="h-10 flex items-center gap-2">
                                    {{-- Define button classes once for consistency --}}
                                    @php
                                        $btn = 'inline-flex h-8 min-w-[80px] items-center justify-center rounded-md px-3 text-xs font-medium text-center box-border leading-none appearance-none select-none';
                                    @endphp

                                    {{-- View Button --}}
                                    <form method="GET" action="{{ route('jobseeker.show', $application->jobseeker_id) }}"
                                        class="inline m-0">
                                        <button type="submit" class="{{ $btn }} bg-emerald-600 text-white hover:bg-emerald-700">
                                            View
                                        </button>
                                    </form>

                                    {{-- Conditional Action Buttons based on status --}}
                                    @if($application->isPending())
                                        {{-- Show both Approve and Reject for pending applications --}}
                                        <form action="{{ route('applications.approve', $application) }}" method="POST"
                                            class="inline m-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="{{ $btn }} bg-amber-400 text-white hover:bg-amber-600"
                                                onclick="return confirm('Are you sure you want to approve this application?')">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('applications.reject', $application) }}" method="POST"
                                            class="inline m-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="{{ $btn }} bg-red-600 text-white hover:bg-red-700"
                                                onclick="return confirm('Are you sure you want to reject this application?')">
                                                Reject
                                            </button>
                                        </form>

                                    @elseif($application->status === \App\Enums\ApplicationStatus::Approved)
                                        {{-- Show only Reject for approved applications --}}
                                        <form action="{{ route('applications.reject', $application) }}" method="POST"
                                            class="inline m-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="{{ $btn }} bg-red-600 text-white hover:bg-red-700"
                                                onclick="return confirm('Are you sure you want to reject this application?')">
                                                Reject
                                            </button>
                                        </form>

                                    @elseif($application->status === \App\Enums\ApplicationStatus::Rejected)
                                        {{-- Show only Approve for rejected applications --}}
                                        <form action="{{ route('applications.approve', $application) }}" method="POST"
                                            class="inline m-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="{{ $btn }} bg-green-600 text-white hover:bg-green-700"
                                                onclick="return confirm('Are you sure you want to approve this application?')">
                                                Approve
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-8 text-center text-gray-500" colspan="5">No applications yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium bg-emerald-600 text-white hover:bg-emerald-700">
                Back to Dashboard
            </a>
        </div>
    </div>
@endsection