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

    public function show(Job $job)
{
    return view('jobs.show', compact('job'));
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