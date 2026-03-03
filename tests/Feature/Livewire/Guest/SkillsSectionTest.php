<?php

declare(strict_types = 1);

use App\Livewire\Guest\SkillsSection;
use Livewire\Livewire;

it('renders skills section component', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsSection::class);
    $component->assertStatus(200);
});

it('displays section title', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsSection::class);
    $component->assertSee('Skills');
});

it('displays languages section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsSection::class);
    $component->assertSee('Languages');
    $component->assertSee('PHP');
    $component->assertSee('JavaScript');
    $component->assertSee('SQL');
});

it('displays frameworks section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsSection::class);
    $component->assertSee('Frameworks');
    $component->assertSee('Laravel');
    $component->assertSee('Symfony');
    $component->assertSee('Vue.js');
});

it('displays tools section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsSection::class);
    $component->assertSee('Tools');
    $component->assertSee('Git');
    $component->assertSee('Docker');
    $component->assertSee('Rector');
    $component->assertSee('PHPUnit');
});

it('displays practices section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsSection::class);
    $component->assertSee('Practices');
    $component->assertSee('Clean Code');
    $component->assertSee('TDD');
    $component->assertSee('DDD');
});
