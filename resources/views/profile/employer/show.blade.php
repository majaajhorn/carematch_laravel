<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Top bar -->
    <header class="border-b border-gray-200 bg-white/70 backdrop-blur">
        <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
            <a href="/dashboard" class="inline-flex items-center gap-2 font-semibold text-gray-900">
                <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-600 text-white">CM</span>
                <span>CareMatch</span>
            </a>
            <nav class="hidden sm:flex items-center gap-8">
                <a href="/dashboard" class="text-sm font-medium text-gray-600 hover:text-gray-900">Home</a>

                {{-- Different navigation based on if the user is jobseeker or employer --}}
                @if(auth()->user()->isJobseeker())
                    <a href="/jobs" class="text-sm font-medium text-gray-600 hover:text-gray-900">Browse Jobs</a>
                    <a href="/jobs/saved" class="text-sm font-medium text-gray-600 hover:text-gray-900">Saved Jobs</a>
                    <a href="/my_applications" class="text-sm font-medium text-gray-600 hover:text-gray-900">My
                        Applications</a>
                @elseif(auth()->user()->isEmployer())
                    <a href="/carers" class="text-sm font-medium text-gray-600 hover:text-gray-900">Browse Carers</a>
                    <a href="/jobs/my-jobs" class="text-sm font-medium text-gray-600 hover:text-gray-900">My Job Posts</a>
                    <a href="/jobs/create" class="text-sm font-medium text-gray-600 hover:text-gray-900">Post a Job</a>
                @endif

                <a href="/profile" class="text-sm font-medium text-emerald-600">My Profile</a>
                <a href="/about" class="text-sm font-medium text-gray-600 hover:text-gray-900">About</a>

                <!-- Logout form -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Log Out
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-4 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

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
                            <img src="{{ $user->photo_url }}" alt="Profile Photo"
                                class="w-20 h-20 rounded-full object-cover">
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

                        <p class="text-xs text-gray-500 mt-1">JPG, PNG max 2MB</p>
                    </div>

                    <!-- Edit Button -->
                    <div class="ml-auto">
                        <a href="{{ route('jobseeker.profile.edit') }}"
                            class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-md text-sm text-white">
                            Edit Profile
                        </a>
                    </div>
                </div>

                <!-- Change Email/Password Links -->
                <div class="flex gap-6 mt-4">
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Change Email</a>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Change Password</a>
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
</body>

</html>