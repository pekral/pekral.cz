<?php

declare(strict_types = 1);

use App\Livewire\Guest\Navigation;
use Livewire\Livewire;

it('renders navigation component', function (): void {
    Livewire::test(Navigation::class)
        ->assertStatus(200)
        ->assertSee('pekral');
});

it('displays all navigation links', function (): void {
    Livewire::test(Navigation::class)
        ->assertSee('about')
        ->assertSee('skills')
        ->assertSee('projects');
});

it('contains home link', function (): void {
    Livewire::test(Navigation::class)
        ->assertSeeHtml('href="' . route('home') . '"');
});

it('contains about link with route', function (): void {
    Livewire::test(Navigation::class)
        ->assertSeeHtml('href="' . route('about') . '"');
});

it('contains skills link with route', function (): void {
    Livewire::test(Navigation::class)
        ->assertSeeHtml('href="' . route('skills') . '"');
});

it('contains projects link with route', function (): void {
    Livewire::test(Navigation::class)
        ->assertSeeHtml('href="' . route('projects') . '"');
});

it('contains obfuscated email component', function (): void {
    Livewire::test(Navigation::class)
        ->assertSee('contact');
});

it('shows hamburger menu button for mobile', function (): void {
    Livewire::test(Navigation::class)
        ->assertSeeHtml('toggleMenu');
});

it('toggles mobile menu open and closed', function (): void {
    Livewire::test(Navigation::class)
        ->assertSet('menuOpen', false)
        ->call('toggleMenu')
        ->assertSet('menuOpen', true)
        ->call('toggleMenu')
        ->assertSet('menuOpen', false);
});

it('closes mobile menu when closeMenu is called', function (): void {
    Livewire::test(Navigation::class)
        ->call('toggleMenu')
        ->assertSet('menuOpen', true)
        ->call('closeMenu')
        ->assertSet('menuOpen', false);
});
