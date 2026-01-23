<?php

declare(strict_types=1);

use App\Livewire\Guest\ProjectsSection;
use Livewire\Livewire;

it('renders projects section component', function (): void {
    Livewire::test(ProjectsSection::class)
        ->assertStatus(200);
});

it('displays section title', function (): void {
    Livewire::test(ProjectsSection::class)
        ->assertSee('Projects');
});

it('displays rector-rules project', function (): void {
    Livewire::test(ProjectsSection::class)
        ->assertSee('rector-rules')
        ->assertSee('Custom Rector rules');
});

it('displays arch-app-services project', function (): void {
    Livewire::test(ProjectsSection::class)
        ->assertSee('arch-app-services')
        ->assertSee('Simple architecture for PHP services');
});

it('displays cursor-rules project', function (): void {
    Livewire::test(ProjectsSection::class)
        ->assertSee('cursor-rules')
        ->assertSee('Preferred rules for generating code');
});

it('displays view all repositories link', function (): void {
    Livewire::test(ProjectsSection::class)
        ->assertSee('View all repositories')
        ->assertSeeHtml('href="https://github.com/pekral?tab=repositories"');
});
