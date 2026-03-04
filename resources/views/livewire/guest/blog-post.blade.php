<div>
    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-primary transition-colors font-mono mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m12 19-7-7 7-7"></path>
            <path d="M19 12H5"></path>
        </svg>
        {{ __('guest.blog.back_to_blog') }}
    </a>

    @if($article)
        <article>
            <header class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-foreground font-mono">
                    <span class="text-primary">#</span> {{ $article->title }}
                </h1>
                <p class="mt-2 text-sm text-muted-foreground font-mono flex flex-wrap items-center gap-x-1 gap-y-1">
                    <time datetime="{{ $article->date->toIso8601String() }}">{{ $article->date->format('F j, Y') }}</time>
                    <span aria-hidden="true"> · </span>
                    <span>{{ __('guest.blog.min_read', ['minutes' => $article->readingTimeMinutes]) }}</span>
                    <span aria-hidden="true"> · </span>
                    <button
                        type="button"
                        data-copy-link
                        class="text-muted-foreground hover:text-primary transition-colors underline underline-offset-2 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 rounded"
                        title="{{ __('guest.blog.copy_link') }}"
                    >
                        {{ __('guest.blog.copy_link') }}
                    </button>
                    <span data-copy-feedback class="hidden text-primary font-medium" aria-live="polite">{{ __('guest.blog.copied') }}</span>
                </p>
                @if($article->description)
                    <p class="text-muted-foreground mt-3">
                        {{ $article->description }}
                    </p>
                @endif
            </header>

            @if($article->hasImage)
                <figure class="mb-8 rounded-lg overflow-hidden bg-muted">
                    <img
                        src="{{ route('blog.image', $article->slug) }}"
                        alt=""
                        class="w-full aspect-video object-cover"
                    />
                </figure>
            @endif

            @if(count($article->headings) > 0)
                <nav aria-label="{{ __('guest.blog.toc_aria') }}" class="mb-8 p-4 rounded-lg bg-muted/50 border border-border">
                    <p class="text-sm font-medium text-foreground font-mono mb-2">{{ __('guest.blog.toc_heading') }}</p>
                    <ul class="space-y-1.5 text-sm font-mono text-muted-foreground">
                        @foreach($article->headings as $heading)
                            <li>
                                <a href="#{{ $heading->id }}" class="hover:text-primary transition-colors underline-offset-2 hover:underline">{{ $heading->text }}</a>
                            </li>
                        @endforeach
                    </ul>
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
