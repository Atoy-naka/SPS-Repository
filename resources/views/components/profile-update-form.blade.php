<div>
    <div class="mt-4">
        <x-label for="prefecture" :value="__('Prefecture')" />
        <x-input id="prefecture" class="block mt-1 w-full" type="text" name="prefecture" :value="old('prefecture', $user->prefecture)" />
    </div>

    <div class="mt-4">
        <x-label for="city" :value="__('City')" />
        <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city', $user->city)" />
    </div>

    <div class="mt-4">
        <x-label for="district" :value="__('District')" />
        <x-input id="district" class="block mt-1 w-full" type="text" name="district" :value="old('district', $user->district)" />
    </div>
</div>