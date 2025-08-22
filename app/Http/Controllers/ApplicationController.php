<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    // spremi application
    public function store(Job $job)
    {
        $user = Auth::user();
        $jobseeker = $user->user;

        Application::firstOrCreate([
            'job_id' => $job->id,
            'jobseeker_id' => $jobseeker->id
        ]);

        return redirect()->route('jobs.show')->with('success', 'Application sent');
    }

    // dohvati applications od jobseekera
    public function index()
    {
        $user = Auth::user();
        $jobseeker = $user->user;

        $applications = Application::with('job')
            ->where('jobseeker_id', $jobseeker->id)
            ->latest()
            ->get();

        return view('applications.index', compact('applications'));
    }

    // dohvati applications od employera
    public function employerIndex()
    {
        $user = Auth::user();
        $employer = $user->user;

        $applications = Application::with(['job', 'jobseeker'])
            ->whereHas('job', fn ($q) => $q->where('employer_id', $employer->id)) // ovo pojasniti !
            ->latest()
            ->get();
        
        return view('employer.applications', compact('applications'));
    }
    
}
