<?php

namespace App\Http\Controllers;

use App\Models\Jobseeker;
use App\Models\JobseekerQualification;
use App\Models\JobseekerExperience;
use Illuminate\Http\Request;

class CarersController extends Controller
{
    public function index(Request $request)
    {
        $location = $request->get('location');
        $gender = $request->get('gender');
        $qualification = $request->get('qualification');
        $experience = $request->get('experience');
        $search = $request->get('search');

        
        $jobseekers = Jobseeker::with(['authParent', 'qualifications', 'experiences'])
        ->whereHas('authParent')
        ->location($location)       
        ->gender($gender)             
        ->qualification($qualification) 
        ->experience($experience)      
        ->search($search)              
        ->latest()           
        ->paginate(6)                 
        ->withQueryString();           

        $locations = Jobseeker::with('authParent')
            ->get()
            ->pluck('authParent.location')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $qualifications = JobseekerQualification::distinct()
            ->pluck('qualification_name')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $experiences = JobseekerExperience::distinct()
            ->pluck('job_title')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('carers', compact(
            'jobseekers',
            'location',
            'gender', 
            'qualification',
            'experience',
            'search',
            'locations',
            'qualifications',
            'experiences'
        ));
    }
}
