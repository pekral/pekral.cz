<?php

declare(strict_types=1);

use App\Livewire\Guest\Footer;
use Livewire\Livewire;

it('renders footer component', function () {
    Livewire::test(Footer::class)
        ->assertStatus(200);
});

it('displays copyright with current year', function () {
    $currentYear = date('Y');

    Livewire::test(Footer::class)
        ->assertSee("© {$currentYear} Petr Král - PHP Developer");
});

it('displays navigation links', function () {
    Livewire::test(Footer::class)
        ->assertSee('Navigation')
        ->assertSee('Home')
        ->assertSee('About Me')
        ->assertSee('Privacy Policy');
});

it('displays connect section with social links', function () {
    Livewire::test(Footer::class)
        ->assertSee('Connect')
        ->assertSee('GitHub')
        ->assertSee('LinkedIn');
});
