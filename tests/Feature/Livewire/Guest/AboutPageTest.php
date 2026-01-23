<?php

declare(strict_types=1);

use App\Livewire\Guest\AboutPage;
use Livewire\Livewire;

it('renders about page component', function (): void {
    Livewire::test(AboutPage::class)
        ->assertStatus(200);
});

it('displays page title', function (): void {
    Livewire::test(AboutPage::class)
        ->assertSee('About');
});

it('displays back link', function (): void {
    Livewire::test(AboutPage::class)
        ->assertSee('Back to home')
        ->assertSeeHtml('href="'.route('home').'"');
});

it('displays experience section', function (): void {
    Livewire::test(AboutPage::class)
        ->assertSee('Experience')
        ->assertSee('PHP Developer')
        ->assertSee('Self-employed');
});

it('displays focus section', function (): void {
    Livewire::test(AboutPage::class)
        ->assertSee('What I Focus On')
        ->assertSee('Laravel & PHP development');
});

it('displays connect section', function (): void {
    Livewire::test(AboutPage::class)
        ->assertSee('Connect')
        ->assertSee('github.com/pekral');
});
