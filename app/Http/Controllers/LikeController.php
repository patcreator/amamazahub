<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Video $video)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $like = Like::where('user_id', $user->id)->where('video_id', $video->id)->first();

        if ($like) {
            $like->delete();
            $video->decrement('likes_count');
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'video_id' => $video->id,
            ]);
            $video->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $video->likes_count
        ]);
    }
}
