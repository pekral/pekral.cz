<footer class="border-t border-border py-14 mt-8" role="contentinfo">
    <div class="container max-w-5xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-foreground hover:text-primary transition-colors mb-4" wire:navigate>
                    <svg class="w-5 h-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m18 16 4-4-4-4"></path>
                        <path d="m6 8-4 4 4 4"></path>
                        <path d="m14.5 4-5 16"></path>
                    </svg>
                    <span class="font-mono font-semibold tracking-tight">{{ __('guest.footer.author_name') }}</span>
                </a>
                <p class="text-sm text-muted-foreground leading-relaxed">
                    {!! __('guest.footer.bio') !!}
                </p>
            </div>

            <div>
                <h2 class="hud-label text-foreground mb-4">
                    <span class="text-primary">#</span> {{ __('guest.footer.nav_heading') }}
                </h2>
                <nav aria-label="{{ __('guest.nav.footer_label') }}">
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-muted-foreground hover:text-primary transition-colors" wire:navigate>{{ __('guest.nav.home') }}</a></li>
                        <li><a href="{{ route('about') }}" class="text-muted-foreground hover:text-primary transition-colors" wire:navigate>{{ __('guest.nav.about_me') }}</a></li>
                        <li><a href="{{ route('skills') }}" class="text-muted-foreground hover:text-primary transition-colors" wire:navigate>{{ __('guest.nav.technical_skills') }}</a></li>
                        <li><a href="{{ route('projects') }}" class="text-muted-foreground hover:text-primary transition-colors" wire:navigate>{{ __('guest.nav.open_source_projects') }}</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-muted-foreground hover:text-primary transition-colors" wire:navigate>{{ __('guest.blog.title') }}</a></li>
                        <li><a href="{{ route('home') }}#contact" class="text-muted-foreground hover:text-primary transition-colors capitalize">{{ __('guest.nav.contact') }}</a></li>
                        <li><a href="{{ route('privacy-policy') }}" class="text-muted-foreground hover:text-primary transition-colors" wire:navigate>{{ __('guest.nav.privacy_policy') }}</a></li>
                    </ul>
                </nav>
            </div>

            <div>
                <h2 class="hud-label text-foreground mb-4">
                    <span class="text-primary">#</span> {{ __('guest.footer.connect') }}
                </h2>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ config('social.github') }}" target="_blank" rel="noopener noreferrer" class="text-muted-foreground hover:text-primary transition-colors inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path>
                                <path d="M9 18c-4.51 2-5-2-7-2"></path>
                            </svg>
                            {{ __('guest.footer.github') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ config('social.linkedin') }}" target="_blank" rel="noopener noreferrer" class="text-muted-foreground hover:text-primary transition-colors inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                <rect width="4" height="12" x="2" y="9"></rect>
                                <circle cx="4" cy="4" r="2"></circle>
                            </svg>
                            {{ __('guest.footer.linkedin') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ config('social.x') }}" target="_blank" rel="noopener noreferrer" class="text-muted-foreground hover:text-primary transition-colors inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                                <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                            </svg>
                            {{ __('guest.footer.x_twitter') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('feed') }}" class="text-muted-foreground hover:text-primary transition-colors inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M4 11a9 9 0 0 1 9 9"></path>
                                <path d="M4 4a16 16 0 0 1 16 16"></path>
                                <circle cx="5" cy="19" r="1"></circle>
                            </svg>
                            {{ __('guest.footer.rss') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('llms') }}" class="text-muted-foreground hover:text-primary transition-colors inline-flex items-center gap-2 font-mono">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 8V4H8"></path>
                                <rect width="16" height="12" x="4" y="8" rx="2"></rect>
                                <path d="M2 14h2"></path>
                                <path d="M20 14h2"></path>
                                <path d="M15 13v2"></path>
                                <path d="M9 13v2"></path>
                            </svg>
                            {{ __('guest.footer.llms') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-border pt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-sm text-muted-foreground">
            <p class="font-mono">{{ __('guest.footer.copyright', ['year' => now(config('app.timezone'))->year]) }}</p>
            <p class="text-xs">{{ __('guest.footer.built_with') }}</p>
        </div>
    </div>
</footer>
