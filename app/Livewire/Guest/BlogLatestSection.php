<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use App\Actions\Blog\GetAllBlogArticlesAction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class BlogLatestSection extends Component
{

    public function render(GetAllBlogArticlesAction $getAllBlogArticles): View
    {
        $articles = $getAllBlogArticles->execute()->take(3);

        return view('livewire.guest.blog-latest-section', [
            'articles' => $articles,
        ]);
    }

}
