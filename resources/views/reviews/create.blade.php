{{-- resources/views/reviews/create.blade.php --}}
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
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Write a Review</h1>

        {{-- Jobseeker Info Card --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center gap-4">
                {{-- Profile Photo --}}
                <div class="relative">
                    @if($jobseeker->authParent->hasPhoto())
                        <img src="{{ $jobseeker->authParent->photo_url }}" alt="Profile Photo"
                            class="w-16 h-16 rounded-full object-cover">
                    @else
                        <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Jobseeker Details --}}
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        {{ $jobseeker->authParent->first_name }} {{ $jobseeker->authParent->last_name }}
                    </h3>
                    <div>
                        <span class="text-gray-600">Email:</span>
                        <span class="text-gray-900 font-medium ml-1">{{ $jobseeker->authParent->email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Contact:</span>
                        <span class="text-gray-900 font-medium ml-1">{{ $jobseeker->authParent->contact }}</span>
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
                        placeholder=" Share your experience working with this jobseeker..."
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('review_description') }}</textarea>

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
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
        </div>
    </main>


@endsection