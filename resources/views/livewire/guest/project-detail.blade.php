<div>
    <a href="{{ route('projects') }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-primary transition-colors font-mono mb-8" wire:navigate>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="m12 19-7-7 7-7"></path>
            <path d="M19 12H5"></path>
        </svg>
        {{ __('guest.projects.detail.back_to_projects') }}
    </a>

    <header class="animate-fade-in-up grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center mb-14">
        <div>
            <p class="eyebrow">{{ __('guest.projects.detail.eyebrow') }}</p>
            <h1 class="display mt-5 break-words">{{ $repository->name }}</h1>
            <p class="mt-6 text-base md:text-lg text-muted-foreground leading-relaxed max-w-2xl">{{ $repository->summary() }}</p>
            @if($repository->hasDistinctComposerDescription())
                <p class="mt-3 text-sm text-muted-foreground/80 font-mono max-w-2xl">{{ $repository->composerDescription }}</p>
            @endif

            <div class="mt-6 flex flex-wrap items-center gap-2">
                <span class="tag">★ {{ trans_choice('guest.projects.stars_count', $repository->stars, ['count' => $repository->stars]) }}</span>
                <span class="tag">{{ $repository->language }}</span>
                @if($repository->phpVersion !== '')
                    <span class="tag">php ≥ {{ $repository->phpVersion }}</span>
                @endif
                @foreach($repository->topics as $topic)
                    <span class="tag">#{{ $topic }}</span>
                @endforeach
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ $repository->url }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                    {{ __('guest.projects.detail.on_github') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" x2="21" y1="14" y2="3"></line>
                    </svg>
                </a>
                <a href="{{ $repository->url }}/issues" target="_blank" rel="noopener noreferrer" class="btn btn-ghost">
                    {{ __('guest.projects.detail.issues') }}
                </a>
            </div>
        </div>

        <div class="animate-fade-in-delay-2">
            <x-terminal title="petr@portfolio:~$ composer">
                @if($repository->composerName !== '')
                    <div class="terminal-line">
                        <span class="terminal-prompt">$</span>
                        <span class="terminal-command ml-2 break-all">composer require {{ $repository->composerName }}</span>
                    </div>
                    <p class="terminal-output">{{ __('guest.projects.detail.install_hint') }}</p>
                @else
                    <div class="terminal-line">
                        <span class="terminal-prompt">$</span>
                        <span class="terminal-command ml-2 break-all">git clone {{ $repository->url }}.git</span>
                    </div>
                    <p class="terminal-output">{{ __('guest.projects.detail.clone_hint') }}</p>
                @endif
                <div class="terminal-line mt-3">
                    <span class="terminal-prompt">$</span>
                    <span class="terminal-cursor" aria-hidden="true"></span>
                </div>
            </x-terminal>
        </div>
    </header>

    <section aria-labelledby="readme-heading" class="reveal">
        <div class="flex items-center gap-3 mb-6">
            <h2 id="readme-heading" class="font-mono text-lg font-semibold text-foreground"><span class="text-primary">#</span> README.md</h2>
            <span class="hud-label">{{ __('guest.projects.detail.readme_source') }}</span>
        </div>

        @if($readmeHtml !== null)
            <article class="project-card p-6 md:p-10">
                <div class="blog-content readme-content max-w-none">
                    {!! $readmeHtml !!}
                </div>
            </article>
        @else
            <p class="text-muted-foreground">
                {{ __('guest.projects.detail.readme_missing') }}
                <a href="{{ $repository->url }}" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline font-mono">GitHub</a>
            </p>
        @endif
    </section>
</div>
