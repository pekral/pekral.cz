<div>
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-primary transition-colors font-mono mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m12 19-7-7 7-7"></path>
            <path d="M19 12H5"></path>
        </svg>
        Back to home
    </a>

    {{-- Hero Section --}}
    <section class="animate-fade-in mb-16">
        <x-terminal title="petr@dev:~/projects">
            <div class="terminal-line mb-4">
                <span class="terminal-prompt">$</span>
                <span class="terminal-command ml-2">ls -la projects/</span>
            </div>
            <div class="terminal-output ml-4 mt-2">
                <div class="space-y-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-foreground">
                        <span class="text-primary">#</span> Open Source PHP Projects
                    </h1>
                    <p class="text-muted-foreground leading-relaxed">
                        As a <strong class="text-foreground">PHP developer</strong> and <strong class="text-foreground">open source contributor</strong>, I maintain several <strong class="text-foreground">PHP libraries</strong> and <strong class="text-foreground">Laravel packages</strong>. My projects focus on code quality, automated refactoring, and developer tooling for the <strong class="text-foreground">PHP programming</strong> community.
                    </p>
                </div>
            </div>
        </x-terminal>
    </section>

    {{-- Projects List --}}
    <section class="animate-fade-in-delay-1 mb-16">
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
                            @if($project['description'])
                                <p class="text-sm text-muted-foreground mt-1">
                                    {{ $project['description'] }}
                                </p>
                            @endif
                            @if($project['composerDescription'])
                                <p class="text-xs text-muted-foreground/70 mt-2 font-mono flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                    </svg>
                                    {{ $project['composerDescription'] }}
                                </p>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 text-xs text-muted-foreground shrink-0">
                            @if($project['phpVersion'])
                                <span class="px-2 py-0.5 rounded bg-[#4F5D95]/20 text-[#4F5D95] dark:bg-[#777BB3]/20 dark:text-[#AEB2D5] font-mono flex items-center gap-1.5" title="PHP {{ $project['phpVersion'] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="shrink-0">
                                        <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-1.5 4h2.25l-.375 2h1.5l-.75 4h-1.5l.375-2H10.5l-.375 2H8.625l.375-2H7.5l.375-2H9l.375-2zm4.125 0H17l-.375 2h1.5l-.75 4h-1.5l.375-2h-1.5l-.375 2h-1.5l.75-4h1.5l.375-2z"/>
                                    </svg>
                                    {{ $project['phpVersion'] }}
                                </span>
                            @endif
                            <span class="px-2 py-0.5 rounded bg-secondary font-mono">
                                {{ $project['language'] }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- GitHub Link --}}
    <section class="animate-fade-in-delay-2">
        <div class="project-card">
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary shrink-0">
                    <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path>
                    <path d="M9 18c-4.51 2-5-2-7-2"></path>
                </svg>
                <div>
                    <p class="text-muted-foreground text-sm mb-4">
                        Want to see more of my work as a <strong class="text-foreground">PHP developer</strong>? Explore all my <strong class="text-foreground">open source</strong> repositories on GitHub.
                    </p>
                    <a href="https://github.com/pekral?tab=repositories"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 text-sm text-primary hover:underline font-mono">
                        View all open source PHP projects
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
