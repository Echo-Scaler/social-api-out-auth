<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Create Account</h2>
        <p class="mt-2 text-sm text-gray-600 font-medium">Join us for premium social analytics</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <x-ui.input label="Full Name" name="name" :value="old('name')" required autofocus placeholder="John Doe" />

        <x-ui.input label="Email Address" name="email" type="email" :value="old('email')" required placeholder="john@example.com" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-ui.input label="Password" name="password" type="password" required placeholder="••••••••" />
            <x-ui.input label="Confirm Password" name="password_confirmation" type="password" required placeholder="••••••••" />
        </div>

        <div class="pt-2">
            <x-ui.button class="w-full" size="lg">
                {{ __('Register Now') }}
            </x-ui.button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 font-medium">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition underline-offset-4 hover:underline">Sign in</a>
            </p>
        </div>
    </form>
</x-guest-layout>
