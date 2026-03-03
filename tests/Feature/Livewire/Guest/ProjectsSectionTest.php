<?php

declare(strict_types = 1);

use App\Livewire\Guest\ProjectsSection;
use Livewire\Livewire;

it('renders projects section component', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(ProjectsSection::class);
    $component->assertStatus(200);
});

it('displays section title', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(ProjectsSection::class);
    $component->assertSee('Projects');
});

it('displays rector-rules project', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(ProjectsSection::class);
    $component->assertSee('rector-rules');
    $component->assertSee('Custom Rector rules');
});

it('displays arch-app-services project', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(ProjectsSection::class);
    $component->assertSee('arch-app-services');
    $component->assertSee('Simple architecture for PHP services');
});

it('displays cursor-rules project', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(ProjectsSection::class);
    $component->assertSee('cursor-rules');
    $component->assertSee('Preferred rules for generating code');
});

it('displays view all repositories link', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(ProjectsSection::class);
    $component->assertSee('View all repositories');
    $component->assertSeeHtml('href="https://github.com/pekral?tab=repositories"');
});
