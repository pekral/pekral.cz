<div>
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-primary transition-colors font-mono mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m12 19-7-7 7-7"></path>
            <path d="M19 12H5"></path>
        </svg>
        {{ __('guest.common.back_to_home') }}
    </a>

    {{-- Hero Section --}}
    <section class="animate-fade-in mb-16">
        <x-terminal title="petr@dev:~/skills">
            <div class="terminal-line mb-4">
                <span class="terminal-prompt">$</span>
                <span class="terminal-command ml-2">cat skills.txt</span>
            </div>
            <div class="terminal-output ml-4 mt-2">
                <div class="space-y-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-foreground">
                        <span class="text-primary">#</span> {{ __('guest.skills.hero_title') }}
                    </h1>
                    <p class="text-muted-foreground leading-relaxed">
                        {!! __('guest.skills.hero_description', ['php_developer' => '<strong class="text-foreground">' . __('guest.skills.php_developer') . '</strong>', 'laravel_programmer' => '<strong class="text-foreground">' . __('guest.skills.laravel_programmer') . '</strong>', 'php_ecosystem' => '<strong class="text-foreground">' . __('guest.skills.php_ecosystem') . '</strong>', 'open_source' => '<strong class="text-foreground">' . __('guest.skills.open_source') . '</strong>']) !!}
                    </p>
                </div>
            </div>
        </x-terminal>
    </section>

    {{-- Languages Section --}}
    <section class="animate-fade-in-delay-1 mb-12">
        <h2 class="text-xl font-semibold text-foreground mb-6 font-mono">
            <span class="text-primary">#</span> {{ __('guest.skills.languages') }}
        </h2>
        <div class="flex flex-wrap gap-3">
            @foreach($skills['languages'] as $skill)
                <span class="skill-tag">
                    @if(isset($skill['logo']))
                        <img src="{{ $skill['logo'] }}" alt="{{ $skill['name'] }}" class="w-4 h-4 mr-2" loading="lazy">
                    @elseif(isset($skill['icon']))
                        <span class="mr-2">{{ $skill['icon'] }}</span>
                    @endif
                    {{ $skill['name'] }}
                </span>
            @endforeach
        </div>
    </section>

    {{-- Frameworks Section --}}
    <section class="animate-fade-in-delay-2 mb-12">
        <h2 class="text-xl font-semibold text-foreground mb-6 font-mono">
            <span class="text-primary">#</span> {{ __('guest.skills.frameworks') }}
        </h2>
        <div class="flex flex-wrap gap-3">
            @foreach($skills['frameworks'] as $skill)
                <span class="skill-tag">
                    @if(isset($skill['logo']))
                        <img src="{{ $skill['logo'] }}" alt="{{ $skill['name'] }}" class="w-4 h-4 mr-2" loading="lazy">
                    @elseif(isset($skill['icon']))
                        <span class="mr-2">{{ $skill['icon'] }}</span>
                    @endif
                    {{ $skill['name'] }}
                </span>
            @endforeach
        </div>
    </section>

    {{-- Tools Section --}}
    <section class="animate-fade-in-delay-2 mb-12">
        <h2 class="text-xl font-semibold text-foreground mb-6 font-mono">
            <span class="text-primary">#</span> {{ __('guest.skills.tools') }}
        </h2>
        <div class="flex flex-wrap gap-3">
            @foreach($skills['tools'] as $skill)
                <span class="skill-tag">
                    @if(isset($skill['logo']))
                        <img src="{{ $skill['logo'] }}" alt="{{ $skill['name'] }}" class="w-4 h-4 mr-2" loading="lazy">
                    @elseif(isset($skill['icon']))
                        <span class="mr-2">{{ $skill['icon'] }}</span>
                    @endif
                    {{ $skill['name'] }}
                </span>
            @endforeach
        </div>
    </section>

    {{-- Practices Section --}}
    <section class="animate-fade-in-delay-3">
        <h2 class="text-xl font-semibold text-foreground mb-6 font-mono">
            <span class="text-primary">#</span> {{ __('guest.skills.practices') }}
        </h2>
        <div class="flex flex-wrap gap-3">
            @foreach($skills['practices'] as $skill)
                <span class="skill-tag">
                    @if(isset($skill['logo']))
                        <img src="{{ $skill['logo'] }}" alt="{{ $skill['name'] }}" class="w-4 h-4 mr-2" loading="lazy">
                    @elseif(isset($skill['icon']))
                        <span class="mr-2">{{ $skill['icon'] }}</span>
                    @endif
                    {{ $skill['name'] }}
                </span>
            @endforeach
        </div>
    </section>
</div>
