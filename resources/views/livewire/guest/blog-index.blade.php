<div>
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-primary transition-colors font-mono mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m12 19-7-7 7-7"></path>
            <path d="M19 12H5"></path>
        </svg>
        Back to home
    </a>

    <section class="mb-12">
        <h1 class="text-2xl md:text-3xl font-bold text-foreground font-mono">
            <span class="text-primary">#</span> Blog
        </h1>
        <p class="text-muted-foreground mt-2">
            Articles and notes in English.
        </p>
    </section>

    @if($articles->isEmpty())
        <p class="text-muted-foreground">No articles yet.</p>
    @else
        <ul class="space-y-6">
            @foreach($articles as $article)
                <li>
                    <a href="{{ route('blog.show', $article->slug) }}" class="project-card group block">
                        <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                            @if($article->hasImage)
                                <div class="sm:w-32 shrink-0 aspect-video rounded-lg overflow-hidden bg-muted">
                                    <img
                                        src="{{ route('blog.image', $article->slug) }}"
                                        alt=""
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                                    />
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <h2 class="font-mono text-foreground group-hover:text-primary transition-colors font-semibold">
                                    {{ $article->title }}
                                </h2>
                                <p class="mt-1 text-xs text-muted-foreground font-mono">
                                    <time datetime="{{ $article->date->toIso8601String() }}">{{ $article->date->format('F j, Y') }}</time>
                                    <span aria-hidden="true"> · </span>
                                    <span>{{ $article->readingTimeMinutes }} min read</span>
                                </p>
                                @if($article->description)
                                    <p class="text-sm text-muted-foreground mt-2 line-clamp-2">
                                        {{ $article->description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
