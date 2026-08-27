@extends('layouts.guest')

@section('title', 'Login — Ink & Paper')

@section('public-content')
    <div class="mx-auto max-w-md px-4 py-12 sm:px-6">
        
        <!-- Header -->
        <div class="text-center">
            <span class="text-xs font-bold uppercase tracking-widest text-primary">Welcome Back</span>
            <h1 class="mt-1 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                Sign in to Ink & Paper
            </h1>
            <p class="mt-2 text-sm text-muted">
                Enter your credentials to access your author dashboard.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mt-6" :status="session('status')" />

        <!-- Login Card -->
        <div class="mt-8 rounded-2xl border border-border bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-ink">
                        {{ __('Email Address') }}
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
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
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-bold text-ink">
                            {{ __('Password') }}
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-semibold text-muted transition hover:text-primary" href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password" 
                        placeholder="••••••••"
                        class="mt-2 w-full rounded-xl border border-border bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                    >
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            name="remember" 
                            class="h-4 w-4 rounded border-border text-primary focus:ring-primary"
                        >
                        <span class="ms-2 text-sm font-medium text-muted">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <x-button type="submit" class="w-full justify-center">
                        {{ __('Sign In') }}
                    </x-button>
                </div>
            </form>
        </div>

        <!-- Footer / Register Link -->
        @if (Route::has('register'))
            <p class="mt-6 text-center text-sm text-muted">
                Don't have an account yet? 
                <a href="{{ route('register') }}" class="font-bold text-primary hover:underline">
                    Create an account
                </a>
            </p>
        @endif

    </div>
@endsection