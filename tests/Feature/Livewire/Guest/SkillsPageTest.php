<?php

declare(strict_types = 1);

use App\Livewire\Guest\SkillsPage;
use Livewire\Livewire;

it('renders skills page component', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsPage::class);
    $component->assertStatus(200);
});

it('displays page title', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsPage::class);
    $component->assertSee('Skills');
});

it('displays back link', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsPage::class);
    $component->assertSee('Back to home');
    $component->assertSeeHtml('href="' . route('home') . '"');
});

it('displays languages section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsPage::class);
    $component->assertSee('Languages');
    $component->assertSee('PHP');
    $component->assertSee('JavaScript');
});

it('displays frameworks section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsPage::class);
    $component->assertSee('Frameworks');
    $component->assertSee('Laravel');
    $component->assertSee('Symfony');
});

it('displays tools section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsPage::class);
    $component->assertSee('Tools');
    $component->assertSee('Git');
    $component->assertSee('Docker');
});

it('displays practices section', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(SkillsPage::class);
    $component->assertSee('Practices');
    $component->assertSee('Clean Code');
    $component->assertSee('SOLID');
});

it('displays skills in category order languages then frameworks then tools then practices', function (): void {
    $component = Livewire::test(SkillsPage::class);
    $html = $component->html();
    $langPos = strpos($html, 'Languages');
    $fwPos = strpos($html, 'Frameworks');
    $toolsPos = strpos($html, 'Tools');
    $practicesPos = strpos($html, 'Practices');
    expect($langPos)->not->toBeFalse()
        ->and($fwPos)->not->toBeFalse()
        ->and($toolsPos)->not->toBeFalse()
        ->and($practicesPos)->not->toBeFalse();
    $lang = (int) $langPos;
    $fw = (int) $fwPos;
    $tools = (int) $toolsPos;
    $practices = (int) $practicesPos;
    expect($lang)->toBeLessThan($fw)
        ->and($fw)->toBeLessThan($tools)
        ->and($tools)->toBeLessThan($practices);
});

it('returns skills by category in defined order', function (): void {
    $page = new SkillsPage();
    $skillsByCategory = $page->getSkillsByCategory();
    expect(array_keys($skillsByCategory))->toBe(SkillsPage::CATEGORY_ORDER);
});
