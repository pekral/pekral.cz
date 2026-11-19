<section id="open-source" aria-labelledby="open-source-heading">
    <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
        <x-section-heading :eyebrow="__('guest.projects.loaded_from_github')" id="open-source-heading">
            {{ __('guest.projects.open_source_php_projects') }}
        </x-section-heading>

        @if($repositoryCount > 0)
            <div class="flex flex-wrap items-center gap-2 reveal">
                <span class="tag">{{ trans_choice('guest.projects.repositories_count', $repositoryCount, ['count' => $repositoryCount]) }}</span>
                <span class="tag">★ {{ trans_choice('guest.projects.stars_count', $starCount, ['count' => $starCount]) }}</span>
            </div>
        @endif
    </div>

    @if($repositories->isEmpty())
        <p class="mt-8 text-muted-foreground">
            {{ __('guest.projects.empty') }}
            <a href="{{ config('social.github') }}" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline font-mono">github.com/pekral</a>
        </p>
    @else
        <ul class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" role="list">
            @foreach($repositories as $repository)
                <li class="reveal">
                    <x-repo-card :repository="$repository" class="h-full" />
                </li>
            @endforeach
        </ul>
    @endif

    <div class="mt-8 flex flex-wrap gap-3 reveal">
        <a href="{{ route('projects') }}" class="btn btn-ghost" wire:navigate>
            {{ __('guest.projects.view_all_open_source') }}
        </a>
        <a href="https://github.com/pekral?tab=repositories" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-2 text-sm text-muted-foreground hover:text-primary transition-colors font-mono link-underline">
            {{ __('guest.projects.view_all_repositories') }}
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                <polyline points="15 3 21 3 21 9"></polyline>
                <line x1="10" x2="21" y1="14" y2="3"></line>
            </svg>
        </a>
    </div>
</section>
