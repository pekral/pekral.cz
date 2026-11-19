@props(['article', 'headingLevel' => 'h2'])

<a href="{{ route('blog.show', $article->slug) }}" {{ $attributes->merge(['class' => 'project-card group block no-underline']) }} wire:navigate>
    <div class="flex flex-col sm:flex-row sm:items-start gap-5">
        @if($article->hasImage)
            <div class="sm:w-40 shrink-0 aspect-video rounded-xl overflow-hidden bg-muted border border-border">
                <img
                    src="{{ route('blog.image', $article->slug) }}"
                    alt=""
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    loading="lazy"
                    width="320"
                    height="180"
                />
            </div>
        @endif
        <div class="min-w-0 flex-1">
            <p class="hud-label flex flex-wrap items-center gap-x-1.5 gap-y-1">
                <time datetime="{{ $article->date->toIso8601String() }}">{{ $article->date->format('F j, Y') }}</time>
                <span aria-hidden="true">·</span>
                <span>{{ __('guest.blog.min_read', ['minutes' => $article->readingTimeMinutes]) }}</span>
            </p>
            <{{ $headingLevel }} class="font-mono text-foreground group-hover:text-primary transition-colors font-semibold text-lg mt-2 leading-snug">
                {{ $article->title }}
            </{{ $headingLevel }}>
            @if($article->description)
                <p class="text-sm text-muted-foreground mt-2 line-clamp-2 leading-relaxed">
                    {{ $article->description }}
                </p>
            @endif
            <span class="inline-flex items-center gap-2 mt-4 text-sm text-primary font-mono">
                {{ __('guest.blog.read_article') }}
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1" aria-hidden="true">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </span>
        </div>
    </div>
</a>
