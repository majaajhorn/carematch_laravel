{{-- resources/views/reviews/show.blade.php --}}
@extends('layouts.master')

@section('content')

    <!-- Main Content -->
    <main class="mx-auto max-w-3xl px-4 py-8">
        <!-- Back Link -->
        <a href="{{ route('jobseeker.show', $jobseeker->id) }}"
            class="text-emerald-600 hover:text-emerald-800 mb-6 inline-block">
            ← Back to Profile
        </a>

        <!-- Page Title -->
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Reviews for {{ $jobseeker->authParent->first_name }}
            {{ $jobseeker->authParent->last_name }}
        </h1>

        <div class="mx-auto max-w-4xl">
            {{-- Jobseeker Summary Card --}}
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <div class="flex items-center justify-between">
                    {{-- Left side: Jobseeker info --}}
                    <div class="flex items-center space-x-4">
                        {{-- Profile Photo --}}
                        <div class="flex-shrink-0">
                            @if($jobseeker->authParent->hasPhoto())
                                <img class="h-20 w-20 rounded-full object-cover" src="{{ $jobseeker->authParent->photo_url }}"
                                    alt="Profile photo">
                            @else
                                <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-2xl font-medium text-gray-700">
                                        {{ substr($jobseeker->authParent->first_name, 0, 1) }}{{ substr($jobseeker->authParent->last_name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Jobseeker Details --}}
                        <div class="text-sm text-gray-500">
                            <span>English Level: </span>
                            <span class="text-gray-900">
                                {{ $jobseeker->english_level ? ucfirst($jobseeker->english_level) : 'Not specified' }}
                            </span>
                            <span> | Experience: </span>
                            <span class="text-gray-900">
                                {{ $jobseeker->live_in_experience ? ucfirst(str_replace('_', ' ', $jobseeker->live_in_experience)) : 'Not specified' }}
                            </span>
                        </div>
                    </div>

                    {{-- Right side: Rating summary --}}
                    <div class="text-right">
                        @if($jobseeker->getTotalReviews() > 0)
                            <div class="text-3xl font-bold text-gray-900">
                                {{ number_format($jobseeker->getAverageRating(), 1) }}
                            </div>
                            <div class="text-yellow-500 text-lg flex">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($jobseeker->getAverageRating()))
                                        <span>★</span>
                                    @else
                                        <span class="text-gray-300">★</span>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500">
                                {{ $jobseeker->getTotalReviews() }} {{ Str::plural('review', $jobseeker->getTotalReviews()) }}
                            </p>
                        @else
                            <div class="text-gray-400">
                                <p class="text-lg">No reviews yet</p>
                                <p class="text-sm">Be the first to review!</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <a href="{{ route('jobseeker.show', $jobseeker->id) }}"
                        class="text-emerald-600 hover:text-emerald-900 text-sm font-medium">
                        ← Back to Profile
                    </a>

                    {{-- Only show "Write Review" button if user is an employer and hasn't reviewed yet --}}
                    @if(Auth::check() && Auth::user()->isEmployer())
                        @php
                            $hasReviewed = $reviews->where('employer_id', Auth::user()->user_id)->count() > 0;
                        @endphp

                        @if(!$hasReviewed)
                            <a href="{{ route('reviews.create', $jobseeker) }}"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
                                Write a Review
                            </a>
                        @else
                            <span class="text-sm text-gray-500">You have already reviewed this jobseeker</span>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Reviews List --}}
            @if($reviews->count() > 0)
                <div class="space-y-6">
                    @foreach($reviews as $review)
                        <div class="bg-white shadow rounded-lg p-6">
                            {{-- Review Header --}}
                            <div class="flex items-start justify-between mb-4">
                                {{-- Employer Info --}}
                                <div class="flex items-center space-x-3">
                                    {{-- Employer Avatar --}}
                                    <div class="flex-shrink-0">
                                        @if($review->employer->authParent->hasPhoto())
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ $review->employer->authParent->photo_url }}" alt="Employer photo">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">
                                                    {{ substr($review->employer->authParent->first_name, 0, 1) }}{{ substr($review->employer->authParent->last_name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Employer Name and Date --}}
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

                                {{-- Star Rating --}}
                                <div class="flex items-center">
                                    <div class="text-yellow-500 flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating_star)
                                                <span>★</span>
                                            @else
                                                <span class="text-gray-300">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600">{{ $review->rating_star }}/5</span>
                                </div>
                            </div>

                            {{-- Review Text --}}
                            @if($review->review_description)
                                <div class="text-gray-700 leading-relaxed">
                                    {{ $review->review_description }}
                                </div>
                            @else
                                <div class="text-gray-500 italic">
                                    No written review provided.
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                {{-- No Reviews Yet --}}
                <div class="bg-white shadow rounded-lg p-12 text-center">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No reviews yet</h3>
                    <p class="text-gray-500 mb-6">This jobseeker hasn't received any reviews yet.</p>

                    @if(Auth::check() && Auth::user()->isEmployer())
                        <a href="{{ route('reviews.create', $jobseeker) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700">
                            Write the First Review
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </main>
@endsection