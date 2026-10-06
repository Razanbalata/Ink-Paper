@extends('layouts.guest')

@section('title', 'Contact — Ink & Paper')

@section('public-content')

<section class="mx-auto max-w-3xl px-4 py-24 sm:px-6 lg:px-8">

    <div class="max-w-2xl">

        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary">
            Contact
        </p>

        <h1 class="mt-4 font-serif text-5xl font-semibold">
            Let's talk.
        </h1>

        <p class="mt-5 leading-7 text-muted">
            Have a question, suggestion, or just want to say hello?
            Send us a message.
        </p>

    </div>


    <form class="mt-12 space-y-6">

        <x-input
            name="name"
            label="Name"
            placeholder="Your name"
        />

        <x-input
            name="email"
            type="email"
            label="Email"
            placeholder="you@example.com"
        />

        <x-textarea
            name="message"
            label="Message"
            placeholder="Write your message..."
        />

        <x-button type="submit">
            Send Message
        </x-button>

    </form>

</section>

@endsection