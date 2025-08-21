<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class EmployerController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (!$user->isEmployer()) {
            return redirect()->route('jobseeker.profile.show');
        }

        $employer = Employer::findOrFail($user->user_id);

        return view('profile.employer.show', compact('user', 'employer'));
    }

    public function edit()
    {
        $user = Auth::user();

        if (!$user->isEmployer()) {
            return redirect()->route('jobseeker.profile.edit');
        }

        $employer = Employer::findOrFail($user->user_id);
        return view('profile.employer.edit', compact('user', 'employer'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user->isEmployer()) {
            return redirect()->route('jobseeker.profile.show');
        }

        $employer = Employer::findOrFail($user->user_id);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required','email','max:255', 'unique:users,email,' . $user->id], // we use $user->id because we want the email to be unique among other users, not agains the record we're currently updating. Without ignoring the current user, if they don’t change their email, the validator sees the same email already in users and fails.
            'location' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'location' => $request->location,
            'contact' => $request->contact
        ]);

        return redirect()->route('employer.profile.show')->with('success', 'Profile updated!');
    }      
}
