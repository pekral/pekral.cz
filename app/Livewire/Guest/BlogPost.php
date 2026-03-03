<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use App\Services\BlogService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class BlogPost extends Component
{

    public string $slug;

    public function mount(string $slug, BlogService $blogService): void
    {
        $this->slug = $slug;

        if ($blogService->getBySlug($slug) === null) {
            abort(404);
        }
    }

    public function render(BlogService $blogService): View
    {
        $article = $blogService->getBySlug($this->slug);

        return view('livewire.guest.blog-post', [
            'article' => $article,
        ]);
    }

}
