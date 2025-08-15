<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" placeholder="Full Name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" placeholder="Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- User type  -->
        <div class="mt-4 ml-1 flex items-center">
            <x-input-label for="user_type" :value="__('Register as a')" class="text-[16px]" />
            <select name="user_type" id="role" class="border-0 focus:ring-0">
                <option value="{{ $roles[1]->id }}">{{ $roles[1]->name }}</option>
                <option value="{{ $roles[2]->id }}" selected>{{ $roles[2]->name }}</option>
            </select>
        </div>

        <!-- Category  -->
        <div class="ml-1 hidden items-center" id="category">
            <x-input-label for="category" :value="__('Profetion:')" class="text-[16px]" />
            <select name="category_id" class=" border-0 focus:ring-0">
                <option value="" selected>Choose your Profetion</option>
                @foreach ($categorys as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                placeholder="Address" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" placeholder="Password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Profil image --}}
        <div class="w-full mt-4 flex flex-col items-center gap-2">
            <x-input-label for="profil" :value="__('Profil picture')" />
            <x-text-input id="profil" accept="image/*" class="block mt-1 w-fit" type="file" name="profil" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
