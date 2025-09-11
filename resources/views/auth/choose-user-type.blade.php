<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Profile Type - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-center mb-6">Choose your profile type</h1>

            <div class="mb-4 text-center">
                <p class="text-gray-600">Welcome, {{ $googleUser['name'] }}!</p>
                <p class="text-sm text-gray-500">{{ $googleUser['email'] }}</p>
            </div>

            <!-- Errors -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('auth.complete-registration') }}" method="POST">
                @csrf

                <div class="space-y-4 mb-6">
                    <!-- Jobseeker -->
                    <label
                        class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors user-type-option">
                        <input type="radio" name="user_type" value="jobseeker" class="mr-3" required>
                        <div>
                            <div class="font-semibold text-gray-800">I'm looking for a job</div>
                            <div class="text-sm text-gray-600">Register me as a jobseeker</div>
                        </div>
                    </label>

                    <!-- Employer -->
                    <label
                        class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors user-type-option">
                        <input type="radio" name="user_type" value="employer" class="mr-3" required>
                        <div>
                            <div class="font-semibold text-gray-800">I'm offering a job</div>
                            <div class="text-sm text-gray-600">Register me as an employer</div>
                        </div>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-emerald-600 text-white py-3 rounded-lg hover:bg-emerald-700 transition-colors font-semibold">
                    Register
                </button>
            </form>

            <!-- Back to login -->
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-800">
                    ← Back go Log In
                </a>
            </div>
        </div>
    </div>

    <script>
        // Add visual feedback when an option is selected
        document.querySelectorAll('input[name="user_type"]').forEach(radio => {
            radio.addEventListener('change', function () {
                // Remove active class from all labels
                document.querySelectorAll('.user-type-option').forEach(label => {
                    label.classList.remove('border-blue-500', 'bg-blue-50');
                    label.classList.add('border-gray-200');
                });

                // Add active class to the selected label
                this.closest('label').classList.remove('border-gray-200');
                this.closest('label').classList.add('border-blue-500', 'bg-blue-50');
            });
        });
    </script>
</body>

</html>