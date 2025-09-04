@extends('layouts.master')

@section('content')

    <div class="max-w-4xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">My Job Posts</h1>
            <a href="{{ route('jobs.create') }}"
                class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 font-medium">
                Post New Job
            </a>
        </div>

        <div class="space-y-6">
            @foreach ($jobs as $job)
                @php
                    $isEditing = request('edit') == $job->id;
                @endphp

                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">

                    <!-- Ako korisnik klikne da se editira-->

                    @if ($isEditing)
                        {{-- EDIT MODE --}}
                        <form action="{{ route('jobs.update', $job->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Job Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                    <input type="text" name="title" value="{{ old('title', $job->title) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                </div>

                                <!-- Location -->
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <input type="text" name="location" value="{{ old('location', $job->location) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Salary -->
                                <div>
                                    <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Salary</label>
                                    <input type="text" name="salary" value="{{ old('salary', $job->salary) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                </div>

                                <!-- Salary Period -->
                                <div>
                                    <label for="salary_period" class="block text-sm font-medium text-gray-700 mb-1">Salary
                                        Period</label>
                                    <select name="salary_period"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                        <option value="weekly" {{ $job->salary_period == 'weekly' ? 'selected' : '' }}>Weekly
                                        </option>
                                        <option value="monthly" {{ $job->salary_period == 'monthly' ? 'selected' : '' }}>Monthly
                                        </option>
                                    </select>
                                </div>

                                <!-- Employment Type -->
                                <div>
                                    <label for="employment_type" class="block text-sm font-medium text-gray-700 mb-1">Employment
                                        Type</label>
                                    <select name="employment_type"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                        <option value="full_time" {{ $job->employment_type == 'full_time' ? 'selected' : '' }}>
                                            Full Time</option>
                                        <option value="part_time" {{ $job->employment_type == 'part_time' ? 'selected' : '' }}>
                                            Part Time</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Job
                                    Description</label>
                                <textarea name="description" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">{{ old('description', $job->description) }}</textarea>
                            </div>

                            <!-- Requirements -->
                            <div>
                                <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Requirements</label>
                                <textarea name="requirements" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">{{ old('requirements', $job->requirements) }}</textarea>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3 pt-4">
                                <button type="submit"
                                    class="px-4 py-2 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700">
                                    Save Changes
                                </button>
                                <a href="{{ route('jobs.show-my-jobs') }}"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-400">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    @else
                        {{-- VIEW MODE --}}
                        <!-- Job Title and Salary -->
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">
                                <a href="{{ route('jobs.show', $job) }}" class="hover:text-emerald-600">
                                    {{ $job->title }}
                                </a>
                            </h2>
                            <span class="text-lg font-bold text-emerald-600">£
                                {{ $job->salary }} {{ (string) $job->salary_period }}
                            </span>
                        </div>

                        <!-- Employment Type and Location -->
                        <div class="flex flex-wrap gap-4 mb-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                                {{ ucfirst(str_replace('_', ' ', (string) $job->employment_type)) }}
                            </span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                📍 {{ $job->location }}
                            </span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                Posted {{ $job->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-900 mb-2">Description:</h3>
                            <p class="text-gray-700 leading-relaxed">
                                {{ $job->description ? Str::limit($job->description, 200) : 'No description available.' }}
                            </p>
                        </div>

                        <!-- Requirements -->
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-900 mb-2">Requirements:</h3>
                            <p class="text-gray-700 leading-relaxed">
                                {{ $job->requirements ? Str::limit($job->requirements, 150) : 'No specific requirements listed.' }}
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-3">
                            <a href="{{ route('jobs.show', $job->id) }}"
                                class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border bg-emerald-600 text-white hover:bg-emerald-700">
                                View Details
                            </a>
                            <a href="{{ route('jobs.show-my-jobs', ['edit' => $job->id]) }}"
                                class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border bg-emerald-300 text-gray-900 hover:bg-emerald-700">
                                Edit
                            </a>

                            <!-- Brisanje posla -->
                            <form method="POST" action="{{ route('jobs.destroy', $job->id) }}" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this job post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border border bg-red-400 text-white hover:bg-red-600 mt-4">
                                    Delete
                                </button>
                            </form>

                            {{-- Activate / Deactivate --}}
                            @if ($job->active) {{-- job IS active -> show Deactivate --}}
                                <form method="POST" action="{{ route('jobs.deactivate', $job->id) }}" class="inline"
                                    onsubmit="return confirm('Are you sure you want to deactivate this job post?')">
                                    @csrf
                                    <button type="submit"
                                        class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border  text-white bg-emerald-900 hover:bg-gray-700 mt-4">
                                        Deactivate
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('jobs.activate', $job->id) }}" class="inline"
                                    onsubmit="return confirm('Are you sure you want to activate this job post?')">
                                    @csrf
                                    <button type="submit"
                                        class="flex h-10 min-w-[120px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border border border-emerald-700 text-emerald-600 hover:bg-emerald-50 mt-4">
                                        Activate
                                    </button>
                                </form>
                            @endif

                            <!-- View Applications -->
                            @php
                                $appsCount = $job->applications_count ?? $job->applications()->count();
                            @endphp
                            <a href="{{ route('applications.employer.by-job', $job) }}"
                                class="flex h-10 min-w-[160px] items-center justify-center rounded-lg px-4 text-sm font-medium text-center box-border bg-amber-300 text-gray-800 hover:bg-amber-700">
                                View Applications ({{ $appsCount }})
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
            {{ $jobs->links() }}

            @if($jobs->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg mb-4">You haven't posted any jobs yet.</p>
                    <a href="/jobs/create"
                        class="bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 font-medium">
                        Post Your First Job
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection