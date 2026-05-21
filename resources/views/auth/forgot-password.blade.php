<x-guest-layout>
    @section('title', 'Forgot Password')

    <div class="text-center mb-6">
        <h2 class="text-xl font-bold text-white">Reset Password</h2>
        <p class="text-sm text-sky-400 mt-1">Enter your email to receive a reset link</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="pilot@skyweave.io" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button>
                {{ __('Send Reset Link') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-sky-400 hover:text-accent transition-colors duration-200">
                &larr; Back to sign in
            </a>
        </div>
    </form>
</x-guest-layout>
