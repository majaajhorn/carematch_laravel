@extends('layouts.master')

@section('content')

    <!-- Main Content -->
    <main class="mx-auto max-w-3xl px-4 py-8">
        <!-- Back Link -->
        <a href="/carers" class="text-blue-600 hover:text-blue-800 mb-6 inline-block">
            ← Back to Browse Carers
        </a>

        <!-- Page Title -->
        <h1 class="text-2xl font-bold text-gray-900 mb-8">{{ $user->first_name }} {{ $user->last_name }}'s Profile</h1>

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <!-- Profile Photo Section -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-4">
                    <!-- Profile Photo -->
                    <div class="relative">
                        @if($user->hasPhoto())
                            <img src="{{ $user->photo_url }}" alt="Profile Photo" class="w-20 h-20 rounded-full object-cover">
                        @else
                            <div class="w-20 h-20 bg-gray-300 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Basic Info -->
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}
                        </h2>
                        @if($user->location)
                            <p class="text-gray-600">📍 {{ $user->location }}</p>
                        @endif
                    </div>

                    {{-- Rating Summary --}}
                    @if($jobseeker->getTotalReviews() > 0)
                        <div class="flex items-center mt-2 gap-2">
                            {{-- Stars --}}
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($jobseeker->getAverageRating()))
                                        <span class="text-yellow-400">⭐</span>
                                    @else
                                        <span class="text-gray-300">⭐</span>
                                    @endif
                                @endfor
                            </div>
                            {{-- Rating number and count --}}
                            <span class="text-sm text-gray-600">
                                {{ number_format($jobseeker->getAverageRating(), 1) }}
                                ({{ $jobseeker->getTotalReviews() }} {{ Str::plural('review', $jobseeker->getTotalReviews()) }})
                            </span>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 mt-2">No reviews yet</p>
                    @endif

                    <!-- Contact Button -->
                    <div class="ml-auto">
                        <a href="mailto: {{ $user->email }}"
                            class="bg-emerald-600 hover:bg-emerald-700 px-6 py-2 rounded-md text-sm text-white font-medium">Contact
                            Carer</a>
                    </div>
                </div>
            </div>

            {{-- Review Buttons --}}
            <div class="flex gap-3">
                {{-- View Reviews Button --}}
                <a href="{{ route('reviews.show', $jobseeker) }}"
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50 text-center">
                    📝 Reviews
                    @if($jobseeker->getTotalReviews() > 0)
                        ({{ $jobseeker->getTotalReviews() }})
                    @endif
                </a>

                {{-- Write Review Button (only for employers who haven't reviewed) --}}
                @if(Auth::check() && Auth::user()->isEmployer())
                    @php
                        $hasReviewed = App\Models\Review::where('jobseeker_id', $jobseeker->id)
                            ->where('employer_id', Auth::user()->user_id)
                            ->exists();
                    @endphp

                    @if(!$hasReviewed)
                        <a href="{{ route('reviews.create', $jobseeker) }}"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md text-sm text-center">
                            ⭐ Rate
                        </a>
                    @else
                        <span class="px-4 py-2 bg-gray-100 text-gray-500 rounded-md text-sm text-center">
                            ✓ Reviewed
                        </span>
                    @endif
                @endif
            </div>

            <!-- Profile Information Section -->
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Profile Information</h2>
                </div>

                <!-- Profile Fields -->
                <div class="space-y-6">
                    <!-- Row 1: Email & Contact -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Email</label>
                            <a href="mailto: {{ $user->email }}" class="text-emerald-600">{{ $user->email }}</a>
                        </div>
                        @if($user->contact)
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Contact</label>
                                <!-- <p class="text-gray-900">{{ $user->contact }}</p> -->
                                <a href="tel: {{ $user->contact }}" class="text-emerald-600"> {{ $user->contact }} </a>
                            </div>
                        @endif
                    </div>

                    <!-- Row 2: Gender & English Level -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Gender</label>
                            <p class="text-gray-900">
                                {{ $jobseeker->gender ? ucfirst($jobseeker->gender) : 'Not specified' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">English Level</label>
                            <p class="text-gray-900">
                                {{ $jobseeker->english_level ? ucfirst($jobseeker->english_level) : 'Not specified' }}
                            </p>
                        </div>
                    </div>

                    <!-- Live-in Experience -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Live-in Experience</label>
                        <p class="text-gray-900">
                            {{ $jobseeker->live_in_experience ? ucfirst(str_replace('_', ' ', $jobseeker->live_in_experience)) : 'Not specified' }}
                        </p>
                    </div>

                    <!-- Driving License -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Driving License</label>
                        <p class="text-gray-900">
                            @if($jobseeker->driving_license)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Yes
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    No
                                </span>
                            @endif
                        </p>
                    </div>

                    <!-- About Yourself -->
                    @if($jobseeker->about_yourself)
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">About</label>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-900">{{ $jobseeker->about_yourself }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Qualifications -->
                    @if($jobseeker->qualifications->count() > 0)
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Qualifications</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($jobseeker->qualifications as $qualification)
                                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm">
                                        {{ $qualification->qualification_name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Qualifications</label>
                            <p class="text-gray-500 italic">No qualifications listed</p>
                        </div>
                    @endif

                    <!-- Experience -->
                    @if($jobseeker->experiences->count() > 0)
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Care Experience</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($jobseeker->experiences as $experience)
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
                                        {{ $experience->job_title }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Care Experience</label>
                            <p class="text-gray-500 italic">No experience listed</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection