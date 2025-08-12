<?php

namespace App\Http\Controllers;

use App\Enums\EmploymentType;
use App\Enums\SalaryPeriod;
use App\Http\Requests\StoreJobRequest;
use App\Models\Job;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule as ValidationRule;

class JobController extends Controller
{
    // prikaz svih poslova
    public function index()
    {
        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }

    // stvaranje poslova
    public function create()
    {
        return view('jobs.create');
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