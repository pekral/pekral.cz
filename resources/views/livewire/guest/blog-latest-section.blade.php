@if($articles->isNotEmpty())
    <section aria-labelledby="latest-from-blog-heading">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <x-section-heading :eyebrow="__('guest.blog.eyebrow')" id="latest-from-blog-heading" :text="__('guest.blog.subtitle')">
                {{ __('guest.blog.latest_from_blog') }}
            </x-section-heading>
            <a href="{{ route('blog.index') }}" class="btn btn-ghost btn-sm reveal" wire:navigate>
                {{ __('guest.blog.view_all_articles') }}
            </a>
        </div>

        <ul class="mt-10 space-y-4" role="list">
            @foreach($articles as $article)
                <li class="reveal">
                    <x-article-row :article="$article" heading-level="h3" />
                </li>
            @endforeach
        </ul>
    </section>
@endif
