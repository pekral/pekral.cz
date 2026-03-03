<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use App\Actions\Blog\GetBlogArticleBySlugAction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class BlogPost extends Component
{

    public string $slug;

    public function mount(string $slug, GetBlogArticleBySlugAction $getBlogArticleBySlug): void
    {
        $this->slug = $slug;

        if ($getBlogArticleBySlug->execute($slug) === null) {
            abort(404);
        }
    }

    public function render(GetBlogArticleBySlugAction $getBlogArticleBySlug): View
    {
        $article = $getBlogArticleBySlug->execute($this->slug);

        return view('livewire.guest.blog-post', [
            'article' => $article,
        ]);
    }

}
