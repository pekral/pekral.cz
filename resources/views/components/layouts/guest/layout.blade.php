<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.guest.head')
</head>
<body class="min-h-screen antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-primary focus:text-primary-foreground focus:rounded-md focus:font-mono">
        Skip to main content
    </a>

    <livewire:guest.navigation />

    <main id="main-content" role="main">
        {{ $slot }}
    </main>

    <livewire:guest.footer />

    @include('cookie-consent::index')
    @livewireScripts
</body>
</html>
