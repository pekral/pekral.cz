<html lang="en">
<head>
    @include('partials.guest.head')
</head>

<body>
<div id="root">
    <div role="region" aria-label="Notifications (F8)" tabindex="-1" style="pointer-events: none;">
        <ol tabindex="-1"
            class="fixed top-0 z-[100] flex max-h-screen w-full flex-col-reverse p-4 sm:bottom-0 sm:right-0 sm:top-auto sm:flex-col md:max-w-[420px]"></ol>
    </div>
    <section aria-label="Notifications alt+T" tabindex="-1" aria-live="polite" aria-relevant="additions text"
             aria-atomic="false"></section>
    <div class="min-h-screen bg-background text-foreground">
        @include('partials.guest.nav')
        <main role="main">
           {{$slot}}
        </main>
        <footer class="bg-background border-t border-border py-12" role="contentinfo">
            @include('partials.guest.footer')
        </footer>
    </div>
    @include('cookie-consent::index')
<deepl-input-controller translate="no"></deepl-input-controller>
</body>
</html>