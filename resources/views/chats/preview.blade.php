<!-- resources/views/preview.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                画像プレビュー
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="image_preview">
                        <img id="preview" src="data:image/png;base64,{{ session('image_data') }}" alt="Image Preview" style="max-width: 100%;">
                    </div>
                    <form method="post" onsubmit="onsubmit_PreviewForm(); return false;" class="mt-4">
                        <input type="hidden" id="chat_id" name="chat_id" value="{{ $chat->id }}">
                        <input type="hidden" id="image_data" name="image_data" value="{{ session('image_data') }}">
                        <button type="submit" class="text-white bg-blue-700 px-5 py-2">送信</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
    function onsubmit_PreviewForm() {
        const chatId = document.getElementById("chat_id").value;
        const imageData = document.getElementById("image_data").value;

        let formData = new FormData();
        formData.append('chat_id', chatId);
        formData.append('image_data', imageData);

        axios
            .post('/chat/send-image', formData)
            .then(response => {
                console.log(response);
                window.location.href = '/chat/' + chatId;
            })
            .catch(error => {
                console.log(error.response);
            });
    }
</script>
</x-app-layout>
