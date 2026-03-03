<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use App\Actions\Blog\GetPaginatedBlogArticlesAction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class BlogIndex extends Component
{

    public function render(GetPaginatedBlogArticlesAction $getPaginatedBlogArticles): View
    {
        return view('livewire.guest.blog-index', [
            'articles' => $getPaginatedBlogArticles->execute(),
        ]);
    }

}
