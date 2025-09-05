<?php

namespace App\Http\Controllers;

use App\Enums\EmploymentType;
use App\Enums\SalaryPeriod;
use App\Http\Requests\StoreJobRequest;
use App\Models\Application;
use App\Models\Job;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // prikaz svih poslova
    public function index()
    {
        //$jobs = Job::latest()->get();
        
        $jobs = Job::latest()->active()->paginate(3);
        
        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;

        if (empty($search)) {
            $jobs = Job::where('id', '=', 0)->paginate(3); 
            return view('jobs.index', compact('jobs', 'search'));
        }
        
        $jobs = Job::with('employer.authParent')->where(function($query) use ($search) {
            // Search in job fields
            $query->where('title', 'like', "%$search%")
                  ->orWhere('location', 'like', "%$search%")
                  ->orWhere('salary', 'like', "%$search%");
        })
        
        ->orWhereHas('employer.authParent', function($query) use ($search) {
            $query->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%");
        })
        ->latest()
        ->paginate(3);

        return view('jobs.index', compact('jobs', 'search'));
    }
    // stvaranje poslova
    public function create()
    {
        return view('jobs.create');
    }

    // prikaz posla
    public function show(Job $job)
    {
        // ovdje ćemo napraviti provjeru ako je već sejvan posao i spremiti u varijablu
        $isSaved = false;
        $hasApplied = false;

        if (Auth::check() && Auth::user()->isJobseeker()) {
            $jobseekerId = Auth::user()->user->id;
            $isSaved = SavedJob::where('job_id', $job->id)->where('jobseeker_id',$jobseekerId)->exists();
            $hasApplied = Application::where('job_id', $job->id)->where('jobseeker_id', $jobseekerId)->exists();
        }
        return view('jobs.show', compact('job', 'isSaved', 'hasApplied'));
    }

    // prikaz posla od trenutnog employera (my jobs)
    public function showMyJobs()
    {
        $user = Auth::user();       // get the currently logged-in user

        $employer = $user->user;    // polymorphic relationship (get related record based on user_type)

        $jobs = $employer->jobs()->withCount('applications')->latest()->paginate(4); // get all jobs from this employer
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

        return redirect()->route('jobs.show-my-jobs');
    }

    // uređivanje poslova
    public function update(StoreJobRequest $request, Job $job)
    {
        $job->update([
            'title' => $request->title,
            'salary' => $request->salary,
            'salary_period' => $request->enum('salary_period', SalaryPeriod::class),
            'employment_type' => $request->enum('employment_type', EmploymentType::class),
            'location' => $request->location,
            'description' => $request->description,
            'requirements' => $request->requirements,
        ]);

        return redirect()->route('jobs.show-my-jobs');
    }

    // brisanje poslova
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('jobs.show-my-jobs');
    }

    // deactiviranje poslova
    public function deactivate(Job $job)
    {
        $job->update(['active' => false]);

        return back()->with('success', 'Job deactivated.');
    }

    // aktiviranje posla
    public function activate(Job $job)
    {
        $job->update(['active' => true]);

        return back()->with('success', 'Job activated.');
    }
}