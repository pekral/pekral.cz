@props(['eyebrow' => null, 'back' => null, 'backLabel' => null])

<header {{ $attributes->merge(['class' => 'animate-fade-in-up mb-14']) }}>
    @if($back)
        <a href="{{ $back }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-primary transition-colors font-mono mb-8" wire:navigate>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
            </svg>
            {{ $backLabel }}
        </a>
    @endif

    @if($eyebrow)
        <p class="eyebrow">{{ $eyebrow }}</p>
    @endif

    <h1 class="display mt-5">{{ $slot }}</h1>

    @isset($lead)
        <div class="mt-6 text-base md:text-lg text-muted-foreground leading-relaxed max-w-2xl space-y-4">
            {{ $lead }}
        </div>
    @endisset
</header>
