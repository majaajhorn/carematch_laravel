<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // prikaz forme
    public function editPassword()
    {
        return view('profile.change-password');
    }
    
    // mijenjanje passworda
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required',  'current_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed', 'different:current_password'],
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
