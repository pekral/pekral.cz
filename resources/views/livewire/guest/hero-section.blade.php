<section class="animate-fade-in">
    <x-terminal title="petr@portfolio:~$ whoami">
        <div class="space-y-6">
            <div>
                <div class="terminal-line mb-4">
                    <span class="terminal-prompt">$</span>
                    <span class="terminal-command ml-2">cat about.txt</span>
                </div>
                <div class="terminal-output ml-4 mt-2">
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-20 h-20 md:w-24 md:h-24 rounded-full border-2 border-primary overflow-hidden glow-border shrink-0">
                                <img src="{{ $profileImage }}" alt="{{ $name }} - PHP Developer & Laravel Programmer" class="w-full h-full object-cover" width="96" height="96">
                            </div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-foreground">
                                    {{ $name }} <span class="block text-lg md:text-xl text-primary font-mono mt-1">PHP Developer & Laravel Programmer</span>
                                </h1>
                                <p class="text-muted-foreground font-mono text-sm mt-2" role="doc-subtitle">
                                    Open Source Contributor <span class="text-primary">|</span> Backend Developer
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-muted-foreground">
                            <span class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="10" r="3"></circle>
                                    <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"></path>
                                </svg>
                                {{ $location }}
                            </span>
                        </div>

                        <p class="text-muted-foreground leading-relaxed max-w-2xl">
                            {{ $bio }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Laravel & PHP Development Section --}}
            <div class="pt-4 border-t border-border">
                <div class="terminal-line mb-4">
                    <span class="terminal-prompt">$</span>
                    <span class="terminal-command ml-2">cat expertise.md</span>
                </div>
                <div class="terminal-output ml-4 mt-2">
                    <h2 class="text-lg font-semibold text-foreground mb-3 font-mono">
                        <span class="text-primary">#</span> Laravel & PHP Development
                    </h2>
                    <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                        As a dedicated <strong class="text-foreground">PHP developer</strong>, I build robust backend systems using the <strong class="text-foreground">Laravel framework</strong>. My work as a <strong class="text-foreground">Laravel programmer</strong> focuses on creating maintainable, scalable applications with clean architecture.
                    </p>
                    <ul class="text-sm text-muted-foreground space-y-1.5">
                        <li class="flex items-center gap-2">
                            <span class="text-primary">→</span>
                            <span><strong class="text-foreground">Backend programming</strong> with PHP 8+ and modern practices</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">→</span>
                            <span><strong class="text-foreground">Laravel development</strong> for web applications and APIs</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">→</span>
                            <span>RESTful API design and microservices architecture</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">→</span>
                            <span>Database optimization with MySQL and PostgreSQL</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Open Source Section --}}
            <div class="pt-4 border-t border-border">
                <div class="terminal-line mb-4">
                    <span class="terminal-prompt">$</span>
                    <span class="terminal-command ml-2">cat open-source.md</span>
                </div>
                <div class="terminal-output ml-4 mt-2">
                    <h2 class="text-lg font-semibold text-foreground mb-3 font-mono">
                        <span class="text-primary">#</span> Open Source Contributions
                    </h2>
                    <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                        I'm an active <strong class="text-foreground">open source contributor</strong> in the PHP ecosystem. My <strong class="text-foreground">open source PHP projects</strong> focus on code quality, automated refactoring, and developer tooling.
                    </p>
                    <ul class="text-sm text-muted-foreground space-y-1.5">
                        <li class="flex items-center gap-2">
                            <span class="text-primary">→</span>
                            <span><strong class="text-foreground">Rector rules</strong> - PHP library for automated code refactoring</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">→</span>
                            <span><strong class="text-foreground">Architecture tools</strong> - Open source Laravel application helpers</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">→</span>
                            <span>Contributing to the PHP and Laravel community</span>
                        </li>
                    </ul>
                    <a href="https://github.com/pekral" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 mt-3 text-sm text-primary hover:underline font-mono">
                        View my open source PHP projects on GitHub
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" x2="21" y1="14" y2="3"></line>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Social Links --}}
            <div class="pt-4 border-t border-border">
                <div class="terminal-line mb-4">
                    <span class="terminal-prompt">$</span>
                    <span class="terminal-command ml-2">ls -la social/</span>
                </div>
                <div class="terminal-output ml-4 mt-4">
                    <livewire:guest.social-links />
                </div>
            </div>
        </div>
    </x-terminal>
</section>
