<?php

declare(strict_types = 1);

use App\Livewire\Guest\Footer;
use Livewire\Livewire;

it('renders footer component', function (): void {
    Livewire::test(Footer::class)
        ->assertStatus(200);
});

it('displays copyright with current year', function (): void {
    $currentYear = date('Y');

    Livewire::test(Footer::class)
        ->assertSee(sprintf('© %s Petr Král - PHP Developer', $currentYear));
});

it('displays navigation links', function (): void {
    Livewire::test(Footer::class)
        ->assertSee('Navigation')
        ->assertSee('Home')
        ->assertSee('About Me')
        ->assertSee('Privacy Policy');
});

it('displays connect section with social links', function (): void {
    Livewire::test(Footer::class)
        ->assertSee('Connect')
        ->assertSee('GitHub')
        ->assertSee('LinkedIn');
});
