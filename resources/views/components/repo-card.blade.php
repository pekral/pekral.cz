@props(['repository', 'withImage' => false])

@php
    $languageColors = [
        'PHP' => '#8892BF',
        'JavaScript' => '#F1E05A',
        'TypeScript' => '#3178C6',
        'Shell' => '#89E051',
        'Blade' => '#F7523F',
    ];
    $languageColor = $languageColors[$repository->language] ?? 'hsl(215 12% 62%)';
@endphp

<a
    href="{{ route('projects.show', $repository->name) }}"
    aria-label="{{ __('guest.projects.open_detail', ['name' => $repository->name]) }}"
    {{ $attributes->merge(['class' => 'project-card group flex flex-col gap-4 no-underline']) }}
    wire:navigate
>
    @if($withImage)
        <div class="repo-cover" aria-hidden="true">
            <img
                src="{{ route('projects.social-image', $repository->name) }}"
                alt=""
                width="640"
                height="320"
                loading="lazy"
                decoding="async"
                fetchpriority="low"
            >
        </div>
    @endif

    <div class="flex items-start justify-between gap-3">
        <h3 class="font-mono text-foreground font-semibold group-hover:text-primary transition-colors flex items-center gap-2 min-w-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground shrink-0" aria-hidden="true">
                <path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"></path>
            </svg>
            <span class="truncate">{{ $repository->name }}</span>
        </h3>
        <span class="tag shrink-0" title="{{ __('guest.projects.stars_label', ['count' => $repository->stars]) }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M11.48 3.5a.56.56 0 0 1 1.04 0l2.13 5.1 5.5.44a.56.56 0 0 1 .32.98l-4.2 3.6 1.29 5.37a.56.56 0 0 1-.84.61L12 16.7l-4.72 2.9a.56.56 0 0 1-.84-.61l1.28-5.37-4.2-3.6a.56.56 0 0 1 .33-.98l5.5-.45 2.13-5.1Z"></path>
            </svg>
            {{ $repository->stars }}
        </span>
    </div>

    <p class="text-sm text-muted-foreground leading-relaxed line-clamp-3 flex-1">
        {{ $repository->summary() }}
    </p>

    @if($repository->hasDistinctComposerDescription())
        <p class="text-xs text-muted-foreground/70 font-mono line-clamp-2">
            {{ $repository->composerDescription }}
        </p>
    @endif

    <div class="flex flex-wrap items-center gap-2 pt-1">
        <span class="tag">
            <span class="inline-block w-2 h-2 rounded-full" style="background: {{ $languageColor }}" aria-hidden="true"></span>
            {{ $repository->language }}
        </span>
        @if($repository->phpVersion !== '')
            <span class="tag" title="PHP {{ $repository->phpVersion }}">php ≥ {{ $repository->phpVersion }}</span>
        @endif
        @foreach($repository->topics as $topic)
            <span class="tag">#{{ $topic }}</span>
        @endforeach
    </div>
</a>
