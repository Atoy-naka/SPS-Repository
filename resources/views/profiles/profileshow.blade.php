<style>
    .rounded-circle {
        border-radius: 50%;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="profile-header p-6">
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="rounded-circle" alt="Profile Photo" style="width: 150px; height: 150px; object-fit: cover;">
                    <h2>USER NAME:{{ Auth::user()->name }}</h2>
                    <p>PET:{{ Auth::user()->pet }}</p>
                    <p>BIO:{{ Auth::user()->bio }}</p>
                </div>
                <div class="p-6">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">編集</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
