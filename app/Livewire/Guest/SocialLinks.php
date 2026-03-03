<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SocialLinks extends Component
{

    /**
     * @return array<int, array{name: string, url: string, icon: string}>
     */
    public function getLinks(): array
    {
        return [
            [
                'icon' => 'github',
                'name' => __('guest.footer.github'),
                'url' => 'https://github.com/pekral',
            ],
            [
                'icon' => 'twitter',
                'name' => __('guest.footer.x_twitter'),
                'url' => 'https://x.com/kral_petr_88',
            ],
            [
                'icon' => 'linkedin',
                'name' => __('guest.footer.linkedin'),
                'url' => 'https://www.linkedin.com/in/petr-král-60223752/',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.guest.social-links', [
            'links' => $this->getLinks(),
        ]);
    }

}
