<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;
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
                'url' => Config::string('social.github'),
            ],
            [
                'icon' => 'twitter',
                'name' => __('guest.footer.x_twitter'),
                'url' => Config::string('social.x'),
            ],
            [
                'icon' => 'linkedin',
                'name' => __('guest.footer.linkedin'),
                'url' => Config::string('social.linkedin'),
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
