<div>
<section class="relative overflow-hidden pt-36 pb-16 md:pt-44 md:pb-24" aria-labelledby="hero-heading">
    <div class="aurora" aria-hidden="true"></div>

    <div class="container max-w-5xl mx-auto px-6">
        <div class="animate-fade-in-up">
            <p class="hud-label flex flex-wrap items-center gap-x-2 gap-y-1">
                <span class="text-foreground">{{ __('guest.hero.first_name') }}</span>
                <span aria-hidden="true">·</span>
                <span>{{ $role }}</span>
            </p>

            <h1 id="hero-heading" class="display mt-4">
                {{ __('guest.hero.headline_lead') }}
                <em>{{ __('guest.hero.headline_accent') }}</em>
            </h1>

            <p class="mt-7 text-base md:text-lg text-muted-foreground leading-relaxed">
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
                        <dt class="stat-label order-2"><x-linked-text :text="__('guest.hero.facts.' . $fact . '.label')" :links="['ECOMAIL.CZ' => 'https://ecomail.cz']" /></dt>
                        <dd class="stat-value">{{ __('guest.hero.facts.' . $fact . '.value') }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

    </div>
</section>

<section class="container max-w-5xl mx-auto px-6 pb-4 reveal" aria-labelledby="about-txt-heading">
    <div class="project-card p-7 md:p-10">
        <div class="flex flex-col sm:flex-row sm:items-center gap-7">
            <div class="hero-halo shrink-0 self-start sm:self-center">
                <div class="w-24 h-24 md:w-28 md:h-28 rounded-full border-2 border-primary overflow-hidden glow-border">
                    <img src="{{ $profileImage }}" alt="{{ __('guest.hero.img_alt', ['name' => $name]) }}" class="w-full h-full object-cover" width="112" height="112" loading="lazy">
                </div>
            </div>
            <div class="min-w-0">
                <h2 id="about-txt-heading" class="text-foreground font-semibold text-2xl md:text-3xl leading-tight tracking-tight">{{ __('guest.hero.first_name') }}</h2>
                <p class="text-primary font-mono text-base glow-text mt-1">{{ $role }}</p>
                <p class="hud-label mt-3 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="10" r="3"></circle>
                        <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"></path>
                    </svg>
                    {{ $location }}
                </p>
                <p class="hud-label mt-1">{{ __('guest.hero.subtitle') }}</p>
                <div class="mt-5 flex flex-wrap items-center gap-4">
                    <a href="{{ route('about') }}" class="btn btn-ghost btn-sm" wire:navigate>
                        {{ __('guest.nav.about_me') }} →
                    </a>
                    <livewire:guest.social-links />
                </div>
            </div>
        </div>
    </div>
</section>
</div>
