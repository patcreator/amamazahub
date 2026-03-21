<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Repost;
use App\Models\Share;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialActionController extends Controller
{
    public function repost(Video $video)
    {
        $userId = Auth::id();
        $repost = Repost::where('user_id', $userId)->where('video_id', $video->id)->first();

        if ($repost) {
            $repost->delete();
            $video->decrement('reposts_count');
            $reposted = false;
        } else {
            Repost::create([
                'user_id' => $userId,
                'video_id' => $video->id,
            ]);
            $video->increment('reposts_count');
            $reposted = true;
        }

        return response()->json([
            'reposted' => $reposted,
            'reposts_count' => $video->reposts_count
        ]);
    }

    public function share(Video $video)
    {
        $userId = Auth::id();
        
        // Shares are usually tracked every time or once per user? 
        // For TikTok style, we'll track the action.
        Share::create([
            'user_id' => $userId,
            'video_id' => $video->id,
        ]);
        
        $video->increment('shares_count');

        return response()->json([
            'shares_count' => $video->shares_count
        ]);
    }

    public function bookmark(Video $video)
    {
        $userId = Auth::id();
        $bookmark = Bookmark::where('user_id', $userId)->where('video_id', $video->id)->first();

        if ($bookmark) {
            $bookmark->delete();
            $video->decrement('bookmarks_count');
            $bookmarked = false;
        } else {
            Bookmark::create([
                'user_id' => $userId,
                'video_id' => $video->id,
            ]);
            $video->increment('bookmarks_count');
            $bookmarked = true;
        }

        return response()->json([
            'bookmarked' => $bookmarked,
            'bookmarks_count' => $video->bookmarks_count
        ]);
    }
}
