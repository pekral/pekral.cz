<?php

declare(strict_types=1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class ProjectsSection extends Component
{
    /** @var array<int, array{name: string, description: string, url: string, language: string}> */
    public array $projects = [
        [
            'name' => 'rector-rules',
            'description' => 'Custom Rector rules for automated code refactoring and PHP upgrades.',
            'url' => 'https://github.com/pekral/rector-rules',
            'language' => 'PHP',
        ],
        [
            'name' => 'arch-app-services',
            'description' => 'Simple architecture for PHP services with clean separation of concerns.',
            'url' => 'https://github.com/pekral/arch-app-services',
            'language' => 'PHP',
        ],
        [
            'name' => 'cursor-rules',
            'description' => 'Preferred rules for generating code in the Cursor editor.',
            'url' => 'https://github.com/pekral/cursor-rules',
            'language' => 'Markdown',
        ],
    ];

    public function render(): View
    {
        return view('livewire.guest.projects-section');
    }
}
