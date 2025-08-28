<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Application Received</title>
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
        <div class="bg-blue-500 text-white p-6 text-center rounded-t-lg">
            <h1 class="text-2xl font-bold">🎉 New Application Received!</h1>
        </div>

        <!-- Content -->
        <div class="bg-gray-50 p-6 border-l border-r border-gray-200">
            <p class="text-gray-800 mb-4">Hello,</p>

            <p class="text-gray-800 mb-6">
                Great news! You have received a new application for one of your job postings.
            </p>

            <!-- Job Details Card -->
            <div class="bg-blue-50 p-4 rounded-md mb-6">
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
                </div>
            </div>

            <!-- Applicant Details Card -->
            <div class="bg-white p-4 rounded-md border-l-4 border-blue-500 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Applicant Information:</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-gray-700">
                        <span class="font-medium">Name:</span> {{ $jobseeker->first_name }} {{ $jobseeker->last_name }}
                    </p>
                    <p class="text-gray-700">
                        <span class="font-medium">Email:</span> {{ $jobseeker->email }}
                    </p>
                    @if($jobseeker->contact)
                        <p class="text-gray-700">
                            <span class="font-medium">Contact:</span> {{ $jobseeker->contact }}
                        </p>
                    @endif
                    @if($jobseeker->location)
                        <p class="text-gray-700">
                            <span class="font-medium">Location:</span> {{ $jobseeker->location }}
                        </p>
                    @endif
                    <p class="text-gray-700">
                        <span class="font-medium">Applied on:</span>
                        {{ $application->created_at->format('M j, Y \a\t g:i A') }}
                    </p>
                </div>
            </div>

            <!-- Call to Action Button -->
            <div class="text-center my-6">
                <a href="{{ url('/dashboard') }}"
                    class="inline-block bg-blue-500 text-white px-6 py-3 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors no-underline">
                    View Application Details
                </a>
            </div>

            <!-- Next Steps Section -->
            <div class="mb-6">
                <p class="text-gray-800 font-medium mb-3">Next Steps:</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start">
                        <span class="text-blue-500 mr-2">•</span>
                        Log into your CareMatch dashboard to review the full application
                    </li>
                    <li class="flex items-start">
                        <span class="text-blue-500 mr-2">•</span>
                        View the applicant's cover letter and resume
                    </li>
                    <li class="flex items-start">
                        <span class="text-blue-500 mr-2">•</span>
                        Contact the applicant directly if you'd like to move forward
                    </li>
                </ul>
            </div>

            <div class="border-t pt-4 mt-6">
                <p class="text-gray-800 mb-1">Best regards,</p>
                <p class="text-gray-800 font-medium">The CareMatch Team</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-200 p-4 text-center rounded-b-lg">
            <p class="text-gray-600 text-sm">
                This email was sent from CareMatch - Connecting Care Professionals
            </p>
        </div>
    </div>
</body>

</html>