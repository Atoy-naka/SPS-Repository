<x-app-layout>
    <x-slot name="header">
        @if($user)
            <div class="flex justify-center items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $user->name }}
                </h2>
            </div>
        @else
            <div class="flex justify-center items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    ユーザー情報が見つかりません
                </h2>
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 chat-container" id="chat-container">
                    <ul id="list_message">
                        @foreach ($messages as $message)
                            <li class="{{ $message->user->id === auth()->user()->id ? 'sent' : 'received' }}">
                                <div class="message-bubble {{ $message->user->id === auth()->user()->id ? 'sent-bubble' : 'received-bubble' }}">
                                    <div>{{ $message->body }}</div>
                                    <div class="timestamp {{ $message->user->id === auth()->user()->id ? 'sent-timestamp' : 'received-timestamp' }}" data-message-id="{{ $message->id }}">
                                        {{ $message->created_at->format('H:i') }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <form method="post" onsubmit="onsubmit_Form(); return false;" class="message-form">
        メッセージ : <input type="text" id="input_message" autocomplete="off" style="width: 80%;" />
        <input type="hidden" id="chat_id" name="chat_id" value="{{ $chat->id }}"> 
        <button type="submit" class="text-white bg-blue-700 px-5 py-2">送信</button>
    </form>
<script>
    const elementInputMessage = document.getElementById("input_message");
    const chatId = document.getElementById("chat_id").value;

    function onsubmit_Form() {
        let strMessage = elementInputMessage.value;
        if (!strMessage) {
            return;
        }
        params = {
            'message': strMessage,
            'chat_id': chatId
        };

        axios
            .post('/chat', params)
            .then(response => {
                console.log(response);
                console.log(chatId);
            })
            .catch(error => {
                console.log('AAA');
                console.log(error.response);
            });
        elementInputMessage.value = "";
    }

    function addMessageToList(message, isSent, messageId) {
        console.log("isSent:", isSent);
        const elementListMessage = document.getElementById("list_message");
        let elementLi = document.createElement("li");
        elementLi.className = isSent ? 'received' : 'sent';
        let elementBubble = document.createElement("div");
        elementBubble.className = isSent ? 'message-bubble received-bubble' : 'message-bubble sent-bubble';
        let elementMessage = document.createElement("div");
        let elementTimestamp = document.createElement("div");
        elementTimestamp.className = isSent ? 'timestamp received-timestamp' : 'timestamp sent-timestamp';
        elementTimestamp.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        elementTimestamp.dataset.messageId = messageId;
        elementMessage.textContent = message;
        elementBubble.append(elementMessage);
        elementBubble.append(elementTimestamp);
        elementLi.append(elementBubble);
        elementListMessage.prepend(elementLi);
        elementListMessage.scrollTop = elementListMessage.scrollHeight;
    }

    window.addEventListener("DOMContentLoaded", () => {
        const elementListMessage = document.getElementById("list_message");
        const chatContainer = document.getElementById("chat-container");
        chatContainer.scrollTop = chatContainer.scrollHeight;
        window.Echo.private('chat').listen('MessageSent', (e) => {
            console.log(e);

            if (e.chat.chat_id === chatId) {
                addMessageToList(e.chat.body, true, e.chat.id);
            }
        });
    });
</script>

<style>
    .sent {
        text-align: right;
    }
    .received {
        text-align: left;
    }
    .message-bubble {
        display: inline-block;
        padding: 10px;
        margin: 10px;
        border-radius: 10px;
        position: relative;
    }
    .sent-bubble {
        background-color: #98FB98; /* 自分のメッセージの色を黄緑に */
    }
    .received-bubble {
        background-color: #ADD8E6; /* 相手のメッセージの色を水色に */
    }
    .timestamp {
        font-size: 0.8em;
        color: #555;
        position: absolute;
        bottom: 0;
    }
    .sent-timestamp {
        right: 100%; /* メッセージの左側に表示 */
        margin-right: 10px; /* メッセージとの間隔を調整 */
    }
    .received-timestamp {
        left: 100%; /* メッセージの右側に表示 */
        margin-left: 10px; /* メッセージとの間隔を調整 */
    }
    .message-form {
        position: fixed;
        bottom: 10px;
        right: 10px;
        background-color: white;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: calc(100% - 40px); /* フォームの幅を調整 */
    }
    .chat-container {
        height: 70vh; /* チャット欄の高さを調整 */
        overflow-y: auto; /* スクロールを有効に */
    }
    ul {
        list-style-type: none; /* 黒い点を表示しない */
        padding: 0;
        display: flex;
        flex-direction: column-reverse; /* 最新のメッセージを下に表示 */
    }
</style>
</x-app-layout>
