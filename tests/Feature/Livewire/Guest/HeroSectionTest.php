<?php

declare(strict_types = 1);

use App\Livewire\Guest\HeroSection;
use Livewire\Livewire;

it('renders hero section component', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(HeroSection::class);
    $component->assertStatus(200);
});

it('displays profile name', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(HeroSection::class);
    $component->assertSee('Petr Král');
});

it('displays role', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(HeroSection::class);
    $component->assertSee('PHP Developer');
    $component->assertSee('Laravel Programmer');
});

it('displays location', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(HeroSection::class);
    $component->assertSee('Chlumec nad Cidlinou, Czech Republic');
});

it('displays bio text', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(HeroSection::class);
    $component->assertSee('Senior PHP Developer');
    $component->assertSee('Laravel programmer');
    $component->assertSee('open source contributor');
});

it('displays terminal window', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(HeroSection::class);
    $component->assertSee('petr@portfolio');
});
