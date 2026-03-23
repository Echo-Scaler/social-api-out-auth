<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome Back</h2>
        <p class="mt-2 text-sm text-gray-600 font-medium">Please enter your details to sign in</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <x-ui.input label="Email Address" name="email" type="email" :value="old('email')" required autofocus placeholder="john@example.com" />

        <x-ui.input label="Password" name="password" type="password" required placeholder="••••••••" />

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-lg border-gray-300 text-indigo-100 shadow-sm focus:ring-indigo-100 w-5 h-5 transition cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-gray-600 font-medium select-none">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-blue-400 hover:text-gray-600 transition underline-offset-4 hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-ui.button class="w-full" size="lg">
                {{ __('Sign In') }}
            </x-ui.button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 font-medium">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition underline-offset-4 hover:underline">Create one</a>
            </p>
        </div>
    </form>
</x-guest-layout>
