<x-layouts.guest.layout>
    <div class="container max-w-5xl mx-auto px-6 pt-36 pb-24">
        <section class="relative animate-fade-in-up" aria-labelledby="not-found-heading">
            <div class="grid gap-10 lg:grid-cols-[auto_1fr] lg:items-center">
                <p class="glitch-404 select-none" aria-hidden="true">404</p>

                <div>
                    <p class="eyebrow">{{ __('errors.404.kicker') }}</p>
                    <h1 id="not-found-heading" class="display-sm mt-5">{{ __('errors.404.heading') }}</h1>
                    <p class="text-muted-foreground text-base md:text-lg leading-relaxed mt-4 max-w-xl">
                        {{ __('errors.404.message') }}
                    </p>

                    <div class="mt-8 max-w-xl">
                        <x-terminal title="petr@portfolio:~$">
                            <div class="terminal-line">
                                <span class="terminal-prompt">$</span>
                                <span class="terminal-command ml-2 break-all">{{ __('errors.404.command', ['path' => '/' . request()->path()]) }}</span>
                            </div>
                            <p class="terminal-output text-functional-red break-all">{{ __('errors.404.output', ['path' => '/' . request()->path()]) }}</p>
                            <div class="terminal-line mt-3">
                                <span class="terminal-prompt">$</span>
                                <span class="terminal-cursor" aria-hidden="true"></span>
                            </div>
                        </x-terminal>
                    </div>

                    <nav class="mt-8 flex flex-wrap gap-3" aria-label="{{ __('errors.404.nav_label') }}">
                        <a href="{{ route('home') }}" class="btn btn-primary">{{ __('errors.404.home') }}</a>
                        <a href="{{ route('blog.index') }}" class="btn btn-ghost">{{ __('errors.404.blog') }}</a>
                        <a href="{{ route('projects') }}" class="btn btn-ghost">{{ __('errors.404.projects') }}</a>
                    </nav>
                </div>
            </div>
        </section>
    </div>
</x-layouts.guest.layout>
