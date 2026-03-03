<?php

declare(strict_types = 1);

use App\Livewire\Guest\SocialLinks;
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
    $component->assertSeeHtml('href="https://github.com/pekral"');
});

it('displays twitter link', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SocialLinks::class);
    $component->assertSee('X (Twitter)');
    $component->assertSeeHtml('href="https://x.com/kral_petr_88"');
});

it('displays linkedin link', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SocialLinks::class);
    $component->assertSee('LinkedIn');
    $component->assertSeeHtml('href="https://www.linkedin.com/in/petr-kr');
});

it('displays correct number of social links', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SocialLinks::class);
    $component->assertSeeHtml('social-link');
});
