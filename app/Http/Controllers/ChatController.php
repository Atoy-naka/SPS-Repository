<?php

namespace App\Http\Controllers;

use App\Library\Chat;
use App\Models\Room;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function openChat(User $user)
    {
        $myUserId = auth()->user()->id;
        $otherUserId = $user->id;
    
        $chat = Room::where(function($query) use ($myUserId, $otherUserId) {
            $query->where('owner_id', $myUserId)
                ->where('guest_id', $otherUserId);
        })->orWhere(function($query) use ($myUserId, $otherUserId) {
            $query->where('owner_id', $otherUserId)
                ->where('guest_id', $myUserId);
        })->with(['owner', 'guest'])->first();
    
        if (!$chat) {
            $chat = new Room();
            $chat->owner_id = $myUserId;
            $chat->guest_id = $otherUserId;
            $chat->save();
        }
    
        $messages = Message::where('chat_id', $chat->id)->orderBy('updated_at', 'DESC')->get();
    
        return view('chats/chat')->with(['chat' => $chat, 'messages' => $messages, 'user' => $user]);
    }

    public function sendMessage(Request $request)
    {
        $user = auth()->user();
        $strUserId = $user->id;
        $strUsername = $user->name;
    
        $strMessage = $request->input('message');
        $chatId = $request->input('chat_id');
    
        $chat = new Chat;
        $chat->body = $strMessage;
        $chat->chat_id = $chatId;
        $chat->userName = $strUsername;
    
        MessageSent::dispatch($chat);
    
        $message = new Message;
        $message->user_id = $strUserId;
        $message->body = $strMessage;
        $message->chat_id = $chatId;
        $message->save();
    
        return response()->json(['message_id' => $message->id]);
    }

    public function index()
    {
        $userId = auth()->user()->id;
    
        $chats = Room::where('owner_id', $userId)
                    ->orWhere('guest_id', $userId)
                    ->with(['owner', 'guest', 'messages'])
                    ->get();
    
        return view('chats.index', compact('chats'));
    }
    
    public function destroy(Room $chat)
    {
        $chat->messages()->delete();
        $chat->delete();
    
        return redirect()->route('chats.index')->with('success', 'チャットルームが削除されました');
    }
}
