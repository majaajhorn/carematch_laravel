<?php

namespace App\Http\Controllers;

use App\Models\Jobseeker;
use App\Http\Requests\StoreProfileRequest;
use App\Enums\Gender;
use App\Enums\EnglishLevel;
use App\Enums\LiveInExperience;
use Illuminate\Support\Facades\Auth;

class JobseekerController extends Controller
{
    // prikazi jobseekera
    public function show()
    {
        $user = Auth::user();

        if (!$user->isJobseeker()) {
            return redirect()->route('employer.profile.show');
        }

        $jobseeker = Jobseeker::where('id', $user->user_id)->with(['qualifications', 'experiences'])->first();

        return view('profile.jobseeker.show', compact('user', 'jobseeker'));
    }
    // uredi profil
    public function edit()
    {
        $user = Auth::user();

        if (!$user->isJobseeker()) {
            return redirect()->route('employer.profile.edit');
        }

        $jobseeker = Jobseeker::where('id', $user->user_id)->with(['qualifications', 'experiences'])->first();

        return view('profile.jobseeker.edit', compact('user', 'jobseeker'));
    }
    // spremi izmjene
    public function update(StoreProfileRequest $request, Jobseeker $jobseeker)
    {
        $jobseeker->authParent()->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'location' => $request->location,
            'contact' => $request->contact,
        ]);


        $jobseeker->update([
            'gender' => $request->enum('gender', Gender::class),
            'english_level' => $request->enum('english_level', EnglishLevel::class),
            'live_in_experience' => $request->enum('live_in_experience', LiveInExperience::class),
            'driving_license' => $request->boolean('driving_license'),
            'about_yourself' => $request->about_yourself,
        ]);

        // qualifications
        $jobseeker->qualifications()->delete(); 
        if ($request->has('qualifications')) {
            foreach ($request->qualifications as $qualification) {
                $jobseeker->qualifications()->create([
                    'qualification_name' => $qualification
                ]);
            }
        }

        // experiences
        $jobseeker->experiences()->delete(); 
        if ($request->has('experiences')) {
            foreach ($request->experiences as $experience) {
                $jobseeker->experiences()->create([
                    'job_title' => $experience
                ]);
            }
        }

        return redirect()->route('jobseeker.profile.show');
    }
    // obrisi profil
    public function destroy()
    {
        $user = Auth::user();

        if (!$user->isJobseeker()) {
            return redirect()->route('employer.profile.show');
        }

        $jobseeker = Jobseeker::find($user->user_id);

        if ($jobseeker) {
            $jobseeker->qualifications()->delete();
            $jobseeker->experiences()->delete();

            $jobseeker->delete();
        }

        $userAvatarController = new UserAvatarController;
        $userAvatarController->remove();

        $user->delete();

        return redirect()->route('home');
    }

    public function showPublic($id) 
    {
        $jobseeker = Jobseeker::where('id', $id)->with(['qualifications', 'experiences'])->first();

        if (!$jobseeker) {
            abort(404, 'Jobseeker not found');
        }

        $user = $jobseeker->authParent;

        return view('jobseeker.index', compact('user', 'jobseeker'));
    }
    
}
