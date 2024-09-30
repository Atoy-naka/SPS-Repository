<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('プロフィール情報') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("アカウントのプロフィール情報とメールアドレスを更新してください。") }}
        </p>
    </header>

    <form id="update-profile-form" method="post" action='/profile' class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- アイコン画像変更 -->
        <div>
            <x-input-label for="picture" :value="__('アイコン画像')" />
            <input id="picture" name="picture" type="file" class="mt-1 block w-full" onchange="previewImage(event)" />
            <img id="picture-preview" src="{{ Auth::user()->profile_photo_url }}" class="rounded-circle mt-2" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
            <x-input-error class="mt-2" :messages="$errors->get('picture')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('名前')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('メールアドレス')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('メールアドレスが未確認です。') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('確認メールを再送信するにはここをクリックしてください。') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('新しい確認リンクがメールアドレスに送信されました。') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- 位置情報の追加 -->
        <div>
            <x-input-label for="prefecture" :value="__('都道府県')" />
            <x-text-input id="prefecture" name="prefecture" type="text" class="mt-1 block w-full" :value="old('prefecture', $user->prefecture)" autocomplete="prefecture" />
            <x-input-error class="mt-2" :messages="$errors->get('prefecture')" />
        </div>

        <div>
            <x-input-label for="city" :value="__('市区町村')" />
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" autocomplete="city" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div>
            <x-input-label for="district" :value="__('地区')" />
            <x-text-input id="district" name="district" type="text" class="mt-1 block w-full" :value="old('district', $user->district)" autocomplete="district" />
            <x-input-error class="mt-2" :messages="$errors->get('district')" />
        </div>

        <!-- 自己紹介文の追加 -->
        <div>
            <x-input-label for="bio" :value="__('自己紹介文')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full" rows="3">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <!-- ペットの追加 -->
        <div>
            <x-input-label for="pet" :value="__('ペット')" />
            <x-text-input id="pet" name="pet" type="text" class="mt-1 block w-full" :value="old('pet', $user->pet)" autocomplete="pet" />
            <x-input-error class="mt-2" :messages="$errors->get('pet')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('保存') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('保存しました。') }}</p>
            @endif
            <p id="saved-message" style="display: none;" class="text-sm text-gray-600">{{ __('更新しました。') }}</p>


            <!-- プロフィール表示画面へのボタン -->
            <a href="{{ route('profileoption', ['user' => $user->id]) }}" class="btn btn-secondary">
                {{ __('プロフィールへ') }}
            </a>
        </div>
    </form>
</section>
