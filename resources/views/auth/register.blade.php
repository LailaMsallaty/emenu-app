<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/admin">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

@php

    $store = (app()->bound('store.active'))?app()->make('store.active'):null;

@endphp
         <!-- Domain -->
        @if($store==null)
            <div class="mt-4">
                <x-label for="domain" :value="__('Domain')" />

                <x-input id="domain" class="block mt-1 w-full" type="text" name="domain" :value="old('domain')" autofocus />
            </div>

            <!-- db username  -->
            <div class="mt-4">
                <x-label for="dbusername" :value="__('DB Username')" />

                <x-input id="dbusername" class="block mt-1 w-full" type="text" name="dbusername" :value="old('dbusername')" />
            </div>

            <!--db Password -->
            <div class="mt-4">
                <x-label for="dbpassword" :value="__('DB Password')" />

                <x-input id="dbpassword" class="block mt-1 w-full"
                                type="password"
                                name="dbpassword"
                                autocomplete="new-password" />
            </div>
            <!-- Confirm DB Password -->
            <div class="mt-4">
                <x-label for="dbpassword_confirmation" :value="__('Confirm DB Password')" />

                <x-input id="dbpassword_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="dbpassword_confirmation"  />
            </div>
        @endif

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
