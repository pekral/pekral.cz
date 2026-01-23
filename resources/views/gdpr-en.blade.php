<x-layouts.guest.layout>
    <div class="container max-w-4xl mx-auto px-6 pt-24 pb-16">
        <section class="animate-fade-in">
            <x-terminal title="petr@portfolio:~$ cat privacy-policy.md">
                <div class="space-y-6">
                    {{-- Header --}}
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-foreground mb-2 font-mono">
                            <span class="text-primary">#</span> Privacy Policy (GDPR)
                        </h1>
                        <p class="text-muted-foreground text-sm">
                            Last updated: {{ date('F j, Y') }}
                        </p>
                    </div>

                    {{-- Data Controller --}}
                    <div class="pt-4 border-t border-border">
                        <div class="terminal-line mb-4">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">cat data-controller.txt</span>
                        </div>
                        <div class="terminal-output ml-4 mt-2">
                            <h2 class="text-lg font-semibold text-foreground mb-3 font-mono">
                                <span class="text-primary">##</span> 1. Data Controller
                            </h2>
                            <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                                The data controller is:
                            </p>
                            <div class="bg-secondary/50 rounded-lg p-4 border border-border text-sm">
                                <p class="text-foreground font-semibold">Petr Král</p>
                                <p class="text-muted-foreground"><span class="text-primary">ID:</span> 19326343</p>
                                <p class="text-muted-foreground"><span class="text-primary">Address:</span> Družstevní 709, 503 51 Chlumec nad Cidlinou, Czech Republic</p>
                                <p class="text-muted-foreground">Registered as a sole proprietor in the Trade Register</p>
                                <p class="text-muted-foreground">Non-VAT payer</p>
                                <p class="text-muted-foreground mt-2">
                                    <span class="text-primary">Email:</span> <x-obfuscated-email email="kral.petr.88@gmail.com" class="text-primary hover:underline" />
                                </p>
                                <p class="text-muted-foreground">
                                    <span class="text-primary">Phone:</span> <a href="tel:+420733382412" class="text-primary hover:underline">+420 733 382 412</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Personal Data We Process --}}
                    <div class="pt-4 border-t border-border">
                        <div class="terminal-line mb-4">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">cat personal-data.md</span>
                        </div>
                        <div class="terminal-output ml-4 mt-2">
                            <h2 class="text-lg font-semibold text-foreground mb-3 font-mono">
                                <span class="text-primary">##</span> 2. Personal Data We Process
                            </h2>
                            <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                                As part of our services, we may process the following personal data:
                            </p>
                            <ul class="text-sm text-muted-foreground space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Contact information:</strong> name, email address, phone number</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Technical data:</strong> IP address, browser type, operating system</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Traffic data:</strong> pages you visit, time spent on pages</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Cookies:</strong> technical cookies for website functionality, analytics cookies</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Purpose of Processing --}}
                    <div class="pt-4 border-t border-border">
                        <div class="terminal-line mb-4">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">cat processing-purpose.md</span>
                        </div>
                        <div class="terminal-output ml-4 mt-2">
                            <h2 class="text-lg font-semibold text-foreground mb-3 font-mono">
                                <span class="text-primary">##</span> 3. Purpose of Personal Data Processing
                            </h2>
                            <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                                We process your personal data for the following purposes:
                            </p>
                            <ul class="text-sm text-muted-foreground space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span>Providing our services and communicating with you</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span>Website traffic analysis using Google Analytics</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span>Improving the quality of our services</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span>Technical operation of the website</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Legal Basis --}}
                    <div class="pt-4 border-t border-border">
                        <div class="terminal-line mb-4">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">cat legal-basis.md</span>
                        </div>
                        <div class="terminal-output ml-4 mt-2">
                            <h2 class="text-lg font-semibold text-foreground mb-3 font-mono">
                                <span class="text-primary">##</span> 4. Legal Basis for Processing
                            </h2>
                            <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                                We process personal data based on:
                            </p>
                            <ul class="text-sm text-muted-foreground space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Consent:</strong> for analytics cookies and marketing purposes</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Legitimate interest:</strong> for technical cookies necessary for website operation</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Contract performance:</strong> for providing our services</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Google Analytics --}}
                    <div class="pt-4 border-t border-border">
                        <div class="terminal-line mb-4">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">cat google-analytics.md</span>
                        </div>
                        <div class="terminal-output ml-4 mt-2">
                            <h2 class="text-lg font-semibold text-foreground mb-3 font-mono">
                                <span class="text-primary">##</span> 5. Google Analytics
                            </h2>
                            <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                                We use Google Analytics 4 (Measurement ID: G-5Y5XCMQSTB), a web analytics service provided by Google LLC, on our website. Google Analytics uses cookies to analyze how you use our website.
                            </p>
                            <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                                Information about your use of this website (including your IP address) will be transmitted to and stored by Google on servers in the United States. Google may transfer this information to third parties where required by law or where such third parties process the information on Google's behalf.
                            </p>
                            <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                                Google Analytics cookies are only loaded after your consent through the cookie banner. You can withdraw your consent at any time or prevent cookies from being stored by adjusting your browser settings; however, please note that in this case, not all features of this website may be fully functional.
                            </p>
                            <p class="text-muted-foreground leading-relaxed text-sm">
                                For more information on how Google processes your data, visit:
                                <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline font-mono text-xs ml-1">
                                    policies.google.com/privacy
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline ml-0.5">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                        <polyline points="15 3 21 3 21 9"></polyline>
                                        <line x1="10" x2="21" y1="14" y2="3"></line>
                                    </svg>
                                </a>
                            </p>
                        </div>
                    </div>

                    {{-- Data Retention --}}
                    <div class="pt-4 border-t border-border">
                        <div class="terminal-line mb-4">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">cat data-retention.md</span>
                        </div>
                        <div class="terminal-output ml-4 mt-2">
                            <h2 class="text-lg font-semibold text-foreground mb-3 font-mono">
                                <span class="text-primary">##</span> 6. Data Retention Period
                            </h2>
                            <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                                We retain personal data only for as long as necessary to fulfill the purpose of processing:
                            </p>
                            <ul class="text-sm text-muted-foreground space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Contact information:</strong> for the duration of the business relationship</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Analytics data:</strong> maximum 26 months</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Technical cookies:</strong> according to your browser settings</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Your Rights --}}
                    <div class="pt-4 border-t border-border">
                        <div class="terminal-line mb-4">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">cat your-rights.md</span>
                        </div>
                        <div class="terminal-output ml-4 mt-2">
                            <h2 class="text-lg font-semibold text-foreground mb-3 font-mono">
                                <span class="text-primary">##</span> 7. Your Rights
                            </h2>
                            <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                                In connection with the processing of personal data, you have the following rights:
                            </p>
                            <ul class="text-sm text-muted-foreground space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Right to information:</strong> about the processing of your personal data</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Right of access:</strong> to your personal data</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Right to rectification:</strong> of inaccurate personal data</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Right to erasure:</strong> of personal data</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Right to restriction:</strong> of processing</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Right to data portability:</strong> of personal data</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Right to object:</strong> to processing of personal data</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary mt-0.5">→</span>
                                    <span><strong class="text-foreground">Right to withdraw consent:</strong> for personal data processing</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Contact --}}
                    <div class="pt-4 border-t border-border">
                        <div class="terminal-line mb-4">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">cat contact.txt</span>
                        </div>
                        <div class="terminal-output ml-4 mt-2">
                            <h2 class="text-lg font-semibold text-foreground mb-3 font-mono">
                                <span class="text-primary">##</span> 8. Contact
                            </h2>
                            <p class="text-muted-foreground leading-relaxed text-sm mb-3">
                                To exercise your rights or for any questions regarding the processing of personal data, please contact us:
                            </p>
                            <div class="bg-secondary/50 rounded-lg p-4 border border-border text-sm">
                                <p class="text-muted-foreground">
                                    <span class="text-primary">Email:</span> <x-obfuscated-email email="kral.petr.88@gmail.com" class="text-primary hover:underline" />
                                </p>
                                <p class="text-muted-foreground">
                                    <span class="text-primary">Phone:</span> <a href="tel:+420733382412" class="text-primary hover:underline">+420 733 382 412</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Policy Changes --}}
                    <div class="pt-4 border-t border-border">
                        <div class="terminal-line mb-4">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command ml-2">cat updates.md</span>
                        </div>
                        <div class="terminal-output ml-4 mt-2">
                            <h2 class="text-lg font-semibold text-foreground mb-3 font-mono">
                                <span class="text-primary">##</span> 9. Policy Changes
                            </h2>
                            <p class="text-muted-foreground leading-relaxed text-sm">
                                We may update this privacy policy from time to time. We will notify you of significant changes through our website or by email.
                            </p>
                        </div>
                    </div>

                    {{-- Back Link --}}
                    <div class="pt-6 border-t border-border">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-primary hover:underline font-mono">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m12 19-7-7 7-7"></path>
                                <path d="M19 12H5"></path>
                            </svg>
                            Back to homepage
                        </a>
                    </div>
                </div>
            </x-terminal>
        </section>
    </div>
</x-layouts.guest.layout>
