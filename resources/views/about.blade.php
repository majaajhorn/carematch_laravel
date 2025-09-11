@extends('layouts.master')

@section('content')

    <!-- About content -->
    <main class="mx-auto max-w-6xl px-6 py-16">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-emerald-600 mb-6">About CareMatch</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                <span class="text-emerald-600 font-extrabold">CareMatch</span> is a platform designed to connect
                caregivers with employers in the healthcare industry.
                Our mission is to simplify the process of finding and offering jobs in care work by providing a
                modern, user-friendly experience for both jobseekers and employers.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mt-20">
            <div class="bg-white shadow-lg rounded-2xl p-8 text-center">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">For Jobseekers</h2>
                <p class="text-gray-600 leading-relaxed">
                    Discover opportunities in healthcare tailored to your skills and preferences. Save jobs,
                    track applications, and find the right employer for you.
                </p>
            </div>

            <div class="bg-white shadow-lg rounded-2xl p-8 text-center">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">For Employers</h2>
                <p class="text-gray-600 leading-relaxed">
                    Post job offers, review caregiver profiles, and manage applications with ease. Our platform
                    helps you find the best talent quickly and effectively.
                </p>
            </div>

            <div class="bg-white shadow-lg rounded-2xl p-8 text-center">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Our Vision</h2>
                <p class="text-gray-600 leading-relaxed">
                    To revolutionize the healthcare job market by creating meaningful connections that improve
                    both career opportunities and quality of care.
                </p>
            </div>
        </div>
    </main>

@endsection