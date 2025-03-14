<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />


    <form action="{{ route('logout') }}" method="post">
    @csrf
    <button type="submit">Click</button>
</form>

    <form method="POST" action="{{ route('login') }}" class="text-secondary_blue">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('login.email')" class="text-secondary_blue" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('login.password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mt-4 flex flex-row justify-between items-center">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded bg-primary_white border-secondary_blue text-secondary_blue focus:ring-secondary_blue "
                    name="remember">
                <span class="ms-2 text-sm text-secondary_blue">{{ __('login.remember_me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-secondary_blue opacity-85" href="{{ route('password.request') }}">
                    {{ __('login.forgot_password') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end mt-7">
            <button type="submit"
                class="rounded-md px-4 py-2 bg-accent_blue text-primary_white text-base hover:opacity-25 transition-opacity ">{{ __('login.login') }}</button>
        </div>

        <div
            class="w-full mt-7 border border-t-secondary_blue border-x-0 border-b-0 py-4 flex justify-center items-center">
            <div
                class=" text-primary_white rounded-xl hover:opacity-60 transition-opacity border-b-2 border-secondary_blue pb-2">
                <a href="{{ route('register') }}"
                    class=" text-secondary_blue text-base flex justify-center flex-row items-center gap-2">
                    <div class="w-[35px]">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M6 16.9998C6 17.3511 6 17.5268 6.01567 17.6795C6.14575 18.9473 7.0626 19.9945 8.30206 20.291C8.45134 20.3267 8.6255 20.3499 8.97368 20.3963L15.5656 21.2753C17.442 21.5254 18.3803 21.6505 19.1084 21.361C19.7478 21.1068 20.2803 20.6406 20.6168 20.0405C21 19.3569 21 18.4104 21 16.5174V7.48232C21 5.58928 21 4.64275 20.6168 3.95923C20.2803 3.35911 19.7478 2.89288 19.1084 2.63868C18.3803 2.34914 17.442 2.47423 15.5656 2.72442L8.97368 3.60335C8.62546 3.64978 8.45135 3.67299 8.30206 3.7087C7.0626 4.0052 6.14575 5.05241 6.01567 6.32018C6 6.47288 6 6.64854 6 6.99984M12 7.99984L16 11.9998M16 11.9998L12 15.9998M16 11.9998H3"
                                    stroke="#2867A4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </g>
                        </svg>
                    </div>
                    <p class="">
                        {{ __('login.register') }}
                    </p>
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>