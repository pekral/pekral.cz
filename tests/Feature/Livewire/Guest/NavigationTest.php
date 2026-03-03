<?php

declare(strict_types = 1);

use App\Livewire\Guest\Navigation;
use Livewire\Livewire;

it('renders navigation component', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $component->assertStatus(200);
    $component->assertSee('pekral');
});

it('displays all navigation links', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $component->assertSee('about');
    $component->assertSee('skills');
    $component->assertSee('projects');
});

it('contains home link', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $component->assertSeeHtml('href="' . route('home') . '"');
});

it('contains about link with route', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $component->assertSeeHtml('href="' . route('about') . '"');
});

it('contains skills link with route', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $component->assertSeeHtml('href="' . route('skills') . '"');
});

it('contains projects link with route', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $component->assertSeeHtml('href="' . route('projects') . '"');
});

it('contains obfuscated email component', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $component->assertSee('contact');
});

it('shows hamburger menu button for mobile', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $component->assertSeeHtml('toggleMenu');
});

it('toggles mobile menu open and closed', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $component->assertSet('menuOpen', false);
    $component->call('toggleMenu');
    $component->assertSet('menuOpen', true);
    $component->call('toggleMenu');
    $component->assertSet('menuOpen', false);
});

it('closes mobile menu when closeMenu is called', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $component->call('toggleMenu');
    $component->assertSet('menuOpen', true);
    $component->call('closeMenu');
    $component->assertSet('menuOpen', false);
});
