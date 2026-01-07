<section id="projects" class="animate-fade-in-delay-3">
    <h2 class="text-xl font-semibold text-foreground mb-6 font-mono">
        <span class="text-primary">#</span> Projects
    </h2>

    <div class="grid gap-4">
        @foreach($projects as $project)
            <a href="{{ $project['url'] }}"
               target="_blank"
               rel="noopener noreferrer"
               class="project-card group block">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-mono text-foreground group-hover:text-primary transition-colors flex items-center gap-2">
                            {{ $project['name'] }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" x2="21" y1="14" y2="3"></line>
                            </svg>
                        </h3>
                        <p class="text-sm text-muted-foreground mt-1 line-clamp-2">
                            {{ $project['description'] }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3 text-xs text-muted-foreground shrink-0">
                        <span class="px-2 py-0.5 rounded bg-secondary font-mono">
                            {{ $project['language'] }}
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <a href="https://github.com/pekral?tab=repositories"
       target="_blank"
       rel="noopener noreferrer"
       class="inline-flex items-center gap-2 mt-6 text-sm text-muted-foreground hover:text-primary transition-colors font-mono link-underline">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="6" x2="6" y1="3" y2="15"></line>
            <circle cx="18" cy="6" r="3"></circle>
            <circle cx="6" cy="18" r="3"></circle>
            <path d="M18 9a9 9 0 0 1-9 9"></path>
        </svg>
        View all repositories
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
            <polyline points="15 3 21 3 21 9"></polyline>
            <line x1="10" x2="21" y1="14" y2="3"></line>
        </svg>
    </a>
</section>
