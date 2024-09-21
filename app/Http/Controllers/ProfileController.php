<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    
    public function show(User $user)
    {
        return view('profiles.profileshow', [
            'user' => $user,
            'followersCount' => $user->followers_count,
            'followingCount' => $user->following_count,
        ]);
    }
    
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    
    public function followers(User $user)
    {
        $followers = $user->followers()->get();
        return view('profiles.followers', compact('user', 'followers'));
    }
    
    public function following(User $user)
    {
        $following = $user->following()->get();
        return view('profiles.following', compact('user', 'following'));
    }
    
    public function userProfile(User $user)
    {
        return view('profiles.userprofile', [
            'user' => $user,
            'followersCount' => $user->followers()->count(),
            'followingCount' => $user->following()->count(),
        ]);
    }



    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'prefecture' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'pet' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->prefecture = $request->prefecture;
        $user->city = $request->city;
        $user->district = $request->district;
        $user->bio = $request->bio;
        $user->pet = $request->pet;
    
        // アイコン画像の保存処理
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('profile_pictures', 'public');
            $user->profile_photo_path = $path;
        }
    
        $user->save();
    
        return redirect()->route('profileoption', ['user' => $user->id])->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}