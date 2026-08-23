@extends('layouts.guest')

@section('title', 'Reset Password — Ink & Paper')

@section('public-content')
    <div class="mx-auto max-w-md px-4 py-12 sm:px-6">
        
        <!-- Header -->
        <div class="text-center">
            <span class="text-xs font-bold uppercase tracking-widest text-primary">Security</span>
            <h1 class="mt-1 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                Reset Password
            </h1>
            <p class="mt-2 text-sm text-muted">
                Please enter your email and set a new password for your account.
            </p>
        </div>

        <!-- Card Form -->
        <x-card class="mt-8">
            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-ink">
                        {{ __('Email Address') }} <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $request->email) }}" 
                        required 
                        autofocus 
                        autocomplete="username" 
                        placeholder="you@example.com"
                        class="mt-2 w-full rounded-xl border border-border bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-ink">
                        {{ __('New Password') }} <span class="text-red-500">*</span>
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
                        {{ __('Confirm New Password') }} <span class="text-red-500">*</span>
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
                        {{ __('Reset Password') }}
                    </x-button>
                </div>
            </form>
        </x-card>

    </div>
@endsection