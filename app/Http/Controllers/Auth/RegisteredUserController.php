<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Jobseeker;
use App\Models\Employer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', Password::min(6), 'confirmed'],
            'role' => ['required', 'in:jobseeker,employer'],
        ]);

        if ($request->role === 'jobseeker') {
            $userType = Jobseeker::create();
        } else {
            $userType = Employer::create();
        }
    
        $user = new User([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->user()->associate($userType);
        $user->save();

        return redirect('/login')->with('success', 'Registration successful! Please log in.');
    }
}
