<nav class="fixed top-0 left-0 right-0 z-50 bg-background/80 backdrop-blur-md border-b border-border" role="navigation" aria-label="Main navigation">
    <div class="container max-w-4xl mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-foreground hover:text-primary transition-colors">
                <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m18 16 4-4-4-4"></path>
                    <path d="m6 8-4 4 4 4"></path>
                    <path d="m14.5 4-5 16"></path>
                </svg>
                <span class="font-mono font-semibold">pekral</span>
            </a>

            <div class="flex items-center gap-6">
                @foreach($links as $link)
                    <a href="{{ $link['route'] }}" class="text-sm text-muted-foreground hover:text-primary transition-colors font-mono link-underline">
                        {{ $link['name'] }}
                    </a>
                @endforeach
                <x-obfuscated-email
                    email="kral.petr.88@gmail.com"
                    class="text-sm px-4 py-2 bg-primary text-primary-foreground rounded-md font-mono hover:bg-primary/90 transition-colors"
                >contact</x-obfuscated-email>
            </div>
        </div>
    </div>
</nav>
