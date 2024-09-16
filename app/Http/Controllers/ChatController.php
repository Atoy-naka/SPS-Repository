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
        // 自分と相手のIDを取得
        $myUserId = auth()->user()->id;
        $otherUserId = $user->id; // ここで相手のユーザーIDを指定

        // データベース内でチャットが存在するかを確認
        $chat = Room::where(function($query) use ($myUserId, $otherUserId) {
            $query->where('owner_id', $myUserId)
                ->where('guest_id', $otherUserId);
        })->orWhere(function($query) use ($myUserId, $otherUserId) {
            $query->where('owner_id', $otherUserId)
                ->where('guest_id', $myUserId);
        })->first();
        // チャットが存在しない場合、新しいチャットを作成
        if (!$chat) {
            $chat = new Room();
            $chat->owner_id = $myUserId;
            $chat->guest_id = $otherUserId;
            $chat->save();
        }

        $messages = Message::where('chat_id', $chat->id)->orderBy('updated_at', 'DESC')->get();;


        return view('chats/chat')->with(['chat' => $chat, 'messages' => $messages]);
    }
    
    public function sendMessage(Request $request)
    {
        $user = auth()->user();
        $strUserId = $user->id;
        $strUsername = $user->name;
    
        $strMessage = $request->input('message');
        $chatId = $request->input('chat_id');
    
        // メッセージの保存
        $message = new Message;
        $message->user_id = $strUserId;
        $message->body = $strMessage;
        $message->chat_id = $chatId;
        $message->save();
    
        // チャットの更新
        $chat = Room::find($chatId);
        $chat->updated_at = now();
        $chat->save();
    
        // イベントのディスパッチ
        $chatMessage = new Chat;
        $chatMessage->body = $strMessage;
        $chatMessage->chat_id = $chatId;
        $chatMessage->userName = $strUsername;
    
        MessageSent::dispatch($chatMessage);
    
        return response()->json(['message' => 'Message sent successfully']);
    }

    
    public function index()
    {
        $user = auth()->user();
        $chats = Room::where('owner_id', $user->id)
                    ->orWhere('guest_id', $user->id)
                    ->with(['owner', 'guest'])
                    ->get();
    
        return view('chats.index', compact('chats'));
    }

}