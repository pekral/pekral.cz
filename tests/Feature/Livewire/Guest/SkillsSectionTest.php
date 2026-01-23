<?php

declare(strict_types=1);

use App\Livewire\Guest\SkillsSection;
use Livewire\Livewire;

it('renders skills section component', function (): void {
    Livewire::test(SkillsSection::class)
        ->assertStatus(200);
});

it('displays section title', function (): void {
    Livewire::test(SkillsSection::class)
        ->assertSee('Skills');
});

it('displays languages section', function (): void {
    Livewire::test(SkillsSection::class)
        ->assertSee('Languages')
        ->assertSee('PHP')
        ->assertSee('JavaScript')
        ->assertSee('TypeScript');
});

it('displays frameworks section', function (): void {
    Livewire::test(SkillsSection::class)
        ->assertSee('Frameworks')
        ->assertSee('Laravel')
        ->assertSee('Symfony')
        ->assertSee('React');
});

it('displays tools section', function (): void {
    Livewire::test(SkillsSection::class)
        ->assertSee('Tools')
        ->assertSee('Git')
        ->assertSee('Docker')
        ->assertSee('PHPUnit');
});

it('displays practices section', function (): void {
    Livewire::test(SkillsSection::class)
        ->assertSee('Practices')
        ->assertSee('Clean Code')
        ->assertSee('TDD')
        ->assertSee('DDD');
});
