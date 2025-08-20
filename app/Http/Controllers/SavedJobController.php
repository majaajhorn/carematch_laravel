<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use App\Models\SavedJob;

class SavedJobController extends Controller
{
    public function index()
    {
        // dohvati usera
        $user = Auth::user();
        $jobseeker = $user->user;
        $savedJobs = $jobseeker->savedJobs()->with('job')->latest()->get();

        return view('jobs.saved', compact('savedJobs'));
    }
    public function store(Request $request, $jobId)
    {
        $jobseeker = Auth::user()->user;   // the logged-in jobseeker

        // Create only if it doesn't exist (so multiple clicks are safe)
        SavedJob::firstOrCreate([
            'job_id'       => $jobId,
            'jobseeker_id' => $jobseeker->id,
        ]);

        // Go to the Saved Jobs page with a success message
        return redirect()
            ->route('jobs.saved')
            ->with('success', 'Job saved successfully!');
    }

    public function destroy(Request $request, $jobId)
    {
        $user = Auth::user();
        $jobseeker = $user->user;

        // Delete the saved job
        SavedJob::where('job_id', $jobId)
            ->where('jobseeker_id', $jobseeker->id)
            ->delete();

        return redirect()->back()->with('success', 'Job removed from saved jobs!');
    }
}
