<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use App\Services\BlogService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class BlogLatestSection extends Component
{

    public function render(BlogService $blogService): View
    {
        $articles = $blogService->getAll()->take(3);

        return view('livewire.guest.blog-latest-section', [
            'articles' => $articles,
        ]);
    }

}
