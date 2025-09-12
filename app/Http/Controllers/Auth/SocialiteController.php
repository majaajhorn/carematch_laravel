<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\Jobseeker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Getting user's info from Google
            $googleUser = Socialite::driver('google')->user();
            
            // Check if the user exists
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            
            if ($existingUser) {
                Auth::login($existingUser);
                return redirect()->route('dashboard');
            }

            // If the user doesn't exists, save it in session and redirect to choose type
            session([
                'google_user' => [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                ]
            ]);
            
            return redirect()->route('auth.choose-user-type');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Error ' . $e->getMessage());
        }
    }

    /**
     * Choose user type
     */
    public function showChooseUserType()
    {
        // Check if the data is stored in session
        if (!session('google_user')) {
            return redirect()->route('login')->with('error', 'Session has expired, please try again.');
        }
        
        $googleUser = session('google_user');
        return view('auth.choose-user-type', compact('googleUser'));
    }

    /**
     * Finishing the registration with chosen type
     */
    public function completeRegistration(Request $request)
    {
        $request->validate([
            'user_type' => ['required', 'in:employer,jobseeker']
        ]);
        
        // Get the data from session
        $googleUser = session('google_user');
        if (!$googleUser) {
            return redirect()->route('login')->with('error', 'Session has expired, please try again.');
        }
        
        // Divide name and surname
        $nameParts = explode(' ', $googleUser['name'], 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
        
        // Make the type (Employer or Jobseeker)
        if ($request->user_type === 'employer') {
            $userModel = Employer::create([]);
            $userType = Employer::class;
        } else {
            $userModel = Jobseeker::create([]);
            $userType = Jobseeker::class;
        }
        
        // Create User with polymorph relationship
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $googleUser['email'],
            'user_type' => $userType,
            'user_id' => $userModel->id,
            'password' => bcrypt('google-user-' . time()), // Random password, won't be used
            'email_verified_at' => now(), 
        ]);
        
        Auth::login($user);
        
        // Clear session
        session()->forget('google_user');
        
        return redirect()->route('dashboard')->with('success', 'Welcome! Your profile has been authorized.');
    }
}