<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    // spremi application
    public function store(Request $request, Job $job)
    {
        $request->validate([
            'cover_letter' => ['required', 'string', 'min:50'],
            'additional_notes' => ['nullable', 'string'],
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'confirmed' => ['accepted'],
        ]);

        $user = Auth::user();
        $jobseekerId = $user->user->id;

        $alreadyApplied = Application::where('job_id', $job->id)->where('jobseeker_id', $jobseekerId)->exists();

        if ($alreadyApplied) {
            return redirect()->route('jobs.show', $job)->with('error', 'You have already applied for this job!');
        }

        $resumePath = null;

        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        Application::updateOrCreate(
            ['job_id' => $job->id, 'jobseeker_id' => $jobseekerId],
            [
            'cover_letter' => $request->cover_letter, 
            'additional_notes' => $request->additional_notes,
            'resume_path' => $resumePath,
            ]
        );

        return redirect()->route('jobs.show', $job)->with('success', 'Application sent');
    }

    // dohvati applications od jobseekera
    public function show()
    {
        $user = Auth::user();
        $jobseeker = $user->user;

        $applications = Application::with('job')
            ->where('jobseeker_id', $jobseeker->id)
            ->latest()
            ->get();

        return view('applications.show', compact('applications'));
    }

    public function create(Job $job)
    {
        $user = Auth::user();
        $jobseekerId = $user->user->id;

        $alreadyApplied = Application::where('job_id', $job->id)->where('jobseeker_id', $jobseekerId)->exists();

        if ($alreadyApplied) {
            return redirect()->route('jobs.show', $job)->with('error', 'You have already applied for this job!');
        }
        return view('applications.index', compact('job'));
    }
    public function destroy(Request $request, $jobId)
    {
        $user = Auth::user();
        $jobseekerId = $user->user->id;

        $application = Application::where('job_id', $jobId)->where('jobseeker_id', $jobseekerId)->firstOrFail();

        if (!empty($application->resume_path)) {
            Storage::disk('public')->delete($application->resume_path);
        }

        $application->delete();

        return back()->with('success', 'Successfully withdrawn from application.');
    }
    // dohvati applications od employera
    /*public function employerIndex()
    {
        $user = Auth::user();
        $employer = $user->user;

        $applications = Application::with(['job', 'jobseeker'])
            ->whereHas('job', fn ($q) => $q->where('employer_id', $employer->id)) // ovo pojasniti !
            ->latest()
            ->get();
        
        return view('employer.applications', compact('applications'));
    }
    */
}
