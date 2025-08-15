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
        <main>
            <!-- START person section -->
            @include('partials.guest.person')
            <!-- END person section -->
            <!-- START about section -->
            @include('partials.guest.about')
            <!-- END about section -->
            <!-- START blog section -->
            @include('partials.guest.blog')
            <!-- END blog section -->
            <!-- START contact section -->
            @include('partials.guest.contact')
            <!-- END contact section -->
        </main>
        <footer class="bg-background border-t border-border py-12">
            @include('partials.guest.footer')
        </footer>
    </div>
</div>
<deepl-input-controller translate="no"></deepl-input-controller>
</body>
</html>