<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'Trending');
        $search = $request->query('search');
        
        $query = Video::with('user')
            ->withCount(['likes', 'comments', 'reposts', 'shares', 'bookmarks'])
            ->withExists(['likes' => function ($q) {
                $q->where('user_id', Auth::id());
            }])
            ->withExists(['reposts' => function ($q) {
                $q->where('user_id', Auth::id());
            }])
            ->withExists(['bookmarks' => function ($q) {
                $q->where('user_id', Auth::id());
            }]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('caption', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('username', 'like', "%{$search}%");
                  });
            });
        } else {
            $query->where('category', $category);
        }

        $videos = $query->latest()->paginate(12);

        $categories = ['Trending', 'Comedy', 'Education', 'Gaming', 'Music', 'Vlogs'];

        return Inertia::render('Explore', [
            'videos' => $videos,
            'currentCategory' => $category,
            'categories' => $categories
        ]);
    }
}
