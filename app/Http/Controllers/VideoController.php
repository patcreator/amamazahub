<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'foryou');

        $query = Video::with('user')
            ->withCount(['likes', 'comments', 'reposts', 'shares', 'bookmarks'])
            ->withExists(['likes' => function ($query) {
                $query->where('user_id', Auth::id());
            }])
            ->withExists(['reposts' => function ($query) {
                $query->where('user_id', Auth::id());
            }])
            ->withExists(['bookmarks' => function ($query) {
                $query->where('user_id', Auth::id());
            }]);

        $query->with(['user' => function ($q) {
            $q->withExists(['followers as is_followed' => function ($f) {
                $f->where('follower_id', Auth::id());
            }]);
        }]);

        if ($type === 'following' && Auth::check()) {
            $followingIds = Auth::user()->following()->pluck('following_id');
            $query->whereIn('user_id', $followingIds);
        }

        $videos = $query->inRandomOrder()->paginate(10);

        return Inertia::render('Welcome', [
            'videos' => $videos,
            'feedType' => $type
        ]);
    }

    public function show(Video $video)
    {
        $video->load(['user' => function ($q) {
            $q->withExists(['followers as is_followed' => function ($f) {
                $f->where('follower_id', Auth::id());
            }]);
        }, 'comments' => function ($c) {
            $c->with('user')->latest();
        }]);

        $video->loadCount(['likes', 'comments', 'reposts', 'shares', 'bookmarks']);
        
        $video->likes_exists = $video->likes()->where('user_id', Auth::id())->exists();
        $video->reposts_exists = $video->reposts()->where('user_id', Auth::id())->exists();
        $video->bookmarks_exists = $video->bookmarks()->where('user_id', Auth::id())->exists();

        return Inertia::render('VideoDetail', [
            'video' => $video
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:102400',
            'caption' => 'nullable|string|max:255',
            'category' => 'required|string',
        ]);

        $file = $request->file('video');
        $filename = time() . '_' . $file->getClientOriginalName();
        // Ensure directory exists
        if (!file_exists(public_path('uploads/videos'))) {
            @mkdir(public_path('uploads/videos'), 0777, true);
        }

        $file->move(public_path('uploads/videos'), $filename);

        Video::create([
            'user_id' => Auth::id(),
            'video_url' => '/uploads/videos/' . $filename,
            'thumbnail_url' => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?q=80&w=1000&auto=format&fit=crop',
            'caption' => $request->caption,
            'category' => $request->category,
            'music_name' => 'Original Sound - ' . Auth::user()->username,
        ]);

        return redirect('/profile');
    }
}
