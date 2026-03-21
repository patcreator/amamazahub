<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $authUser = Auth::user();

        // Get IDs of users we follow
        $followingIds = $authUser ? $authUser->following()->pluck('users.id')->toArray() : [];

        // Get IDs of users we have messages with
        $messageParticipantIds = DB::table('messages')
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->select('sender_id', 'receiver_id')
            ->get()
            ->flatMap(function($m) use ($userId) {
                return [$m->sender_id, $m->receiver_id];
            })
            ->unique()
            ->filter(fn($id) => $id != $userId)
            ->toArray();

        // Combined unique IDs
        $allUserIds = array_unique(array_merge($followingIds, $messageParticipantIds));

        $conversations = User::whereIn('id', $allUserIds)->get()->map(function($user) use ($userId) {
            $lastMessage = Message::where(function($q) use ($userId, $user) {
                $q->where('sender_id', $userId)->where('receiver_id', $user->id);
            })->orWhere(function($q) use ($userId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $userId);
            })->latest()->first();

            $preview = '';
            if ($lastMessage) {
                if ($lastMessage->type === 'text') {
                    $preview = $lastMessage->message;
                } else if ($lastMessage->type === 'image') {
                    $preview = 'Sent an image';
                } else if ($lastMessage->type === 'video') {
                    $preview = 'Sent a video';
                } else if ($lastMessage->type === 'audio') {
                    $preview = 'Sent a voice message';
                }
            }

            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'avatar' => $user->avatar,
                'unread_count' => Message::where('sender_id', $user->id)
                    ->where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->count(),
                'last_message' => $preview,
                'last_message_time' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
            ];
        });

        return Inertia::render('Messages', [
            'conversations' => $conversations,
        ]);
    }

    public function getMessages(User $user)
    {
        $userId = Auth::id();

        // Mark messages from this user as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where(function($q) use ($userId, $user) {
                $q->where('sender_id', $userId)->where('receiver_id', $user->id);
            })
            ->orWhere(function($q) use ($userId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $userId);
            })
            ->oldest()
            ->get();

        return response()->json($messages);
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'message' => 'nullable|string',
            'type' => 'required|string|in:text,image,video,audio',
            'file' => 'nullable|file|max:20480', // 20MB max
        ]);

        $fileUrl = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('messages', 'public');
            $fileUrl = '/storage/' . $path;
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'message' => $request->message ?? '',
            'type' => $request->type,
            'file_url' => $fileUrl,
        ]);

        return response()->json($message);
    }
}
