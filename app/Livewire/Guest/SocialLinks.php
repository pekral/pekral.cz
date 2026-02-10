<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SocialLinks extends Component
{

    /**
     * @var array<int, array{name: string, url: string, icon: string}>
     */
    public array $links = [
        [
            'icon' => 'github',
            'name' => 'GitHub',
            'url' => 'https://github.com/pekral',
        ],
        [
            'icon' => 'twitter',
            'name' => 'X (Twitter)',
            'url' => 'https://x.com/kral_petr_88',
        ],
        [
            'icon' => 'linkedin',
            'name' => 'LinkedIn',
            'url' => 'https://www.linkedin.com/in/petr-král-60223752/',
        ],
    ];

    public function render(): View
    {
        return view('livewire.guest.social-links');
    }

}
