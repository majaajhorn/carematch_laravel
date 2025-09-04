<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->isJobseeker()) {
            return view('profile.jobseeker.dashboard');
        } 

        //dd($user);
        $applications = Application::whereHas('job', function(Builder $query) use ($user){
            $query->where('employer_id', '=', $user->user_id );
        })->with(['job', 'jobseeker.authParent'])->orderBy('created_at', 'desc')->paginate(2);

        return view('profile.employer.dashboard', compact('applications'));
    }

}
