@extends('layouts.master')

@section('content')
    <main class="mx-auto max-w-md px-4 py-8">
        <a href="{{ url()->previous() }}" class="text-emerald-600 hover:text-emerald-800 mb-6 inline-block">← Back</a>

        <h1 class="text-2xl font-bold text-gray-900 mb-6">Change Password</h1>

        @if(session('success'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('password.profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="current_password">Current
                        Password</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="password">New Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="password_confirmation">Confirm New
                        Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        autocomplete="new-password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="flex justify-between">
                    <a href="{{ Auth::user()->isJobseeker() ? route('jobseeker.profile.show') : route('employer.profile.show') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-md text-sm font-medium hover:bg-emerald-700">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection