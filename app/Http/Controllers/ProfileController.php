<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Auth::check()) return redirect('/login');
        return $this->show(Auth::user()->username);
    }

    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        
        $videos = $user->videos()->latest()->get();
        
        $stats = [
            'following' => $user->following()->count(),
            'followers' => $user->followers()->count(),
            'likes' => $user->videos()->sum('likes_count'),
        ];

        $isOwnProfile = Auth::id() === $user->id;
        $isFollowing = false;
        
        if (Auth::check() && !$isOwnProfile) {
            $isFollowing = Auth::user()->isFollowing($user);
        }

        return Inertia::render('Profile', [
            'profileUser' => $user,
            'videos' => $videos,
            'stats' => $stats,
            'isFollowing' => $isFollowing,
            'isOwnProfile' => $isOwnProfile,
        ]);
    }

    public function edit()
    {
        return Inertia::render('Profile/Edit', [
            'auth' => [
                'user' => Auth::user(),
            ],
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'bio' => 'nullable|string|max:80',
            'avatar' => 'nullable|image|max:1024',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->bio = $request->bio;

        if ($request->hasFile('avatar')) {
            if ($user->avatar && str_contains($user->avatar, '/storage/')) {
                Storage::delete(str_replace('/storage/', 'public/', $user->avatar));
            }
            
            $path = $request->file('avatar')->store('public/avatars');
            $user->avatar = Storage::url($path);
        }

        $user->save();

        return redirect("/profile/@{$user->username}");
    }
}
