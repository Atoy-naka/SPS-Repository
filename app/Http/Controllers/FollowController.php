<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        Auth::user()->following()->attach($user->id);
        $followersCount = $user->followers()->count();
        return response()->json(['followersCount' => $followersCount]);
    }

    public function unfollow(User $user)
    {
        Auth::user()->following()->detach($user->id);
        $followersCount = $user->followers()->count();
        return response()->json(['followersCount' => $followersCount]);
    }
    
    //フォロー状態を取得するメソッド
    public function isFollowing(User $user)
    {
        $isFollowing = Auth::user()->following()->where('followee_user_id', $user->id)->exists();
        return response()->json(['isFollowing' => $isFollowing]);
    }
}