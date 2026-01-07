<!DOCTYPE html>
<html lang="cs">
<head>
    @include('partials.guest.head')
</head>
<body class="min-h-screen bg-[#1c1b1b] text-[#d4d4d4] antialiased">
    <livewire:guest.navigation :is-home-page="request()->routeIs('home')" />

    <main class="pt-16">
        {{ $slot }}
    </main>

    <livewire:guest.footer />

    @include('cookie-consent::index')
</body>
</html>
