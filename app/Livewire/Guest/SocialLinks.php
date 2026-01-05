<?php

declare(strict_types=1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SocialLinks extends Component
{
    /** @var array<int, array{name: string, url: string, icon: string}> */
    public array $links = [
        [
            'name' => 'GitHub',
            'url' => 'https://github.com/pekral',
            'icon' => 'github',
        ],
        [
            'name' => 'X (Twitter)',
            'url' => 'https://x.com/kral_petr_88',
            'icon' => 'twitter',
        ],
        [
            'name' => 'LinkedIn',
            'url' => 'https://www.linkedin.com/in/petr-král-60223752/',
            'icon' => 'linkedin',
        ],
    ];

    public function render(): View
    {
        return view('livewire.guest.social-links');
    }
}
