<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use App\Services\BlogService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class BlogIndex extends Component
{

    public function render(BlogService $blogService): View
    {
        return view('livewire.guest.blog-index', [
            'articles' => $blogService->getAll(),
        ]);
    }

}
