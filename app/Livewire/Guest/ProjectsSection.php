<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class ProjectsSection extends Component
{

    /**
     * @var array<int, array{name: string, description: string, url: string, language: string}>
     */
    public array $projects = [
        [
            'description' => 'Custom Rector rules for automated code refactoring and PHP upgrades.',
            'language' => 'PHP',
            'name' => 'rector-rules',
            'url' => 'https://github.com/pekral/rector-rules',
        ],
        [
            'description' => 'Simple architecture for PHP services with clean separation of concerns.',
            'language' => 'PHP',
            'name' => 'arch-app-services',
            'url' => 'https://github.com/pekral/arch-app-services',
        ],
        [
            'description' => 'Preferred rules for generating code in the Cursor editor.',
            'language' => 'Markdown',
            'name' => 'cursor-rules',
            'url' => 'https://github.com/pekral/cursor-rules',
        ],
    ];

    public function render(): View
    {
        return view('livewire.guest.projects-section');
    }

}
