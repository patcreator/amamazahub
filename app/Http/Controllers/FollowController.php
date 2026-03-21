<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FollowController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $following = $user ? $user->following()->limit(10)->get() : [];
        
        $suggested = User::where('id', '!=', Auth::id())
            ->whereDoesntHave('followers', function ($query) {
                $query->where('follower_id', Auth::id());
            })
            ->limit(10)
            ->get();

        return Inertia::render('Following', [
            'followingUsers' => $following,
            'suggestedUsers' => $suggested,
        ]);
    }

    public function toggle(User $user)
    {
        $follower = Auth::user();

        if ($follower->id === $user->id) {
            return back()->withErrors(['message' => 'You cannot follow yourself.']);
        }

        if ($follower->isFollowing($user)) {
            $follower->following()->detach($user->id);
            $following = false;
        } else {
            $follower->following()->attach($user->id);
            $following = true;
        }

        if (request()->wantsJson()) {
            return response()->json(['following' => $following]);
        }

        return back();
    }

    public function suggested()
    {
        // Get 5 users that the current user is not following
        $userId = Auth::id();
        
        $suggested = User::where('id', '!=', $userId)
            ->whereDoesntHave('followers', function ($query) use ($userId) {
                $query->where('follower_id', $userId);
            })
            ->limit(5)
            ->get();

        return response()->json($suggested);
    }

    public function following()
    {
        $user = Auth::user();
        $following = $user ? $user->following()->get() : [];
        return response()->json($following);
    }
}
