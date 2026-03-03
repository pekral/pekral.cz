<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class ProjectsSection extends Component
{

    private const array PROJECTS = [
        ['name' => 'rector-rules', 'url' => 'https://github.com/pekral/rector-rules', 'language' => 'PHP'],
        ['name' => 'arch-app-services', 'url' => 'https://github.com/pekral/arch-app-services', 'language' => 'PHP'],
        ['name' => 'cursor-rules', 'url' => 'https://github.com/pekral/cursor-rules', 'language' => 'Markdown'],
    ];

    /**
     * @return array<int, array{name: string, description: string, url: string, language: string}>
     */
    public function getProjects(): array
    {
        return array_map(
            fn (array $p): array => [
                'description' => __('guest.projects.section_items.' . $p['name']),
                'language' => $p['language'],
                'name' => $p['name'],
                'url' => $p['url'],
            ],
            self::PROJECTS,
        );
    }

    public function render(): View
    {
        return view('livewire.guest.projects-section', [
            'projects' => $this->getProjects(),
        ]);
    }

}
