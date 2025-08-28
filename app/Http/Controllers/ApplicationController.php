<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Mail\ApplicationSent;
use App\Mail\NewApplicationNotification;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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

        $application = Application::updateOrCreate(
            ['job_id' => $job->id, 'jobseeker_id' => $jobseekerId],
            [
            'cover_letter' => $request->cover_letter, 
            'additional_notes' => $request->additional_notes,
            'resume_path' => $resumePath,
            ]
        );

        try {
            Mail::to($user->email)->send(new ApplicationSent($application, $job, $user));

            $employer = $job->employer->authParent; 
            
            Mail::to($employer->email)->send(new NewApplicationNotification($application, $job, $user));
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

        return redirect()->route('jobs.show', $job)->with('success', 'Application sent successfully!');
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
    
    public function approve(Application $application)
    {
        $user = Auth::user();

        if ($application->job->employer_id !== $user->user_id) {
            return back()->with('error', 'You can only approve applications for your own jobs');
        }

        $application->update(['status'=> ApplicationStatus::Approved]);
        return back()->with('success', 'Application approved successfully.');
    }

    public function reject(Application $application)
    {
        $user = Auth::user();

        if ($application->job->employer_id !== $user->user_id) {
            return back()->with('error', 'You can only reject applications for your own jobs');
        }

        $application->update(['status'=> ApplicationStatus::Rejected]);
        return back()->with('success', 'Application rejected.');
    }
}
