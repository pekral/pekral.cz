<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Navigation extends Component
{

    public bool $menuOpen = false;

    /**
     * @return array<int, array{name: string, route: string, is_anchor: bool}>
     */
    public function getLinks(): array
    {
        return [
            [
                'is_anchor' => false,
                'name' => 'about',
                'route' => route('about'),
            ],
            [
                'is_anchor' => false,
                'name' => 'skills',
                'route' => route('skills'),
            ],
            [
                'is_anchor' => false,
                'name' => 'projects',
                'route' => route('projects'),
            ],
            [
                'is_anchor' => false,
                'name' => 'blog',
                'route' => route('blog.index'),
            ],
            [
                'is_anchor' => true,
                'name' => 'contact',
                'route' => route('home') . '#contact',
            ],
        ];
    }

    public function toggleMenu(): void
    {
        $this->menuOpen = !$this->menuOpen;
    }

    public function closeMenu(): void
    {
        $this->menuOpen = false;
    }

    public function render(): View
    {
        return view('livewire.guest.navigation', [
            'links' => $this->getLinks(),
        ]);
    }

}
