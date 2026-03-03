<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use App\Actions\Blog\GetAllBlogArticlesAction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class BlogIndex extends Component
{

    public function render(GetAllBlogArticlesAction $getAllBlogArticles): View
    {
        return view('livewire.guest.blog-index', [
            'articles' => $getAllBlogArticles->execute(),
        ]);
    }

}
