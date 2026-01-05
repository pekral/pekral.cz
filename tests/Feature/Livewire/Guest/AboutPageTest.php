<?php

declare(strict_types=1);

use App\Livewire\Guest\AboutPage;
use Livewire\Livewire;

it('renders about page component', function () {
    Livewire::test(AboutPage::class)
        ->assertStatus(200);
});

it('displays page title', function () {
    Livewire::test(AboutPage::class)
        ->assertSee('About');
});

it('displays back link', function () {
    Livewire::test(AboutPage::class)
        ->assertSee('Back to home')
        ->assertSeeHtml('href="'.route('home').'"');
});

it('displays experience section', function () {
    Livewire::test(AboutPage::class)
        ->assertSee('Experience')
        ->assertSee('PHP Programmer')
        ->assertSee('Self-employed');
});

it('displays focus section', function () {
    Livewire::test(AboutPage::class)
        ->assertSee('What I Focus On')
        ->assertSee('Rector rules');
});

it('displays open source section', function () {
    Livewire::test(AboutPage::class)
        ->assertSee('Open Source')
        ->assertSee('github.com/pekral');
});
