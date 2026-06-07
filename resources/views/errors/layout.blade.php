<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — TripKuy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-surface min-h-screen flex flex-col antialiased">

    <header class="border-b border-border bg-white px-4 sm:px-6 h-16 flex items-center">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 no-underline">
            <div class="w-9 h-9 bg-gradient-to-br from-brand-600 to-teal-500 rounded-md flex items-center justify-center">
                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21 4 19 4c-2 0-4 0-5.5 1.5L10 9 1.8 6.2c-.5-.2-.9.1-.8.5l.5 3.1c.1.5.4.9.8 1.1L6 12l-2 3H2l-1 2 3 1 1 3 2-1v-2l3-2 1.5 3.5c.2.4.6.7 1.1.8l3.1.5c.5.1.8-.3.5-.8L9 12l3.5-3.5 3.2 1.3c.4.2.9 0 1.1-.5.2-.3.3-.6.2-.9z"/>
                </svg>
            </div>
            <span class="font-display font-extrabold text-xl text-ink">TripKuy</span>
        </a>
    </header>

    <main class="flex-1 flex items-center justify-center px-4 py-20">
        <div class="text-center max-w-sm w-full">
            @yield('content')
        </div>
    </main>

    <footer class="border-t border-border px-4 py-5 text-center">
        <p class="text-xs text-ink-muted">© {{ date('Y') }} TripKuy. Hak cipta dilindungi.</p>
    </footer>

</body>
</html>
