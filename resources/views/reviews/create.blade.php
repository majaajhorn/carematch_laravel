{{-- resources/views/reviews/create.blade.php --}}
@extends('layouts.master')

@section('content')

    <!-- Main Content -->
    <main class="mx-auto max-w-3xl px-4 py-8">
        <!-- Back Link -->
        <a href="{{ route('jobseeker.show', $jobseeker->id) }}" class="text-blue-600 hover:text-blue-800 mb-6 inline-block">
            ← Back to Profile
        </a>

        <!-- Page Title -->
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Write a Review</h1>

        <div> class="mx-auto max-w-2xl">
            {{-- Jobseeker Info Card --}}
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <div class="flex items-center space-x-4">
                    {{-- Profile Photo --}}
                    <div class="flex-shrink-0">
                        @if($jobseeker->authParent->hasPhoto())
                            <img class="h-16 w-16 rounded-full object-cover" src="{{ $jobseeker->authParent->photo_url }}"
                                alt="Profile photo">
                        @else
                            <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-xl font-medium text-gray-700">
                                    {{ substr($jobseeker->authParent->first_name, 0, 1) }}{{ substr($jobseeker->authParent->last_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Jobseeker Details --}}
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ $jobseeker->authParent->first_name }} {{ $jobseeker->authParent->last_name }}
                        </h3>
                        <p class="text-sm text-gray-500">{{ $jobseeker->authParent->location }}</p>
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
                </div>
            </div>

            {{-- Review Form --}}
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('reviews.store', $jobseeker) }}">
                    @csrf {{-- Laravel security token --}}

                    {{-- Star Rating --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Rating *
                        </label>

                        {{-- Star Rating Input - Pure Tailwind, no JavaScript needed --}}
                        <div class="flex flex-row-reverse justify-end items-center gap-1 mb-2">
                            {{-- Star 5 --}}
                            <input type="radio" id="star5" name="rating_star" value="5" class="peer/star5 sr-only" {{ old('rating_star') == '5' ? 'checked' : '' }}>
                            <label for="star5"
                                class="cursor-pointer text-3xl text-gray-300 hover:text-yellow-500 peer-checked/star5:text-yellow-500 peer-hover/star5:text-yellow-500"
                                title="5 stars">★</label>

                            {{-- Star 4 --}}
                            <input type="radio" id="star4" name="rating_star" value="4" class="peer/star4 sr-only" {{ old('rating_star') == '4' ? 'checked' : '' }}>
                            <label for="star4"
                                class="cursor-pointer text-3xl text-gray-300 hover:text-yellow-500 peer-checked/star4:text-yellow-500 peer-hover/star4:text-yellow-500 peer-checked/star5:text-yellow-500 peer-hover/star5:text-yellow-500"
                                title="4 stars">★</label>

                            {{-- Star 3 --}}
                            <input type="radio" id="star3" name="rating_star" value="3" class="peer/star3 sr-only" {{ old('rating_star') == '3' ? 'checked' : '' }}>
                            <label for="star3"
                                class="cursor-pointer text-3xl text-gray-300 hover:text-yellow-500 peer-checked/star3:text-yellow-500 peer-hover/star3:text-yellow-500 peer-checked/star4:text-yellow-500 peer-hover/star4:text-yellow-500 peer-checked/star5:text-yellow-500 peer-hover/star5:text-yellow-500"
                                title="3 stars">★</label>

                            {{-- Star 2 --}}
                            <input type="radio" id="star2" name="rating_star" value="2" class="peer/star2 sr-only" {{ old('rating_star') == '2' ? 'checked' : '' }}>
                            <label for="star2"
                                class="cursor-pointer text-3xl text-gray-300 hover:text-yellow-500 peer-checked/star2:text-yellow-500 peer-hover/star2:text-yellow-500 peer-checked/star3:text-yellow-500 peer-hover/star3:text-yellow-500 peer-checked/star4:text-yellow-500 peer-hover/star4:text-yellow-500 peer-checked/star5:text-yellow-500 peer-hover/star5:text-yellow-500"
                                title="2 stars">★</label>

                            {{-- Star 1 --}}
                            <input type="radio" id="star1" name="rating_star" value="1" class="peer/star1 sr-only" {{ old('rating_star') == '1' ? 'checked' : '' }}>
                            <label for="star1"
                                class="cursor-pointer text-3xl text-gray-300 hover:text-yellow-500 peer-checked/star1:text-yellow-500 peer-hover/star1:text-yellow-500 peer-checked/star2:text-yellow-500 peer-hover/star2:text-yellow-500 peer-checked/star3:text-yellow-500 peer-hover/star3:text-yellow-500 peer-checked/star4:text-yellow-500 peer-hover/star4:text-yellow-500 peer-checked/star5:text-yellow-500 peer-hover/star5:text-yellow-500"
                                title="1 star">★</label>
                        </div>

                        {{-- Show validation error for rating --}}
                        @error('rating_star')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Review Description --}}
                    <div class="mb-6">
                        <label for="review_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Review (Optional)
                        </label>
                        <textarea id="review_description" name="review_description" rows="4"
                            placeholder="Share your experience working with this jobseeker..."
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('review_description') }}</textarea>

                        {{-- Show validation error for description --}}
                        @error('review_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <p class="mt-1 text-xs text-gray-500">Maximum 1000 characters</p>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="flex justify-end space-x-3">
                        <a href="{{ url()->previous() }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>


@endsection