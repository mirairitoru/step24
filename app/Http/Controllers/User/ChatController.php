<?php

namespace App\Http\Controllers\User;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\AdoptionMatch;
use App\Models\Message;
use App\Models\MessageRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('web')->user();
        $keyword = $request->input('q');

        $matches = AdoptionMatch::with([
            'animal.organization.image',
            'animal',
            'chat.messages.reads',
        ])
        ->where('user_id', $user->id)
        ->when($keyword, function ($query) use ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('animal', function ($query) use ($keyword) {
                    $query->where('animal_name', 'like', "%{$keyword}%");
                })
                ->orWhereHas('animal.organization', function ($query) use ($keyword) {
                    $query->where('org_name', 'like', "%{$keyword}%");
                });
            });
        })
        ->latest()
        ->get()
        ->map(function ($match) {
            if(!$match->chat) {
                $match->unread_count = 0;
                return $match;
            }

            $unreadCount = $match->chat->messages
                ->where('sender_type', 'organization')
                ->filter(function ($message) {
                    return $message->reads
                        ->where('reader_type', 'user')
                        ->where('reader_id', Auth::guard('web')->id())
                        ->isEmpty();
                })
                ->count();
            $match->unread_count = $unreadCount;

            return $match;
        });

        return view('user.chat.index',[
            'matches' => $matches,
            'selectedMatch' => null,
            'messages' => collect(),
        ]);
    }

    public function show(AdoptionMatch $match)
    {
        $user = Auth::guard('web')->user();

        abort_if(
            $match->user_id !== $user->id,
            403
        );

        $chat = $match->chat;
        $messages = $chat
            ? $chat->messages()
                ->with('reads')
                ->orderBy('created_at', 'asc')
                ->get()
            : collect();

        foreach($messages as $message) {
            if($message->sender_type !== 'organization') {
                continue;
            }

            MessageRead::firstOrCreate(
                [
                    'message_id' => $message->id,
                    'reader_type' => 'user',
                    'reader_id' => $user->id,
                ],
                [
                    'read_at' => now()
                ]
            );
        }

        $matches = AdoptionMatch::with([
            'animal.organization.image',
            'animal',
            'chat.messages.reads',
        ])
        ->where('user_id', $user->id)
        ->latest()
        ->get()
        ->map(function ($match) use ($user) {
            if(!$match->caht) {
                $match->unread_count = 0;
                return $match;
            }

            $match->unread_count = $match->chat->messages
                ->where('sender_type', 'organization')
                ->filter(function ($message) use ($user) {
                    return $message->reads
                        ->where('reader_type', 'user')
                        ->where('reader_id', $user->id)
                        ->isEmpty();
                })
                ->count();
            return $match;
        });

        return view('user.chat.index',[
            'matches' => $matches,
            'selectedMatch' => $match,
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, AdoptionMatch $match)
    {

        abort_if($match->user_id !== Auth::guard('web')->id(), 403);

        $request->validate([
            'message' => ['required'],
        ]);

        Message::create([
            'chat_id' => $match->chat->id,
            'sender_type' => 'user',
            'sender_id' => Auth::guard('web')->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('user.chat.show', $match);
    }
}
