@extends('layouts.master')

@section('content')

    <main class="mx-auto max-w-3xl px-4 py-8">
        <a href="{{ route('employer.profile.show') }}" class="text-emerald-600 hover:text-emerald-800 mb-6 inline-block">
            ← Back to Profile
        </a>

        <h1 class="text-2xl font-bold text-gray-900 mb-8">Edit Profile</h1>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <form method="POST" action="{{ route('employer.profile.update', $user->user_id) }}">
                @csrf
                @method('PATCH')

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input name="first_name" value="{{ old('first_name', $user->first_name) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contact</label>
                            <input name="contact" value="{{ old('contact', $user->contact) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('contact')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input name="location" value="{{ old('location', $user->location) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-gray-50 px-6 py-4 flex flex-wrap justify-between items-center gap-3">
                    <div class="flex gap-3">
                        @if($user->hasPhoto())
                            <button type="button" onclick="document.getElementById('remove-photo-form').submit()"
                                class="inline-block px-4 py-2 text-sm font-medium text-red-700 border border-red-600 rounded-md cursor-pointer hover:border-red-700 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500/30">
                                Remove Photo
                            </button>
                        @endif

                        <a href="{{ route('password.edit') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 border-gray-300 border rounded-md hover:bg-gray-200">
                            Change Password
                        </a>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('employer.profile.show') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>

                        <button type="submit"
                            class="px-6 py-2 bg-emerald-600 text-white rounded-md text-sm font-medium hover:bg-emerald-700">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>

            @if($user->hasPhoto())
                <form id="remove-photo-form" method="POST" action="{{ route('profile.remove-photo') }}">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </main>

@endsection