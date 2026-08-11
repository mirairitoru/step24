<?php

namespace App\Http\Controllers\Org;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\AdoptionMatch;
use App\Models\Chat;
use App\Models\Message;
use App\Models\MessageRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgChatController extends Controller
{
    public function index(Request $request)
    {
        $organization = Auth::guard('org')->user();
        $keyword = $request->input('q');

        $matches = AdoptionMatch::with([
            'user.image',
            'animal',
            'chat.messages.reads',
        ])
        ->whereHas('animal', function($query) use ($organization) {
            $query->where('organization_id', $organization->id);
        })
        ->when($keyword, function ($query) use ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('animal', function ($animal) use ($keyword) {
                    $animal->where('animal_name', 'like', "%{$keyword}%");
                })

                // ユーザー名ニックネーム
                ->orWhereHas('user', function ($user) use ($keyword) {
                    $user->where('user_name', 'like', "%{$keyword}%")
                        ->orWhere('nickname', 'like', "%{$keyword}%");
                });
            });
        })
        ->latest()
        ->get()
        ->map(function($match) {
            if(!$match->chat) {
                $match->unread_count = 0;
                return $match;
            }

            $unreadCount = $match->chat->messages
                ->where('sender_type', 'user')
                ->filter(function ($message) {
                    return $message->reads
                        ->where('reader_type', 'organization')
                        ->where('reader_id', Auth::guard('org')->id())
                        ->isEmpty();
                })
                ->count();
            $match->unread_count = $unreadCount;

            return $match;
        });

        return view('org.chat.index',[
            'matches' => $matches,
            'selectedMatch' => null,
            'messages' => collect(),
        ]);
    }

    public function show(AdoptionMatch $match)
    {

        $organization = Auth::guard('org')->user();

        abort_if(
            $match->animal->organization_id !== $organization->id,
            403
        );

        $matches = AdoptionMatch::with([
            'user.image',
            'animal',
            'chat.messages.reads',
        ])
        ->whereHas('animal', function ($query) use ($organization) {
            $query->where('organization_id', $organization->id);
        })
        ->latest()
        ->get()
        ->map(function ($match) use ($organization) {
            if(!$match->chat) {
                $match->unread_count = 0;
                return $match;
            }

            $match->unread_count = $match->chat->messages
                ->where('sender_type', 'user')
                ->filter(function ($message) use ($organization) {
                    return $message->reads
                        ->where('reader_type', 'organization')
                        ->where('reader_id', $organization->id)
                        ->isEmpty();
                })
                ->count();
            return $match;
        });
        $chat = $match->chat;
        $messages = $chat
            ? $chat->messages()
                ->with('reads')
                ->orderBy('created_at', 'asc')
                ->get()
            : collect();

        foreach($messages as $message) {
            if($message->sender_type !== 'user') {
                continue;
            }

            MessageRead::firstOrCreate(
                [
                    'message_id' => $message->id,
                    'reader_type' => 'organization',
                    'reader_id' => $organization->id,
                ],
                [
                    'read_at' => now()
                ]
            );
        }

        return view('org.chat.index',[
            'matches' => $matches,
            'selectedMatch' => $match,
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, AdoptionMatch $match)
    {

        abort_if($match->animal->organization_id !== Auth::guard('org')->id(), 403);

        $request->validate([
            'message' => ['required'],
        ]);

        Message::create([
            'chat_id' => $match->chat->id,
            'sender_type' => 'organization',
            'sender_id' => Auth::guard('org')->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('org.chat.show', $match);
    }
}
