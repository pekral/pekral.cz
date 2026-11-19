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
    $component->assertSee('building with Laravel');
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
    $component->assertSee('with Laravel');
    $component->assertSee('open source contributor');
});

it('displays the headline and the about card without terminal chrome', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(HeroSection::class);
    $component->assertSee('built with AI agents.');
    $component->assertSee('Open Source Contributor | Backend Developer');
    $component->assertSeeHtml('href="' . route('about') . '"');
    $component->assertDontSee('petr@portfolio');
});

it('links ECOMAIL.CZ in the facts strip and opens it in a new window', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(HeroSection::class);
    $component->assertSeeHtml(
        '<a href="https://ecomail.cz" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline">ECOMAIL.CZ</a>',
    );
});
