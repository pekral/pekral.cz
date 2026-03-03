@if($articles->isNotEmpty())
    <section class="mt-16" aria-labelledby="latest-from-blog-heading">
        <h2 id="latest-from-blog-heading" class="text-2xl md:text-3xl font-bold text-foreground font-mono">
            <span class="text-primary">#</span> Latest from the blog
        </h2>

        <ul class="mt-6 space-y-6">
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
                                <h3 class="font-mono text-foreground group-hover:text-primary transition-colors font-semibold">
                                    {{ $article->title }}
                                </h3>
                                <time datetime="{{ $article->date->toIso8601String() }}" class="text-xs text-muted-foreground font-mono block mt-1">
                                    {{ $article->date->format('F j, Y') }}
                                </time>
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

        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 mt-6 text-sm text-primary hover:underline font-mono">
            View all articles
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"></path>
                <path d="m12 5 7 7-7 7"></path>
            </svg>
        </a>
    </section>
@endif
