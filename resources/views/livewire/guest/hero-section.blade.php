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
                                <img src="{{ $profileImage }}" alt="{{ $name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-foreground">
                                    {{ $name }}
                                </h1>
                                <p class="text-primary font-mono text-lg mt-1 glow-text">
                                    {{ $role }}
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
