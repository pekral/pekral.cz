<section id="home" class="min-h-screen flex items-center justify-center px-6 pt-24 pb-12" aria-labelledby="person-heading">
    <div class="max-w-[850px] mx-auto w-full">
        <!-- Terminal Window with Orange Glow -->
        <div class="bg-[#1a1a1a] border border-[#2a2a2a] rounded-xl overflow-hidden shadow-[0_0_60px_-15px_rgba(249,115,22,0.4)]">
            <!-- Terminal Header -->
            <div class="bg-[#1e1e1e] px-4 py-3 flex items-center gap-2 border-b border-[#2a2a2a]">
                <div class="w-3 h-3 rounded-full bg-[#ff5f56]"></div>
                <div class="w-3 h-3 rounded-full bg-[#ffbd2e]"></div>
                <div class="w-3 h-3 rounded-full bg-[#27c93f]"></div>
                <span class="text-[#9ca3af] font-mono text-sm ml-2">petr@portfolio:~$ whoami</span>
            </div>

            <!-- Terminal Body -->
            <div class="p-6">
                <!-- About command -->
                <div class="font-mono text-sm text-[#9ca3af] mb-6">
                    <span class="text-[#f97316]">$</span> cat about.txt<span class="inline-block w-0.5 h-4 bg-[#f97316] ml-1 animate-pulse"></span>
                </div>

                <!-- Profile Info -->
                <div class="flex flex-row items-center gap-6 mb-6">
                    <img src="/assets/profile.jpg"
                         alt="Petr Král - PHP Developer"
                         class="w-28 h-28 sm:w-36 sm:h-36 rounded-full border-4 border-[#f97316] object-cover shrink-0"
                         loading="eager"
                         width="144"
                         height="144">
                    <div>
                        <h1 id="person-heading" class="font-mono text-2xl sm:text-3xl font-semibold text-white mb-1">
                            Petr Král
                        </h1>
                        <p class="font-mono text-base sm:text-lg text-[#f97316]">
                            PHP Developer
                        </p>
                    </div>
                </div>

                <!-- Info Row -->
                <div class="flex flex-wrap items-center gap-6 text-[#9ca3af] font-mono text-sm mb-6">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#6b7280]">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                            <line x1="16" x2="16" y1="2" y2="6"></line>
                            <line x1="8" x2="8" y1="2" y2="6"></line>
                            <line x1="3" x2="21" y1="10" y2="10"></line>
                        </svg>
                        <span>Ecomail</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#6b7280]">
                            <circle cx="12" cy="10" r="3"></circle>
                            <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"></path>
                        </svg>
                        <span>Chlumec nad Cidlinou, Czech Republic</span>
                    </div>
                </div>

                <!-- Bio -->
                <p class="font-mono text-sm text-[#9ca3af] leading-relaxed max-w-2xl">
                    Experienced PHP developer passionate about clean code, automated refactoring with Rector, and building scalable web applications. Contributing to the PHP ecosystem and sharing knowledge with the developer community.
                </p>

                <!-- Divider -->
                <div class="h-px bg-[#2a2a2a] my-5"></div>

                <!-- Social command -->
                <div class="font-mono text-sm text-[#9ca3af] mb-4">
                    <span class="text-[#f97316]">$</span> ls -la social/
                </div>

                <!-- Social Icons -->
                <div class="flex gap-4">
                    <a href="https://github.com/pekral" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-[#374151] flex items-center justify-center text-[#9ca3af] hover:bg-[#4b5563] hover:text-white transition-colors" aria-label="GitHub">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path>
                            <path d="M9 18c-4.51 2-5-2-7-2"></path>
                        </svg>
                    </a>
                    <a href="https://x.com/kral_petr_88" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-[#374151] flex items-center justify-center text-[#9ca3af] hover:bg-[#4b5563] hover:text-white transition-colors" aria-label="X (Twitter)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/in/petr-král-60223752/" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-[#374151] flex items-center justify-center text-[#9ca3af] hover:bg-[#4b5563] hover:text-white transition-colors" aria-label="LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                            <rect width="4" height="12" x="2" y="9"></rect>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg>
                    </a>
                    <a href="https://pekral.cz" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-[#374151] flex items-center justify-center text-[#9ca3af] hover:bg-[#4b5563] hover:text-white transition-colors" aria-label="Website">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                            <path d="M2 12h20"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
