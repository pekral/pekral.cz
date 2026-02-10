<?php

declare(strict_types = 1);

use App\Livewire\Guest\HeroSection;
use Livewire\Livewire;

it('renders hero section component', function (): void {
    Livewire::test(HeroSection::class)
        ->assertStatus(200);
});

it('displays profile name', function (): void {
    Livewire::test(HeroSection::class)
        ->assertSee('Petr Král');
});

it('displays role', function (): void {
    Livewire::test(HeroSection::class)
        ->assertSee('PHP Developer')
        ->assertSee('Laravel Programmer');
});

it('displays location', function (): void {
    Livewire::test(HeroSection::class)
        ->assertSee('Chlumec nad Cidlinou, Czech Republic');
});

it('displays bio text', function (): void {
    Livewire::test(HeroSection::class)
        ->assertSee('Senior PHP Developer')
        ->assertSee('Laravel programmer')
        ->assertSee('open source contributor');
});

it('displays terminal window', function (): void {
    Livewire::test(HeroSection::class)
        ->assertSee('petr@portfolio');
});
