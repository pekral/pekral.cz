<div>
    <x-page-header :eyebrow="__('guest.about.eyebrow')" :back="route('home')" :back-label="__('guest.common.back_to_home')">
        {{ __('guest.about.hero_title') }}
        <x-slot:lead>
            <p>{!! __('guest.about.paragraph_1') !!}</p>
            <p>{!! __('guest.about.paragraph_2') !!}</p>
        </x-slot:lead>
    </x-page-header>

    <section class="mb-20" aria-labelledby="experience-heading">
        <hr class="gradient-band mb-14" aria-hidden="true">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-10">
            <h2 id="experience-heading" class="display-sm reveal">
                {{ __('guest.about.experience_heading') }}
            </h2>
            <span class="tag reveal">{{ trans_choice('guest.about.experience_count', count($experiences), ['count' => count($experiences)]) }}</span>
        </div>

        <ol class="career-timeline" role="list">
            @foreach($experiences as $exp)
                @php
                    preg_match('/\d{4}/', $exp['period'], $yearMatch);
                @endphp
                <li class="career-item reveal">
                    <div class="career-marker" aria-hidden="true">
                        <span class="career-year">{{ $yearMatch[0] ?? '' }}</span>
                    </div>
                    <article class="project-card career-card">
                        <p class="hud-label mb-3 flex flex-wrap items-center gap-x-2 gap-y-1">
                            <time>{{ $exp['period'] }}</time>
                            @if($exp['location'] !== '')
                                <span aria-hidden="true">·</span>
                                <span>{{ $exp['location'] }}</span>
                            @endif
                        </p>
                        <h3 class="font-mono text-foreground font-semibold text-lg leading-snug">{{ $exp['role'] }}</h3>
                        <p class="text-primary font-mono text-sm mt-1">
                            @if($exp['website'] !== '')
                                <a href="{{ $exp['website'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 hover:underline">
                                    <img src="{{ route('company.icon', parse_url($exp['website'], PHP_URL_HOST)) }}" alt="" width="20" height="20" loading="lazy" decoding="async" class="company-icon">
                                    {{ $exp['company'] }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                        <polyline points="15 3 21 3 21 9"></polyline>
                                        <line x1="10" x2="21" y1="14" y2="3"></line>
                                    </svg>
                                </a>
                            @else
                                {{ $exp['company'] }}
                            @endif
                        </p>
                        <p class="career-about">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 mt-0.5 text-instrument" aria-hidden="true">
                                <rect width="16" height="20" x="4" y="2" rx="2"></rect>
                                <path d="M9 22v-4h6v4"></path>
                                <path d="M8 6h.01"></path>
                                <path d="M16 6h.01"></path>
                                <path d="M12 6h.01"></path>
                                <path d="M12 10h.01"></path>
                                <path d="M12 14h.01"></path>
                                <path d="M16 10h.01"></path>
                                <path d="M16 14h.01"></path>
                                <path d="M8 10h.01"></path>
                                <path d="M8 14h.01"></path>
                            </svg>
                            <span><x-linked-text :text="$exp['about']" :links="$companyLinks" /></span>
                        </p>
                        <p class="text-sm text-muted-foreground leading-relaxed mt-3"><x-linked-text :text="$exp['description']" :links="$companyLinks" /></p>
                    </article>
                </li>
            @endforeach
        </ol>
    </section>

    <section class="mb-20" aria-labelledby="focus-heading">
        <h2 id="focus-heading" class="display-sm mb-8 reveal">
            {{ __('guest.about.focus_heading') }}
        </h2>

        <ul class="grid gap-4 sm:grid-cols-2" role="list">
            @foreach($focus as $item)
                <li class="project-card project-card-lift flex items-start gap-3 reveal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary shrink-0 mt-0.5" aria-hidden="true">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <p class="text-muted-foreground text-sm leading-relaxed">{{ $item }}</p>
                </li>
            @endforeach
        </ul>
    </section>

    <section aria-labelledby="connect-heading">
        <h2 id="connect-heading" class="display-sm mb-8 reveal">
            {{ __('guest.about.connect_heading') }}
        </h2>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="project-card project-card-lift reveal">
                <div class="flex items-start gap-4">
                    <span class="project-card-icon shrink-0" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                            <rect width="4" height="12" x="2" y="9"></rect>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg>
                    </span>
                    <div>
                        <p class="text-muted-foreground text-sm mb-4 leading-relaxed">{{ __('guest.about.connect_linkedin') }}</p>
                        <a href="{{ config('social.linkedin') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm text-primary hover:underline font-mono">
                            cz.linkedin.com/in/petr-kral-88-php
                        </a>
                    </div>
                </div>
            </div>

            <div class="project-card project-card-lift reveal">
                <div class="flex items-start gap-4">
                    <span class="project-card-icon shrink-0" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path>
                            <path d="M9 18c-4.51 2-5-2-7-2"></path>
                        </svg>
                    </span>
                    <div>
                        <p class="text-muted-foreground text-sm mb-4 leading-relaxed">{{ __('guest.about.connect_github') }}</p>
                        <a href="{{ config('social.github') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm text-primary hover:underline font-mono">
                            github.com/pekral
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
