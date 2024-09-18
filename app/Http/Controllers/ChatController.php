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
    
        // $user変数をビューに渡す
        return view('chats/chat')->with(['chat' => $chat, 'messages' => $messages, 'user' => $user]);
    }



    public function sendMessage(Request $request)
    {
        // 現在認証されているユーザーを取得
        $user = auth()->user();
        $strUserId = $user->id;
        $strUsername = $user->name;
    
        // リクエストからメッセージとチャットIDを取得
        $strMessage = $request->input('message');
        $chatId = $request->input('chat_id');
    
        // 新しいChatオブジェクトを作成し、メッセージ情報を設定
        $chat = new Chat;
        $chat->body = $strMessage;
        $chat->chat_id = $chatId;
        $chat->userName = $strUsername;
    
        // メッセージ送信イベントをディスパッチ
        MessageSent::dispatch($chat);
    
        // 新しいMessageオブジェクトを作成し、データベースに保存
        $message = new Message;
        $message->user_id = $strUserId;
        $message->body = $strMessage;
        $message->chat_id = $chatId;
        $message->save();
    
        // メッセージ送信成功のレスポンスを返す
        return response()->json(['message' => 'Message sent successfully']);
    }
    
    public function index()
    {
        // 現在認証されているユーザーのIDを取得
        $userId = auth()->user()->id;
    
        // ユーザーがオーナーまたはゲストとして参加しているチャットルームを取得し、関連するオーナー、ゲスト、メッセージをロード
        $chats = Room::where('owner_id', $userId)
                    ->orWhere('guest_id', $userId)
                    ->with(['owner', 'guest', 'messages'])
                    ->get();
    
        // チャット一覧ビューを表示し、取得したチャットルームを渡す
        return view('chats.index', compact('chats'));
    }

}
