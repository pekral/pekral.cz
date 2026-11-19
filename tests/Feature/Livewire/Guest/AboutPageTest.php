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
    $component->assertSee('Building scalable web applications with Laravel & PHP');
});

it('displays connect section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(AboutPage::class);
    $component->assertSee('Connect');
    $component->assertSee('github.com/pekral');
});

it('links company names in the timeline texts and opens them in a new window', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(AboutPage::class);
    $component->assertSeeHtml(
        '<a href="https://ecomail.cz" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline">ECOMAIL.CZ</a>',
    );
    $component->assertSeeHtml('alongside my role at <a href="https://ecomail.cz"');
});
