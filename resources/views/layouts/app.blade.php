<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="@yield('description', 'Ink & Paper — A modern publishing platform for writers and readers.')">

    <title>
        @yield('title', 'Ink & Paper')
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:opsz,wght@8..60,400;8..60,500;8..60,600;8..60,700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-paper text-ink antialiased">

    <div class="flex min-h-screen flex-col">

        <x-navbar />

        <main class="flex-1">
            {{-- Alert Success Notification --}}
            @if (session('success'))
                <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                    <div
                        class="flex items-center justify-between rounded-xl border border-primary/20 bg-primary/10 p-4 text-sm font-medium text-primary">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')

        </main>

        <x-footer />

    </div>

</body>

</html>
