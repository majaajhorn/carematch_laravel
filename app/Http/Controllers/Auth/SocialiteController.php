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
    /**
     * Preusmjeri korisnika na Google za autentifikaciju
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Rukovanje callback-om od Google-a
     */
    public function handleGoogleCallback()
    {
        try {
            // Dohvati korisničke podatke od Google-a
            $googleUser = Socialite::driver('google')->user();
            
            // Provjeri postoji li već korisnik s ovim emailom
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            
            if ($existingUser) {
                // Ako korisnik već postoji, samo ga ulogiraj
                Auth::login($existingUser);
                return redirect()->route('dashboard');
            }
            
            // Ako korisnik ne postoji, spremimo ga u session i idemo na stranicu za odabir tipa
            session([
                'google_user' => [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                ]
            ]);
            
            // Preusmjeri na stranicu za odabir user_type
            return redirect()->route('auth.choose-user-type');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Error ' . $e->getMessage());
        }
    }

    /**
     * Prikaži stranicu za odabir tipa korisnika
     */
    public function showChooseUserType()
    {
        // Provjeri ima li podataka u session
        if (!session('google_user')) {
            return redirect()->route('login')->with('error', 'Session has expired, please try again.');
        }
        
        $googleUser = session('google_user');
        return view('auth.choose-user-type', compact('googleUser'));
    }

    /**
     * Završi registraciju s odabranim tipom korisnika
     */
    public function completeRegistration(Request $request)
    {
        // Validiraj odabrani tip korisnika
        $request->validate([
            'user_type' => ['required', 'in:employer,jobseeker']
        ]);
        
        // Dohvati podatke iz session
        $googleUser = session('google_user');
        if (!$googleUser) {
            return redirect()->route('login')->with('error', 'Session has expired, please try again.');
        }
        
        // Razdijeli ime i prezime (Google često vraća puno ime)
        $nameParts = explode(' ', $googleUser['name'], 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
        
        // Stvori odgovarajući tip korisnika (Employer ili Jobseeker)
        if ($request->user_type === 'employer') {
            $userModel = Employer::create([]);
            $userType = Employer::class;
        } else {
            $userModel = Jobseeker::create([]);
            $userType = Jobseeker::class;
        }
        
        // Stvori glavnog User-a s polimorfnom vezom
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $googleUser['email'],
            'user_type' => $userType,
            'user_id' => $userModel->id,
            'password' => bcrypt('google-user-' . time()), // Nasumična lozinka jer se neće koristiti
            'email_verified_at' => now(), // Google je već verificirao email
        ]);
        
        // Ulogiraj korisnika
        Auth::login($user);
        
        // Očisti session
        session()->forget('google_user');
        
        return redirect()->route('dashboard')->with('success', 'Welcome! Your profile has been authorized.');
    }
}