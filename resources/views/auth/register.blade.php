@extends('layouts.guest')

@section('title', 'Register — Ink & Paper')

@section('public-content')
    <div class="mx-auto max-w-md px-4 py-12 sm:px-6">
        
        <!-- Header -->
        <div class="text-center">
            <span class="text-xs font-bold uppercase tracking-widest text-primary">Join the Community</span>
            <h1 class="mt-1 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                Create your account
            </h1>
            <p class="mt-2 text-sm text-muted">
                Start writing, sharing, and organizing your stories today.
            </p>
        </div>

        <!-- Register Card -->
        <div class="mt-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-ink">
                        {{ __('Full Name') }} <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus 
                        autocomplete="name" 
                        placeholder="John Doe"
                        class="mt-2 w-full rounded-xl border border-border bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                    >
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

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
                        autocomplete="username" 
                        placeholder="you@example.com"
                        class="mt-2 w-full rounded-xl border border-border bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-ink">
                        {{ __('Password') }} <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password" 
                        placeholder="••••••••"
                        class="mt-2 w-full rounded-xl border border-border bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                    >
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-ink">
                        {{ __('Confirm Password') }} <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password" 
                        placeholder="••••••••"
                        class="mt-2 w-full rounded-xl border border-border bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                    >
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div>
                    <x-button type="submit" class="w-full justify-center">
                        {{ __('Create Account') }}
                    </x-button>
                </div>
            </form>
        </div>

        <!-- Footer / Login Link -->
        <p class="mt-6 text-center text-sm text-muted">
            Already registered? 
            <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">
                Sign in
            </a>
        </p>

    </div>
@endsection