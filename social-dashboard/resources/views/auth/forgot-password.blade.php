<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 leading-relaxed font-medium">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <x-ui.input label="Email Address" name="email" type="email" :value="old('email')" required autofocus placeholder="john@example.com" />

        <div class="pt-2">
            <x-ui.button class="w-full" size="lg">
                {{ __('Email Reset Link') }}
            </x-ui.button>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-500 transition underline-offset-4 hover:underline">
                Back to Sign In
            </a>
        </div>
    </form>
</x-guest-layout>
