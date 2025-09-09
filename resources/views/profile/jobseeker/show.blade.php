@extends('layouts.master')

@section('content')
    <!-- Main Content -->
    <main class="mx-auto max-w-3xl px-4 py-8">
        <!-- Error Message -->
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Page Title -->
        <h1 class="text-2xl font-bold text-gray-900 mb-8">My Profile</h1>

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

                    <!-- Upload Photo Form -->
                    <div>
                        <form method="POST" action="{{ route('profile.upload-photo') }}" enctype="multipart/form-data"
                            class="inline">
                            @csrf
                            <input type="file" name="photo" id="avatar" accept="image/*" class="hidden"
                                onchange="this.form.submit()">
                            <label for="avatar"
                                class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-md text-sm text-gray-700 border cursor-pointer">
                                {{ $user->hasPhoto() ? 'Change Photo' : 'Upload New Photo' }}
                            </label>
                        </form>

                        @if($user->hasPhoto())
                            <form method="POST" action="{{ route('profile.remove-photo') }}" class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-100 hover:bg-red-200 px-4 py-2 rounded-md text-sm text-red-700 border">
                                    Remove
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Edit Button -->
                    <div class="ml-auto mt-7">
                        <a href="{{ route('jobseeker.profile.edit') }}"
                            class="bg-emerald-600 hover:bg-emerald-700 px-6 py-2 rounded-md text-sm text-white">
                            Edit Profile
                        </a>

                        @php
                            $avg = (float) $jobseeker->getAverageRating();     // e.g. 4.5
                            $count = (int) $jobseeker->getTotalReviews();
                            $percent = max(0, min(100, ($avg / 5) * 100));   
                        @endphp

                        @if ($count > 0)
                            <div class="flex items-center mt-4 gap-2">
                                <div class="relative inline-block align-middle"
                                    aria-label="Rating {{ number_format($avg, 1) }} out of 5" style="line-height:0;">
                                    {{-- Base: 5 gray stars --}}
                                    <div class="flex text-gray-300">
                                        @for ($i = 0; $i < 5; $i++)
                                            <svg class="w-5 h-5 block shrink-0" viewBox="0 0 20 20" fill="currentColor"
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
                                                <svg class="w-5 h-5 block shrink-0" viewBox="0 0 20 20" fill="currentColor"
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
                            <p class="text-sm text-gray-500 mt-4">No reviews yet</p>
                        @endif
                    </div>
                </div>

                <!-- Change Password  -->
                <div class="flex gap-6 mt-4">
                    <a href="#" class="text-sm text-emerald-600 hover:text-emerald-800">Change Password</a>
                </div>
            </div>

            <!-- Profile Information Section -->
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Profile Information</h2>
                </div>

                <!-- Profile Fields -->
                <div class="space-y-6">
                    <!-- Row 1: Full Name & Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Full Name</label>
                            <p class="text-gray-900 font-medium">{{ $user->first_name }} {{ $user->last_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Email</label>
                            <p class="text-gray-900">{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Row 2: Gender & Location -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Gender</label>
                            <p class="text-gray-900">
                                {{ $jobseeker->gender ? ucfirst($jobseeker->gender) : 'Not specified' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Location</label>
                            <p class="text-gray-900">{{ $user->location ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Contact</label>
                        <p class="text-gray-900">{{ $user->contact ?? 'Not specified' }}</p>
                    </div>

                    <!-- English Level -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">English Level</label>
                        <p class="text-gray-900">
                            {{ $jobseeker->english_level ? ucfirst($jobseeker->english_level) : 'Not specified' }}
                        </p>
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
                            <label class="block text-sm text-gray-600 mb-2">About Yourself</label>
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
                            <p class="text-gray-500 italic">No qualifications added yet</p>
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
                            <p class="text-gray-500 italic">No experience added yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-10 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Reviews & Ratings</h2>

            @php
                $avg = (float) $jobseeker->getAverageRating();
                $count = (int) $jobseeker->getTotalReviews();
                $percent = max(0, min(100, ($avg / 5) * 100));
            @endphp

            @if($count > 0)
                <!-- Rating Summary -->
                <div class="flex items-center mb-6 gap-2">
                    <div class="relative inline-block align-middle" style="line-height:0;">
                        {{-- Base: gray stars --}}
                        <div class="flex text-gray-300">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 block" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07
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
                                    <svg class="w-5 h-5 block" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902
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
                    <span class="text-sm text-gray-600">
                        {{ number_format($avg, 1) }} ({{ $count }} {{ Str::plural('review', $count) }})
                    </span>
                </div>

                <!-- Reviews List -->
                <div class="space-y-6">
                    @foreach($reviews as $review)
                        @php
                            $percent = max(0, min(100, ($review->rating_star / 5) * 100));
                        @endphp
                        <div class="bg-white shadow rounded-lg p-6">
                            <div class="flex items-start justify-between mb-4">
                                <!-- Employer Info -->
                                <div class="flex items-center space-x-3">
                                    <!-- Employer Avatar -->
                                    <div class="flex-shrink-0">
                                        @if($review->employer->authParent->hasPhoto())
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ $review->employer->authParent->photo_url }}" alt="Employer photo">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">
                                                    {{ substr($review->employer->authParent->first_name, 0, 1) }}
                                                    {{ substr($review->employer->authParent->last_name, 0, 1) }}
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
                                <div class="relative inline-block align-middle mt-1" style="line-height:0;">
                                    <div class="flex text-gray-300">
                                        @for ($i = 0; $i < 5; $i++)
                                            <svg class="w-4 h-4 block" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921
                                                                                            1.902 0l1.07 3.292a1 1 0
                                                                                            00.95.69h3.462c.969 0 1.371
                                                                                            1.24.588 1.81l-2.802
                                                                                            2.036a1 1 0 00-.364 1.118l1.07
                                                                                            3.292c.3.921-.755
                                                                                            1.688-1.54 1.118L10 13.347l-2.985
                                                                                            2.126c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1
                                                                                            1 0 00-.364-1.118L3.38
                                                                                            8.72c-.783-.57-.38-1.81.588-1.81H7.43a1
                                                                                            1 0 00.95-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <div class="absolute inset-0 overflow-hidden"
                                        style="clip-path: inset(0 {{ 100 - $percent }}% 0 0);">
                                        <div class="flex text-yellow-400">
                                            @for ($i = 0; $i < 5; $i++)
                                                <svg class="w-4 h-4 block" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921
                                                                                                1.603-.921 1.902 0l1.07
                                                                                                3.292a1 1 0 00.95.69h3.462c.969
                                                                                                0 1.371 1.24.588
                                                                                                1.81l-2.802 2.036a1
                                                                                                1 0 00-.364 1.118l1.07
                                                                                                3.292c.3.921-.755
                                                                                                1.688-1.54 1.118L10
                                                                                                13.347l-2.985
                                                                                                2.126c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1
                                                                                                1 0 00-.364-1.118L3.38
                                                                                                8.72c-.783-.57-.38-1.81.588-1.81H7.43a1
                                                                                                1 0 00.95-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Review text -->
                            @if($review->review_description)
                                <p class="text-gray-700 leading-relaxed">
                                    {{ $review->review_description }}
                                </p>
                            @else
                                <p class="text-gray-500 italic">
                                    No written review provided.
                                </p>
                            @endif
                        </div>
                    @endforeach

                    <div class="mt-6">
                        {{ $reviews->links('pagination::tailwind') }}
                    </div>
                </div>
            @else
                <p class="text-gray-500">No reviews yet</p>
            @endif
        </div>

    </main>
@endsection