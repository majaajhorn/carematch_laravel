<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Rejection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Override Tailwind defaults for email compatibility */
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto p-4">
        <!-- Header -->
        <div class="bg-emerald-600 text-white p-6 text-center rounded-t-lg">
            <h1 class="text-2xl font-bold">Application Rejection</h1>
        </div>

        <!-- Content -->
        <div class="bg-gray-50 p-6 border-l border-r border-gray-200">
            <p class="text-gray-800 mb-4">Hello {{ $jobseeker->first_name }},</p>

            <p class="text-gray-800 mb-6">
                <span class="font-bold">We're sorry!</span> Your application has been rejected.
            </p>

            <!-- Job Details Card -->
            <div class="bg-white p-4 rounded-md border-l-4 border-emerald-600 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Job Details:</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-gray-700">
                        <span class="font-medium">Position:</span> {{ $job->title }}
                    </p>
                    <p class="text-gray-700">
                        <span class="font-medium">Location:</span> {{ $job->location }}
                    </p>
                    <p class="text-gray-700">
                        <span class="font-medium">Salary:</span> £{{ $job->salary }} {{ $job->salary_period }}
                    </p>
                    <p class="text-gray-700">
                        <span class="font-medium">Applied on:</span>
                        {{ $application->created_at->format('M j, Y \a\t g:i A') }}
                    </p>
                </div>
            </div>


            <p class="text-gray-700 mb-4">
                You can try applying to similar jobs by logging into your CareMatch account.
            </p>

            <div class="border-t pt-4 mt-6">
                <p class="text-gray-800 mb-1">Best of luck!</p>
                <p class="text-gray-800 font-medium">The CareMatch Team</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-200 p-4 text-center rounded-b-lg">
            <p class="text-gray-600 text-xs">
                This email was sent from CareMatch - Connecting Care Professionals
            </p>
        </div>
    </div>
</body>

</html>