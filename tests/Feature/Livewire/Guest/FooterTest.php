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
        ->assertSee("© {$currentYear} Petr Král");
});

it('displays built with text', function () {
    Livewire::test(Footer::class)
        ->assertSee('Built with')
        ->assertSee('and Laravel');
});
