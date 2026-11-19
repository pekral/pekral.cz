<div>
    <x-page-header :eyebrow="__('guest.projects.eyebrow')" :back="route('home')" :back-label="__('guest.common.back_to_home')">
        {{ __('guest.projects.open_source_php_projects') }}
        <x-slot:lead>
            <p>
                {{ __('guest.projects.hero_description', [
                    'php_developer' => __('guest.projects.php_developer'),
                    'open_source_contributor' => __('guest.projects.open_source_contributor'),
                    'php_libraries' => __('guest.projects.php_libraries'),
                    'laravel_packages' => __('guest.projects.laravel_packages'),
                    'php_community' => __('guest.projects.php_community'),
                ]) }}
            </p>
            @if($projects->isNotEmpty())
                <p class="flex flex-wrap items-center gap-2 text-sm">
                    <span class="tag">{{ __('guest.projects.loaded_from_github') }}</span>
                    <span class="tag">{{ trans_choice('guest.projects.repositories_count', $projects->count(), ['count' => $projects->count()]) }}</span>
                    <span class="tag">★ {{ trans_choice('guest.projects.stars_count', $starCount, ['count' => $starCount]) }}</span>
                </p>
            @endif
        </x-slot:lead>
    </x-page-header>

    <section aria-label="{{ __('guest.projects.title') }}" class="mb-16">
        @if($projects->isEmpty())
            <p class="text-muted-foreground">
                {{ __('guest.projects.empty') }}
                <a href="{{ config('social.github') }}" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline font-mono">github.com/pekral</a>
            </p>
        @else
            <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3" role="list">
                @foreach($projects as $project)
                    <li class="reveal">
                        <x-repo-card :repository="$project" class="h-full" />
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <section class="reveal">
        <div class="project-card">
            <div class="flex items-start gap-4">
                <span class="project-card-icon shrink-0" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path>
                        <path d="M9 18c-4.51 2-5-2-7-2"></path>
                    </svg>
                </span>
                <div>
                    <p class="text-muted-foreground text-sm mb-4 leading-relaxed">
                        {!! __('guest.projects.see_more', [
                            'php_developer' => '<strong class="text-foreground">' . __('guest.projects.php_developer') . '</strong>',
                            'open_source' => '<strong class="text-foreground">' . __('guest.projects.open_source') . '</strong>',
                        ]) !!}
                    </p>
                    <a href="https://github.com/pekral?tab=repositories" target="_blank" rel="noopener noreferrer" class="btn btn-ghost btn-sm">
                        {{ __('guest.projects.view_all_open_source') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" x2="21" y1="14" y2="3"></line>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
