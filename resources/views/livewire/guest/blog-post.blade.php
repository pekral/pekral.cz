<div>
    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-primary transition-colors font-mono mb-8" wire:navigate>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="m12 19-7-7 7-7"></path>
            <path d="M19 12H5"></path>
        </svg>
        {{ __('guest.blog.back_to_blog') }}
    </a>

    @if($article)
        <article class="max-w-3xl">
            <header class="mb-10 animate-fade-in-up">
                <p class="hud-label flex flex-wrap items-center gap-x-1.5 gap-y-1">
                    <time datetime="{{ $article->date->toIso8601String() }}">{{ $article->date->format('F j, Y') }}</time>
                    <span aria-hidden="true">·</span>
                    <span>{{ __('guest.blog.min_read', ['minutes' => $article->readingTimeMinutes]) }}</span>
                    <span aria-hidden="true">·</span>
                    <button
                        type="button"
                        data-copy-link
                        class="text-muted-foreground hover:text-primary transition-colors underline underline-offset-2 rounded"
                        title="{{ __('guest.blog.copy_link') }}"
                    >
                        {{ __('guest.blog.copy_link') }}
                    </button>
                    <span data-copy-feedback class="hidden text-primary font-medium" aria-live="polite">{{ __('guest.blog.copied') }}</span>
                </p>
                <h1 class="display-sm mt-4">
                    {{ $article->title }}
                </h1>
                @if($article->description)
                    <p class="text-muted-foreground text-lg leading-relaxed mt-5">
                        {{ $article->description }}
                    </p>
                @endif
            </header>

            @if($article->hasImage)
                <figure class="mb-10 rounded-2xl overflow-hidden bg-muted border border-border animate-fade-in-delay-1">
                    <img
                        src="{{ route('blog.image', $article->slug) }}"
                        alt=""
                        class="w-full aspect-video object-cover"
                        width="1280"
                        height="720"
                        fetchpriority="high"
                    />
                </figure>
            @endif

            @if(count($article->headings) > 0)
                <nav aria-label="{{ __('guest.blog.toc_aria') }}" class="mb-10 project-card p-5">
                    <p class="hud-label text-foreground mb-3"><span class="text-primary">#</span> {{ __('guest.blog.toc_heading') }}</p>
                    <ol class="space-y-1.5 text-sm font-mono text-muted-foreground list-decimal list-inside marker:text-primary/70">
                        @foreach($article->headings as $heading)
                            <li>
                                <a href="#{{ $heading->id }}" class="hover:text-primary transition-colors underline-offset-2 hover:underline">{{ $heading->text }}</a>
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif

            <div class="blog-content">
                {!! $article->htmlContent !!}
            </div>
        </article>
    @endif
</div>

@if($article)
    <script>
        (function () {
            const btn = document.querySelector('[data-copy-link]');
            const feedback = document.querySelector('[data-copy-feedback]');
            if (!btn || !feedback || !navigator.clipboard) return;
            btn.addEventListener('click', function () {
                navigator.clipboard.writeText(window.location.href).then(function () {
                    feedback.classList.remove('hidden');
                    btn.classList.add('hidden');
                    setTimeout(function () {
                        feedback.classList.add('hidden');
                        btn.classList.remove('hidden');
                    }, 1500);
                });
            });
        })();
    </script>
@endif
