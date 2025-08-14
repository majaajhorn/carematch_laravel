<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserAvatarController extends Controller
{
    // update the avatar for the user
    public function upload(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048']
        ]);

        $user = Auth::user();

        $filename = 'user_' . $user->id . '.jpg';

        if (Storage::disk('public')->exists('photos/' . $filename)) {
            Storage::disk('public')->delete('photos/' . $filename);
        }

        $request->file('photo')->storeAs('photos', $filename, 'public');

        return redirect()->back()->with('success', 'Photo uploaded successfully!');
    }

    public function remove()
    {
        $user = Auth::user();
        $filename = 'user_' . $user->id . '.jpg';

        if (Storage::disk('public')->exists('photos/' . $filename)) {
            Storage::disk('public')->delete('photos/' . $filename);
        }

        return redirect()->back()->with('success', 'Photo removed successfully!');
    }
    
    public static function hasPhoto($userId)
    {
        $filename = 'user_' . $userId . '.jpg';
        return Storage::disk('public')->exists('photos/' . $filename);
    }

    public static function getPhotoUrl($userId)
    {
        $filename = 'user_' . $userId . '.jpg';
        
        if (Storage::disk('public')->exists('photos/' . $filename)) {
            return Storage::url('photos/' . $filename);
        }
        
        return null;
    }
}