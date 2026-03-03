<?php

declare(strict_types = 1);

use App\Livewire\Guest\Footer;
use Livewire\Livewire;

it('renders footer component', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Footer::class);
    $component->assertStatus(200);
});

it('displays copyright with current year', function (): void {
    $currentYear = date('Y');

    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Footer::class);
    $component->assertSee(sprintf('© %s Petr Král - PHP Developer', $currentYear));
});

it('displays navigation links', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Footer::class);
    $component->assertSee('Navigation');
    $component->assertSee('Home');
    $component->assertSee('About Me');
    $component->assertSee('Privacy Policy');
});

it('displays connect section with social links', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(Footer::class);
    $component->assertSee('Connect');
    $component->assertSee('GitHub');
    $component->assertSee('LinkedIn');
});
