<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="update-profile-form" method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- アイコン画像変更 -->
        <div>
            <x-input-label for="picture" :value="__('Picture')" />
            <input id="picture" name="picture" type="file" class="mt-1 block w-full" onchange="previewImage(event)" />
            <img id="picture-preview" src="{{ Auth::user()->profile_photo_url }}" class="rounded-circle mt-2" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
            <x-input-error class="mt-2" :messages="$errors->get('picture')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- 位置情報の追加 -->
        <div>
            <x-input-label for="prefecture" :value="__('Prefecture')" />
            <x-text-input id="prefecture" name="prefecture" type="text" class="mt-1 block w-full" :value="old('prefecture', $user->prefecture)" autocomplete="prefecture" />
            <x-input-error class="mt-2" :messages="$errors->get('prefecture')" />
        </div>

        <div>
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" autocomplete="city" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div>
            <x-input-label for="district" :value="__('District')" />
            <x-text-input id="district" name="district" type="text" class="mt-1 block w-full" :value="old('district', $user->district)" autocomplete="district" />
            <x-input-error class="mt-2" :messages="$errors->get('district')" />
        </div>

        <!-- 自己紹介文の追加 -->
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full" rows="3">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <!-- ペットの追加 -->
        <div>
            <x-input-label for="pet" :value="__('Pet')" />
            <x-text-input id="pet" name="pet" type="text" class="mt-1 block w-full" :value="old('pet', $user->pet)" autocomplete="pet" />
            <x-input-error class="mt-2" :messages="$errors->get('pet')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button id="save-button">{{ __('Save') }}</x-primary-button>

            <p id="saved-message" style="display: none;" class="text-sm text-gray-600">{{ __('更新しました。') }}</p>

            <!-- プロフィール表示画面へのボタン -->
            <a href="{{ route('profileoption', ['user' => $user->id]) }}" class="btn btn-secondary">
                {{ __('プロフィールへ') }}
            </a>
        </div>
    </form>
</section>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('picture-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('save-button').addEventListener('click', function(event) {
        event.preventDefault(); // デフォルトのフォーム送信を防ぐ

        // フォームデータを取得
        var formData = new FormData(document.getElementById('update-profile-form'));

        // 非同期でフォームデータを送信
        fetch('{{ route('profile.update') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                // 成功メッセージを表示
                document.getElementById('saved-message').style.display = 'block';
                setTimeout(() => {
                    document.getElementById('saved-message').style.display = 'none';
                }, 2000);
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    });
</script>