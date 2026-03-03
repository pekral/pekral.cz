<?php

declare(strict_types = 1);

use App\Livewire\Guest\AboutPage;
use Livewire\Livewire;

it('renders about page component', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(AboutPage::class);
    $component->assertStatus(200);
});

it('displays page title', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(AboutPage::class);
    $component->assertSee('About');
});

it('displays back link', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(AboutPage::class);
    $component->assertSee('Back to home');
    $component->assertSeeHtml('href="' . route('home') . '"');
});

it('displays experience section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(AboutPage::class);
    $component->assertSee('Experience');
    $component->assertSee('PHP Developer');
    $component->assertSee('Self-employed');
});

it('displays focus section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(AboutPage::class);
    $component->assertSee('What I Focus On');
    $component->assertSee('Laravel & PHP development');
});

it('displays connect section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(AboutPage::class);
    $component->assertSee('Connect');
    $component->assertSee('github.com/pekral');
});
