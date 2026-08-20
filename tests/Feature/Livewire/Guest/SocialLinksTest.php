<?php

declare(strict_types = 1);

use App\Livewire\Guest\SocialLinks;
use Illuminate\Support\Facades\Config;
use Livewire\Livewire;

it('renders social links component', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SocialLinks::class);
    $component->assertStatus(200);
});

it('displays github link', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SocialLinks::class);
    $component->assertSee('GitHub');
    $component->assertSeeHtml(sprintf('href="%s"', Config::string('social.github')));
});

it('displays twitter link', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SocialLinks::class);
    $component->assertSee('X (Twitter)');
    $component->assertSeeHtml(sprintf('href="%s"', Config::string('social.x')));
});

it('displays linkedin link', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SocialLinks::class);
    $component->assertSee('LinkedIn');
    $component->assertSeeHtml(sprintf('href="%s"', Config::string('social.linkedin')));
});

it('displays correct number of social links', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SocialLinks::class);
    $component->assertSeeHtml('social-link');
});
