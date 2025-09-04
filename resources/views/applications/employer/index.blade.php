@extends('layouts.master')

@section('content')

    <div class="max-w-6xl mx-auto p-6">
        <a href="{{ url()->previous() }}" class="text-emerald-600 hover:text-emerald-800 mb-6 inline-block">
            ← Back
        </a>
        <h1 class="text-3xl font-bold mb-6">All Applications</h1>

        @php
            // fallbacks in case the view is reached through employerIndex delegating to filter
            $st = $status ?? request('status', 'all');
            $ord = $order ?? request('order', 'desc');
        @endphp

        {{-- Filter + Sort --}}
        <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-xl p-4 mb-6">
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-800">Filter by status:</span>

                <a href="{{ route('applications.employer.index', ['status' => 'all', 'order' => $ord]) }}"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium border
                                                      {{ $st === 'all' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                    All
                </a>

                <a href="{{ route('applications.employer.index', ['status' => 'pending', 'order' => $ord]) }}"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium border
                                                      {{ $st === 'pending' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                    Pending
                </a>

                <a href="{{ route('applications.employer.index', ['status' => 'approved', 'order' => $ord]) }}"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium border
                                                      {{ $st === 'approved' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                    Approved
                </a>

                <a href="{{ route('applications.employer.index', ['status' => 'rejected', 'order' => $ord]) }}"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium border
                                                      {{ $st === 'rejected' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                    Rejected
                </a>
            </div>

            <form method="GET" action="{{ route('applications.employer.index') }}" class="flex items-center gap-2">
                <input type="hidden" name="status" value="{{ $st }}">
                <span class="text-sm font-semibold text-gray-800">Sort by:</span>
                <select name="order" class="border border-gray-300 rounded-lg px-2 py-1.5 text-sm"
                    onchange="this.form.submit()">
                    <option value="desc" @selected($ord === 'desc')>Newest First</option>
                    <option value="asc" @selected($ord === 'asc')>Oldest First</option>
                </select>
            </form>
        </div>

        {{-- Table --}}
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

                            {{-- Status --}}
                            <td class="px-6 py-0 align-middle">
                                <div class="h-10 flex items-center">
                                    <span
                                        class="inline-flex h-8 items-center px-3 rounded-full text-xs font-semibold {{ $application->status->getBadgeClass() }}">
                                        {{ $application->status }}
                                    </span>
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-0 w-[260px] whitespace-nowrap align-middle">
                                <div class="h-10 flex items-center gap-2">
                                    @php
                                        $btn = 'inline-flex h-8 min-w-[84px] items-center justify-center rounded-md px-3 text-xs font-medium text-center leading-none';
                                    @endphp

                                    {{-- View --}}
                                    <a href="{{ route('applications.employer.show', $application) }}"
                                        class="{{ $btn }} bg-emerald-600 text-white hover:bg-emerald-700 inline-flex items-center justify-center">
                                        View
                                    </a>

                                    @if($application->isPending())
                                        {{-- Approve --}}
                                        <form method="POST" action="{{ route('applications.approve', $application) }}"
                                            class="inline m-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="{{ $btn }} bg-amber-500 text-white hover:bg-amber-600"
                                                onclick="return confirm('Approve this application?')">
                                                Approve
                                            </button>
                                        </form>

                                        {{-- Reject --}}
                                        <form method="POST" action="{{ route('applications.reject', $application) }}"
                                            class="inline m-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="{{ $btn }} bg-red-600 text-white hover:bg-red-700"
                                                onclick="return confirm('Reject this application?')">
                                                Reject
                                            </button>
                                        </form>

                                    @elseif($application->status === \App\Enums\ApplicationStatus::Approved)
                                        {{-- Only Reject --}}
                                        <form method="POST" action="{{ route('applications.reject', $application) }}"
                                            class="inline m-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="{{ $btn }} bg-red-600 text-white hover:bg-red-700"
                                                onclick="return confirm('Reject this application?')">
                                                Reject
                                            </button>
                                        </form>

                                    @elseif($application->status === \App\Enums\ApplicationStatus::Rejected)
                                        {{-- Only Approve --}}
                                        <form method="POST" action="{{ route('applications.approve', $application) }}"
                                            class="inline m-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="{{ $btn }} bg-amber-500 text-white hover:bg-amber-600"
                                                onclick="return confirm('Approve this application?')">
                                                Approve
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-8 text-center text-gray-500" colspan="5">No applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $applications->links() }}
        </div>


    </div>
@endsection