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
        <x-terminal title="petr@dev:~/about">
            <div class="terminal-line mb-4">
                <span class="terminal-prompt">$</span>
                <span class="terminal-command ml-2">cat about.txt</span>
            </div>
            <div class="terminal-output ml-4 mt-2">
                <div class="space-y-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-foreground">
                        <span class="text-primary">#</span> About
                    </h1>
                    <p class="text-muted-foreground leading-relaxed">
                        I'm a Senior PHP Developer based in Chlumec nad Cidlinou, Czech Republic. I've been coding for over <span class="text-primary font-semibold">20 years</span>, working on everything from startups to large-scale platforms.
                    </p>
                    <p class="text-muted-foreground leading-relaxed">
                        My experience includes <span class="text-primary font-semibold">e-commerce platforms</span>, email marketing systems, and custom web applications. Currently self-employed, specializing in <span class="text-primary font-semibold">Laravel</span>, API development, and scalable backend solutions.
                    </p>
                </div>
            </div>
        </x-terminal>
    </section>

    {{-- Experience Section --}}
    <section class="animate-fade-in-delay-1 mb-16">
        <h2 class="text-xl font-semibold text-foreground mb-8 font-mono flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                <rect width="20" height="14" x="2" y="7" rx="2" ry="2"></rect>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
            <span><span class="text-primary">#</span> Experience</span>
        </h2>

        <div class="relative">
            {{-- Timeline line --}}
            <div class="absolute left-4 top-2 bottom-2 w-px bg-border"></div>

            <div class="space-y-6">
                @foreach($experiences as $exp)
                    <div class="relative pl-12">
                        {{-- Timeline dot --}}
                        <div class="absolute left-2.5 top-2 w-3 h-3 rounded-full bg-primary border-2 border-background"></div>

                        <div class="project-card">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-2 mb-2">
                                <div>
                                    <h3 class="font-mono text-foreground font-semibold">
                                        {{ $exp['role'] }}
                                    </h3>
                                    <p class="text-primary text-sm font-mono">
                                        {{ $exp['company'] }}
                                    </p>
                                </div>
                                <span class="text-xs text-muted-foreground font-mono whitespace-nowrap">
                                    {{ $exp['period'] }}
                                </span>
                            </div>
                            <p class="text-sm text-muted-foreground">
                                {{ $exp['description'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Focus Section --}}
    <section class="animate-fade-in-delay-2 mb-16">
        <h2 class="text-xl font-semibold text-foreground mb-6 font-mono">
            <span class="text-primary">#</span> What I Focus On
        </h2>

        <div class="grid gap-4">
            @foreach($focus as $item)
                <div class="flex items-start gap-3 p-4 rounded-lg bg-card border border-border">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary shrink-0 mt-0.5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <p class="text-muted-foreground text-sm">{{ $item }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Connect Section --}}
    <section class="animate-fade-in-delay-3">
        <h2 class="text-xl font-semibold text-foreground mb-6 font-mono">
            <span class="text-primary">#</span> Connect
        </h2>

        <div class="grid gap-4">
            <div class="project-card">
                <div class="flex items-start gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary shrink-0">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                        <rect width="4" height="12" x="2" y="9"></rect>
                        <circle cx="4" cy="4" r="2"></circle>
                    </svg>
                    <div>
                        <p class="text-muted-foreground text-sm mb-4">
                            Connect with me on LinkedIn. I have 400+ followers and 320+ connections in the tech industry. Let's network!
                        </p>
                        <a href="https://www.linkedin.com/in/petr-kr%C3%A1l-60223752/"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 text-sm text-primary hover:underline font-mono">
                            linkedin.com/in/petr-král
                        </a>
                    </div>
                </div>
            </div>

            <div class="project-card">
                <div class="flex items-start gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary shrink-0">
                        <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path>
                        <path d="M9 18c-4.51 2-5-2-7-2"></path>
                    </svg>
                    <div>
                        <p class="text-muted-foreground text-sm mb-4">
                            Check out my open-source contributions and personal projects on GitHub.
                        </p>
                        <a href="https://github.com/pekral"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 text-sm text-primary hover:underline font-mono">
                            github.com/pekral
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
