<div>
    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-primary transition-colors font-mono mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m12 19-7-7 7-7"></path>
            <path d="M19 12H5"></path>
        </svg>
        Back to blog
    </a>

    @if($article)
        <article>
            <header class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-foreground font-mono">
                    <span class="text-primary">#</span> {{ $article->title }}
                </h1>
                <p class="mt-2 text-sm text-muted-foreground font-mono">
                    <time datetime="{{ $article->date->toIso8601String() }}">{{ $article->date->format('F j, Y') }}</time>
                    <span aria-hidden="true"> · </span>
                    <span>{{ $article->readingTimeMinutes }} min read</span>
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

            <div class="blog-content">
                {!! $article->htmlContent !!}
            </div>
        </article>
    @endif
</div>
