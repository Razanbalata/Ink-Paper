@extends('layouts.guest')

@section('title', 'Forgot Password — Ink & Paper')

@section('public-content')
    <div class="mx-auto max-w-md px-4 py-12 sm:px-6">
        
        <!-- Header -->
        <div class="text-center">
            <span class="text-xs font-bold uppercase tracking-widest text-primary">Account Recovery</span>
            <h1 class="mt-1 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                Forgot your password?
            </h1>
            <p class="mt-2 text-sm text-muted">
                No problem. Enter your email address and we'll send you a link to reset your password.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mt-6" :status="session('status')" />

        <!-- Card Form -->
        <x-card class="mt-8">
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-ink">
                        {{ __('Email Address') }} <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        placeholder="you@example.com"
                        class="mt-2 w-full rounded-xl border border-border bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div>
                    <x-button type="submit" class="w-full justify-center">
                        {{ __('Email Password Reset Link') }}
                    </x-button>
                </div>
            </form>
        </x-card>

        <!-- Footer Link -->
        <p class="mt-6 text-center text-sm text-muted">
            Remembered your password? 
            <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">
                Sign in
            </a>
        </p>

    </div>
@endsection