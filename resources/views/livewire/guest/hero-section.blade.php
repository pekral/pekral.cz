<section class="relative overflow-hidden pt-36 pb-16 md:pt-44 md:pb-24" aria-labelledby="hero-heading">
    <div class="aurora" aria-hidden="true"></div>

    <div class="container max-w-5xl mx-auto px-6 grid gap-14 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
        <div class="animate-fade-in-up">
            <p class="eyebrow">
                <span class="status-dot text-functional-green" aria-hidden="true"></span>
                {{ __('guest.hero.availability') }}
            </p>

            <p class="hud-label mt-6 flex flex-wrap items-center gap-x-2 gap-y-1">
                <span class="text-foreground">{{ $name }}</span>
                <span aria-hidden="true">·</span>
                <span>{{ $role }}</span>
            </p>

            <h1 id="hero-heading" class="display mt-4">
                {{ __('guest.hero.headline_lead') }}
                <em>{{ __('guest.hero.headline_accent') }}</em>
            </h1>

            <p class="mt-7 text-base md:text-lg text-muted-foreground leading-relaxed max-w-xl">
                {{ $bio }}
            </p>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="#contact" class="btn btn-primary">
                    {{ __('guest.hero.cta_contact') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
                <a href="{{ route('projects') }}" class="btn btn-ghost" wire:navigate>
                    {{ __('guest.hero.cta_projects') }}
                </a>
            </div>

            <dl class="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-3">
                @foreach(['years', 'ecomail', 'stack'] as $fact)
                    <div class="stat">
                        <dt class="stat-label order-2">{{ __('guest.hero.facts.' . $fact . '.label') }}</dt>
                        <dd class="stat-value">{{ __('guest.hero.facts.' . $fact . '.value') }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div class="animate-fade-in-delay-2 lg:pl-4">
            <x-terminal title="petr@portfolio:~$ whoami">
                <div class="space-y-6">
                    <div>
                        <div class="terminal-line mb-4">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">cat about.txt</span>
                        </div>
                        <div class="terminal-output ml-1 flex items-center gap-4">
                            <div class="hero-halo shrink-0">
                                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full border-2 border-primary overflow-hidden glow-border">
                                    <img src="{{ $profileImage }}" alt="{{ __('guest.hero.img_alt', ['name' => $name]) }}" class="w-full h-full object-cover" width="80" height="80" fetchpriority="high">
                                </div>
                            </div>
                            <div class="min-w-0">
                                <p class="text-foreground font-semibold text-base md:text-lg leading-tight">{{ $name }}</p>
                                <p class="text-primary text-sm glow-text mt-1">{{ $role }}</p>
                                <p class="hud-label mt-2 flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="10" r="3"></circle>
                                        <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"></path>
                                    </svg>
                                    {{ $location }}
                                </p>
                                <p class="hud-label mt-1">{{ __('guest.hero.subtitle') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-border">
                        <div class="terminal-line mb-3">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">{{ __('guest.hero.terminal.command') }}</span>
                        </div>
                        <ol class="terminal-output ml-1 space-y-2" aria-label="{{ __('guest.work.ai_heading') }}">
                            @foreach(__('guest.hero.terminal.steps') as $step)
                                <li class="terminal-step">
                                    <span class="terminal-step-mark" aria-hidden="true">✓</span>
                                    <span>{{ $step }}</span>
                                </li>
                            @endforeach
                            <li class="terminal-step terminal-step-pending">
                                <span class="terminal-step-mark" aria-hidden="true"><span class="status-dot"></span></span>
                                <span class="text-primary">{{ __('guest.hero.terminal.pending') }}</span>
                                <span class="terminal-cursor" aria-hidden="true"></span>
                            </li>
                        </ol>
                    </div>

                    <div class="pt-4 border-t border-border">
                        <div class="terminal-line mb-3">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">ls -la social/</span>
                        </div>
                        <div class="terminal-output ml-1">
                            <livewire:guest.social-links />
                        </div>
                    </div>
                </div>
            </x-terminal>
        </div>
    </div>
</section>
