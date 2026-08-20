<x-layouts.guest.layout>
    <div class="container max-w-4xl mx-auto px-6 pt-24 pb-16">
        <section class="animate-fade-in">
            <x-terminal title="petr@portfolio:~$ cd {{ request()->path() }}">
                <div class="space-y-6">
                    <div class="terminal-line mb-4">
                        <span class="terminal-prompt">$</span>
                        <span class="terminal-command ml-2">cat {{ request()->path() }}</span>
                    </div>
                    <div class="terminal-output ml-4 mt-2 space-y-4">
                        <h1 class="text-2xl md:text-3xl font-bold text-foreground">
                            404 <span class="block text-lg md:text-xl text-primary font-mono mt-1">{{ __('errors.404.heading') }}</span>
                        </h1>
                        <p class="text-muted-foreground leading-relaxed max-w-2xl">
                            {{ __('errors.404.message') }}
                        </p>
                        <nav class="flex flex-wrap gap-4 pt-2" aria-label="{{ __('errors.404.nav_label') }}">
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-primary hover:underline font-mono">
                                {{ __('errors.404.home') }}
                            </a>
                            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm text-primary hover:underline font-mono">
                                {{ __('errors.404.blog') }}
                            </a>
                            <a href="{{ route('projects') }}" class="inline-flex items-center gap-2 text-sm text-primary hover:underline font-mono">
                                {{ __('errors.404.projects') }}
                            </a>
                        </nav>
                    </div>
                </div>
            </x-terminal>
        </section>
    </div>
</x-layouts.guest.layout>
