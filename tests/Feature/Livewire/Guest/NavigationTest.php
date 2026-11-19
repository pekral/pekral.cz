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

it('shows a mobile menu toggle that controls the mobile menu', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $component->assertSeeHtml('aria-controls="mobile-menu"');
    $component->assertSeeHtml('@click="open = !open"');
    $component->assertSeeHtml('id="mobile-menu"');
    $component->assertSeeHtml('x-show="open"');
});

it('marks the current locale in the language switch', function (string $locale): void {
    app()->setLocale($locale);

    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Navigation::class);
    $html = $component->html();
    expect(substr_count($html, 'aria-current="true"'))->toBe(1);
    expect(preg_match(sprintf('~href="%s"[^>]*aria-current="true"~', preg_quote(route('locale.switch', $locale), '~')), $html))->toBe(1);
})->with(['en', 'cs']);
