<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProfileEmployerRequest;

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

    public function update(StoreProfileEmployerRequest $request, Employer $employer)
    {
        info('Unutar employer update funkcije u controlleru');

        $employer->authParent()->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'location' => $request->location,
            'contact' => $request->contact
        ]);

        return redirect()->route('employer.profile.show')->with('success', 'Profile updated!');
    }      
}
