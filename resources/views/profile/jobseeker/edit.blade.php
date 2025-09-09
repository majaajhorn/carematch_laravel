@extends('layouts.master')

@section('content')

    <!-- Main Content -->
    <main class="mx-auto max-w-3xl px-4 py-8">
        <!-- Back Link -->
        <a href="{{ route('jobseeker.profile.show') }}" class="text-emerald-600 hover:text-emerald-800 mb-6 inline-block">
            ← Back to Profile
        </a>

        <!-- Page Title -->
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Edit Profile</h1>

        <!-- Edit Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <form method="POST" action="{{ route('jobseeker.profile.update',  $user->user_id) }}">
                @csrf
                @method('PATCH')
                
                <!-- Form Content -->
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                            
                            <!-- Name Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                    <input type="text" name="first_name" id="first_name" 
                                           value="{{ old('first_name', $user->first_name) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-blue-500">
                                    @error('first_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" 
                                           value="{{ old('last_name', $user->last_name) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-blue-500">
                                    @error('last_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email & Contact -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" id="email" 
                                           value="{{ old('email', $user->email) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-blue-500">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">Contact</label>
                                    <input type="text" name="contact" id="contact" 
                                           value="{{ old('contact', $user->contact) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blemeraldue-500 focus:border-blue-500">
                                    @error('contact')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="mb-6">
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                                <input type="text" name="location" id="location" 
                                       value="{{ old('location', $user->location) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                @error('location')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Care Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Care Information</h3>
                            
                            <!-- Gender & English Level -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                    <select name="gender" id="gender" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                        <option value="">Select Gender</option>
                                        @foreach(\App\Enums\Gender::cases() as $gender)
                                            <option value="{{ $gender->value }}" {{ old('gender', $jobseeker->gender) == $gender->value ? 'selected' : '' }}>
                                                {{ ucfirst($gender->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="english_level" class="block text-sm font-medium text-gray-700 mb-2">English Level</label>
                                    <select name="english_level" id="english_level" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                        <option value="">Select English Level</option>
                                        @foreach(\App\Enums\EnglishLevel::cases() as $level)
                                            <option value="{{ $level->value }}" {{ old('english_level', $jobseeker->english_level) == $level->value ? 'selected' : '' }}>
                                                {{ ucfirst($level->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('english_level')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Live-in Experience -->
                            <div class="mb-6">
                                <label for="live_in_experience" class="block text-sm font-medium text-gray-700 mb-2">Live-in Experience</label>
                                <select name="live_in_experience" id="live_in_experience" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="">Select Experience</option>
                                    @foreach(\App\Enums\LiveInExperience::cases() as $experience)
                                        <option value="{{ $experience->value }}" {{ old('live_in_experience', $jobseeker->live_in_experience) == $experience->value ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $experience->value)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('live_in_experience')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Driving License -->
                            <div class="mb-6">
                                <label class="flex items-center">
                                    <input type="checkbox" name="driving_license" value="1" 
                                           {{ old('driving_license', $jobseeker->driving_license) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">I have a driving license</span>
                                </label>
                                @error('driving_license')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- About Yourself -->
                            <div class="mb-6">
                                <label for="about_yourself" class="block text-sm font-medium text-gray-700 mb-2">About Yourself</label>
                                <textarea name="about_yourself" id="about_yourself" rows="4" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                          placeholder="Tell us about yourself, your experience, and what makes you a great carer...">{{ old('about_yourself', $jobseeker->about_yourself) }}</textarea>
                                @error('about_yourself')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Qualifications -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Qualifications</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="qualifications[]" value="Health and Social Care Level 3" 
                                               {{ $jobseeker->qualifications->contains('qualification_name', 'Health and Social Care Level 3') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">Health and Social Care Level 3</span>
                                    </label>
                                    
                                    <label class="flex items-center">
                                        <input type="checkbox" name="qualifications[]" value="First Aid Certificate" 
                                               {{ $jobseeker->qualifications->contains('qualification_name', 'First Aid Certificate') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">First Aid Certificate</span>
                                    </label>
                                    
                                    <label class="flex items-center">
                                        <input type="checkbox" name="qualifications[]" value="CPR Certified" 
                                               {{ $jobseeker->qualifications->contains('qualification_name', 'CPR Certified') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">CPR Certified</span>
                                    </label>
                                    
                                    <label class="flex items-center">
                                        <input type="checkbox" name="qualifications[]" value="Nursing Degree" 
                                               {{ $jobseeker->qualifications->contains('qualification_name', 'Nursing Degree') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">Nursing Degree</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="qualifications[]" value="Care Certificate" 
                                               {{ $jobseeker->qualifications->contains('qualification_name', 'Care Certificate') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">Care Certificate</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="qualifications[]" value="Other" 
                                               {{ $jobseeker->qualifications->contains('qualification_name', 'Other') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">Other</span>
                                    </label>

                                </div>
                                @error('qualifications.*')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Experiences -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Care Experience</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="experiences[]" value="Nursing" 
                                               {{ $jobseeker->experiences->contains('job_title', 'Nursing') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">Nursing</span>
                                    </label>
                                    
                                    <label class="flex items-center">
                                        <input type="checkbox" name="experiences[]" value="Live in care" 
                                               {{ $jobseeker->experiences->contains('job_title', 'Live in care') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">Live in care</span>
                                    </label>
                                    
                                    <label class="flex items-center">
                                        <input type="checkbox" name="experiences[]" value="Care assistant" 
                                               {{ $jobseeker->experiences->contains('job_title', 'Care assistant') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">Care assistant</span>
                                    </label>
                                    
                                    <label class="flex items-center">
                                        <input type="checkbox" name="experiences[]" value="Elderly care" 
                                               {{ $jobseeker->experiences->contains('job_title', 'Elderly care') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-bluemeralde-600">
                                        <span class="ml-2 text-sm">Elderly care</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="experiences[]" value="Dementia care" 
                                               {{ $jobseeker->experiences->contains('job_title', 'Dementia care') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">Dementia care</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="experiences[]" value="Disability support" 
                                               {{ $jobseeker->experiences->contains('job_title', 'Disability support') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">Disability support</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="experiences[]" value="No Experience" 
                                               {{ $jobseeker->experiences->contains('job_title', 'No Experience') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">No Experience</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="experiences[]" value="Need help with training" 
                                               {{ $jobseeker->experiences->contains('job_title', 'Need help with training') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-emerald-600">
                                        <span class="ml-2 text-sm">Need help with training</span>
                                    </label>
                                </div>
                                @error('experiences.*')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-gray-50 px-6 py-4 flex flex-wrap justify-between items-center gap-3">
                    <div class="flex gap-3">
                        @if($user->hasPhoto())
                            <button type="button"
                                onclick="document.getElementById('remove-photo-form').submit()"
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
                        <a href="{{ route('jobseeker.profile.show') }}"
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