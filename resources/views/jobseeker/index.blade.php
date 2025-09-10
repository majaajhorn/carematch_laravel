@extends('layouts.master')

@section('content')

    <!-- Main Content -->
    <main class="mx-auto max-w-3xl px-4 py-8">
        <!-- Back Link -->
        <a href="{{ route('carers') }}" class="text-emerald-600 hover:text-emerald-800 mb-6 inline-block">
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

                        <!-- Location -->
                        @if($user->location)
                            <div class="flex items-center text-gray-600 mt-1">
                                <!-- Location SVG Icon -->
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM12 11.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                </svg>
                                <span>{{ $user->location }}</span>
                            </div>
                        @endif

                        <!-- Rating Summary (moved here from buttons section) -->
                        @php
                            $avg = (float) $jobseeker->getAverageRating();
                            $count = (int) $jobseeker->getTotalReviews();
                            $percent = max(0, min(100, ($avg / 5) * 100));   
                        @endphp

                        @if ($count > 0)
                            <div class="flex items-center gap-2 mt-1">
                                <div class="relative inline-block align-middle"
                                    aria-label="Rating {{ number_format($avg, 1) }} out of 5" style="line-height:0;">
                                    {{-- Base: 5 gray stars --}}
                                    <div class="flex text-gray-300">
                                        @for ($i = 0; $i < 5; $i++)
                                            <svg class="w-4 h-4 block shrink-0" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.036a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118L10 13.347l-2.985 2.126c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L3.38 8.72c-.783-.57-.38-1.81.588-1.81H7.43a1 1 0 00.95-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>

                                    {{-- Overlay: 5 yellow stars, clipped to exact percentage --}}
                                    <div class="absolute inset-0 pointer-events-none"
                                        style="clip-path: inset(0 {{ 100 - $percent }}% 0 0);">
                                        <div class="flex text-yellow-400">
                                            @for ($i = 0; $i < 5; $i++)
                                                <svg class="w-4 h-4 block shrink-0" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.036a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118L10 13.347l-2.985 2.126c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L3.38 8.72c-.783-.57-.38-1.81.588-1.81H7.43a1 1 0 00.95-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <span class="text-sm text-gray-600">
                                    {{ number_format($avg, 1) }}
                                    ({{ $count }} {{ \Illuminate\Support\Str::plural('review', $count) }})
                                </span>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 mb-2">No reviews yet</p>
                        @endif

                        <!-- Review Status & Rate Button (moved here from buttons section) -->
                        @if(Auth::check() && Auth::user()->isEmployer())
                            @php
                                $hasReviewed = $jobseeker->hasBeenReviewedBy(Auth::user()->user_id);
                            @endphp

                            <div class="flex items-center gap-3">
                                @if($hasReviewed)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                                        Reviewed
                                    </span>
                                @else
                                    <a href="{{ route('reviews.create', $jobseeker) }}"
                                        class="inline-flex items-center px-3 py-1 border border-emerald-600 hover:bg-emerald-200 text-emerald-600  rounded-md text-sm font-medium mt-2">
                                        Rate
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Contact Button -->
                    <div class="ml-auto">
                        <a href="mailto: {{ $user->email }}"
                            class="bg-emerald-600 hover:bg-emerald-700 px-6 py-2 rounded-md text-sm text-white font-medium">Contact
                            Carer
                        </a>
                    </div>
                </div>
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

        <!-- Reviews & Ratings Section (NEW - Added here like in the image) -->
        <div class="mt-10 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Reviews & Ratings</h2>

            @if($count > 0)
                <!-- Rating Summary -->
                <div class="flex items-center mb-6 gap-2">
                    <div class="relative inline-block align-middle" style="line-height:0;">
                        {{-- Base: gray stars --}}
                        <div class="flex text-gray-300">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-6 h-6 block" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07
                                                                                                                                                                                                                                                                                            3.292a1 1 0 00.95.69h3.462c.969 0
                                                                                                                                                                                                                                                                                            1.371 1.24.588 1.81l-2.802 2.036a1
                                                                                                                                                                                                                                                                                            1 0 00-.364 1.118l1.07 3.292c.3.921-.755
                                                                                                                                                                                                                                                                                            1.688-1.54 1.118L10 13.347l-2.985
                                                                                                                                                                                                                                                                                            2.126c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1
                                                                                                                                                                                                                                                                                            1 0 00-.364-1.118L3.38 8.72c-.783-.57-.38-1.81.588-1.81H7.43a1
                                                                                                                                                                                                                                                                                            1 0 00.95-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        {{-- Overlay --}}
                        <div class="absolute inset-0 overflow-hidden" style="clip-path: inset(0 {{ 100 - $percent }}% 0 0);">
                            <div class="flex text-yellow-400">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-6 h-6 block" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902
                                                                                                                                                                                                                                                                                                0l1.07 3.292a1 1 0 00.95.69h3.462c.969
                                                                                                                                                                                                                                                                                                0 1.371 1.24.588 1.81l-2.802
                                                                                                                                                                                                                                                                                                2.036a1 1 0 00-.364 1.118l1.07
                                                                                                                                                                                                                                                                                                3.292c.3.921-.755 1.688-1.54
                                                                                                                                                                                                                                                                                                1.118L10 13.347l-2.985
                                                                                                                                                                                                                                                                                                2.126c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1
                                                                                                                                                                                                                                                                                                1 0 00-.364-1.118L3.38 8.72c-.783-.57-.38-1.81.588-1.81H7.43a1
                                                                                                                                                                                                                                                                                                1 0 00.95-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="ml-2">
                        <span class="text-lg font-semibold text-gray-900">
                            {{ number_format($avg, 1) }}
                        </span>
                        <span class="text-sm text-gray-600">
                            ({{ $count }} {{ \Illuminate\Support\Str::plural('review', $count) }})
                        </span>
                    </div>
                </div>

                <!-- Recent Reviews List (show up to 3 most recent) -->
                @if(isset($recentReviews) && $recentReviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentReviews as $review)
                            @php
                                $reviewPercent = max(0, min(100, ($review->rating_star / 5) * 100));
                            @endphp
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-3">
                                    <!-- Employer Info -->
                                    <div class="flex items-center space-x-3">
                                        <!-- Employer Avatar -->
                                        <div class="flex-shrink-0">
                                            @if($review->employer->authParent->hasPhoto())
                                                <img class="h-8 w-8 rounded-full object-cover"
                                                    src="{{ $review->employer->authParent->photo_url }}" alt="Employer photo">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <span class="text-xs font-medium text-gray-700">
                                                        {{ substr($review->employer->authParent->first_name, 0, 1) }}{{ substr($review->employer->authParent->last_name, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Name + Date -->
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">
                                                {{ $review->employer->authParent->first_name }}
                                                {{ $review->employer->authParent->last_name }}
                                            </h4>
                                            <p class="text-xs text-gray-500">
                                                {{ $review->created_at->format('F j, Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Stars -->
                                    <div class="flex text-yellow-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating_star)
                                                <span class="text-sm">★</span>
                                            @else
                                                <span class="text-sm text-gray-300">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                <!-- Review text -->
                                @if($review->review_description)
                                    <p class="text-gray-700 text-sm leading-relaxed">
                                        {{ $review->review_description }}
                                    </p>
                                @else
                                    <p class="text-gray-500 italic text-sm">
                                        No written review provided.
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Link to see all reviews if there are more -->
                    @if($count > 3)
                        <div class="mt-4 text-center">
                            <a href="{{ route('reviews.show', $jobseeker) }}"
                                class="text-emerald-600 hover:text-emerald-800 text-sm font-medium">
                                View All {{ $count }} Reviews →
                            </a>
                        </div>
                    @endif
                @endif
            @else
                <p class="text-gray-500 text-center py-8">No reviews yet</p>
            @endif

            <div>
                {{ $recentReviews->links() }}
            </div>
        </div>

    </main>
@endsection