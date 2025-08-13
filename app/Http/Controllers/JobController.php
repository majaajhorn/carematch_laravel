<?php

namespace App\Http\Controllers;

use App\Enums\EmploymentType;
use App\Enums\SalaryPeriod;
use App\Http\Requests\StoreJobRequest;
use App\Models\Job;

class JobController extends Controller
{
    // prikaz svih poslova
    public function index()
    {
        $jobs = Job::latest()->get();
        
        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }

    // stvaranje poslova
    public function create()
    {
        return view('jobs.create');
    }

    // prikaz posla
    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    // prikaz posla od trenutnog employera (my jobs)
    public function showMyJobs()
    {
        $user = auth()->user();     // get the currently logged-in user

        $employer = $user->user;    // polymorphic relationship (get related record based on user_type)

        $jobs = $employer->jobs()->latest()->get(); // get all jobs from this employer
        return view('jobs.show-my-jobs', compact('jobs'));
    }    

    // spremanje poslova
    public function store(StoreJobRequest $request)
    {
        $request->user()->user->jobs()->create([
            'title' => $request->title,
            'salary' => $request->salary,
            'salary_period' => $request->enum('salary_period', SalaryPeriod::class) ,
            'employment_type' => $request->enum('employment_type', EmploymentType::class) ,
            'location' => $request->location,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'posted_date' => now(),
        ]);

        return redirect('/dashboard');
    }
}