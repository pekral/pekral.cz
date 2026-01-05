<?php

declare(strict_types=1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Navigation extends Component
{
    /**
     * @return array<int, array{
     *     name: string,
     *     route: string
     * }>
     */
    public function getLinks(): array
    {
        return [
            [
                'name' => 'about',
                'route' => route('about'),
            ],
            [
                'name' => 'skills',
                'route' => route('skills'),
            ],
            [
                'name' => 'projects',
                'route' => route('projects'),
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.guest.navigation', [
            'links' => $this->getLinks(),
        ]);
    }
}
