<section aria-labelledby="work-heading" class="pt-4">
    <hr class="gradient-band mb-20" aria-hidden="true">

    <x-section-heading :eyebrow="__('guest.work.eyebrow')" id="work-heading" :text="__('guest.work.intro')">
        {{ __('guest.work.heading') }}
    </x-section-heading>

    <div class="mt-10 grid gap-5 md:grid-cols-3">
        <article class="project-card project-card-lift reveal flex flex-col gap-4">
            <span class="project-card-icon project-card-icon-lg mx-auto" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m18 16 4-4-4-4"></path>
                    <path d="m6 8-4 4 4 4"></path>
                    <path d="m14.5 4-5 16"></path>
                </svg>
            </span>
            <h3 class="font-mono text-foreground font-semibold text-lg">{{ __('guest.hero.laravel_php_heading') }}</h3>
            <p class="text-sm text-muted-foreground leading-relaxed">{!! __('guest.hero.laravel_php_intro') !!}</p>
            <ul class="text-sm text-muted-foreground space-y-2 mt-auto">
                @foreach(['backend_programming', 'laravel_development', 'rest_api', 'database_optimization'] as $item)
                    <li class="flex items-start gap-2">
                        <span class="text-primary shrink-0" aria-hidden="true">→</span>
                        <span>{{ __('guest.hero.' . $item) }}</span>
                    </li>
                @endforeach
            </ul>
        </article>

        <article class="project-card project-card-lift reveal flex flex-col gap-4 md:-translate-y-3">
            <span class="project-card-icon project-card-icon-lg mx-auto" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 8V4H8"></path>
                    <rect width="16" height="12" x="4" y="8" rx="2"></rect>
                    <path d="M2 14h2"></path>
                    <path d="M20 14h2"></path>
                    <path d="M15 13v2"></path>
                    <path d="M9 13v2"></path>
                </svg>
            </span>
            <h3 class="font-mono text-foreground font-semibold text-lg">{{ __('guest.work.ai_heading') }}</h3>
            <p class="text-sm text-muted-foreground leading-relaxed">{!! __('guest.work.ai_intro') !!}</p>
            <ul class="text-sm text-muted-foreground space-y-2 mt-auto">
                @foreach(['ai_tools', 'ai_rules', 'ai_review'] as $item)
                    <li class="flex items-start gap-2">
                        <span class="text-primary shrink-0" aria-hidden="true">→</span>
                        <span>{{ __('guest.work.' . $item) }}</span>
                    </li>
                @endforeach
            </ul>
        </article>

        <article class="project-card project-card-lift reveal flex flex-col gap-4">
            <span class="project-card-icon project-card-icon-lg mx-auto" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="6" x2="6" y1="3" y2="15"></line>
                    <circle cx="18" cy="6" r="3"></circle>
                    <circle cx="6" cy="18" r="3"></circle>
                    <path d="M18 9a9 9 0 0 1-9 9"></path>
                </svg>
            </span>
            <h3 class="font-mono text-foreground font-semibold text-lg">{{ __('guest.hero.open_source_heading') }}</h3>
            <p class="text-sm text-muted-foreground leading-relaxed">{!! __('guest.hero.open_source_intro') !!}</p>
            <ul class="text-sm text-muted-foreground space-y-2 mt-auto">
                @foreach(['rector_rules', 'architecture_tools', 'contributing'] as $item)
                    <li class="flex items-start gap-2">
                        <span class="text-primary shrink-0" aria-hidden="true">→</span>
                        <span>{{ __('guest.hero.' . $item) }}</span>
                    </li>
                @endforeach
            </ul>
            <a href="{{ config('social.github') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm text-primary hover:underline font-mono">
                {{ __('guest.hero.view_projects_github') }}
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" x2="21" y1="14" y2="3"></line>
                </svg>
            </a>
        </article>
    </div>
</section>
