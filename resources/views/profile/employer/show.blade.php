@extends('layouts.master')

@section('content')

    <main class="mx-auto max-w-3xl px-4 py-8">

        <!-- Page Title -->
        <h1 class="text-2xl font-bold text-gray-900 mb-8">My Profile</h1>

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">

            <!-- Profile Photo Section -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-6">

                    <!-- Profile Photo + Change button -->
                    <div class="flex flex-col items-center">
                        @if($user->hasPhoto())
                            <img src="{{ $user->photo_url }}" alt="Profile Photo" class="w-24 h-24 rounded-full object-cover">
                        @else
                            <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4
                                                                                                                                                         1.79-4 4 1.79 4 4 4zm0 2c-2.67
                                                                                                                                                         0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </div>
                        @endif

                        <!-- Upload Photo Form -->
                        <form method="POST" action="{{ route('profile.upload-photo') }}" enctype="multipart/form-data"
                            class="mt-3">
                            @csrf
                            <input type="file" name="photo" id="avatar" accept="image/*" class="hidden"
                                onchange="this.form.submit()">
                            <label for="avatar"
                                class="inline-block px-4 py-2 text-sm font-medium text-emerald-700 border border-emerald-600 rounded-md cursor-pointer hover:border-emerald-700 hover:text-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                                {{ $user->hasPhoto() ? 'Change Photo' : 'Upload New Photo' }}
                            </label>
                        </form>
                    </div>

                    <!-- Edit Button -->
                    <div class="ml-auto">
                        <a href="{{ route('employer.profile.edit') }}"
                            class="inline-block px-6 py-2 text-sm font-medium text-white bg-emerald-600 rounded-md hover:bg-emerald-700">
                            Edit Profile
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
                    <!-- Row 2: Location & Contact -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Location</label>
                            <p class="text-gray-900">{{ $user->location ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Contact</label>
                            <p class="text-gray-900">{{ $user->contact ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection