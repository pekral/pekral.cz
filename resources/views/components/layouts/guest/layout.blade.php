<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.guest.head')
</head>
<body class="min-h-screen bg-[#1c1b1b] text-[#d4d4d4] antialiased">
    {{-- Skip Link for Accessibility --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-primary focus:text-primary-foreground focus:rounded-md focus:font-mono">
        Skip to main content
    </a>

    <livewire:guest.navigation :is-home-page="request()->routeIs('home')" />

    <main id="main-content" class="pt-16" role="main">
        {{ $slot }}
    </main>

    <livewire:guest.footer />

    @include('cookie-consent::index')
</body>
</html>
