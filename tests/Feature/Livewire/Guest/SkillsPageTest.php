<?php

declare(strict_types=1);

use App\Livewire\Guest\SkillsPage;
use Livewire\Livewire;

it('renders skills page component', function () {
    Livewire::test(SkillsPage::class)
        ->assertStatus(200);
});

it('displays page title', function () {
    Livewire::test(SkillsPage::class)
        ->assertSee('Skills');
});

it('displays back link', function () {
    Livewire::test(SkillsPage::class)
        ->assertSee('Back to home')
        ->assertSeeHtml('href="'.route('home').'"');
});

it('displays languages section', function () {
    Livewire::test(SkillsPage::class)
        ->assertSee('Languages')
        ->assertSee('PHP')
        ->assertSee('JavaScript');
});

it('displays frameworks section', function () {
    Livewire::test(SkillsPage::class)
        ->assertSee('Frameworks')
        ->assertSee('Laravel')
        ->assertSee('Symfony');
});

it('displays tools section', function () {
    Livewire::test(SkillsPage::class)
        ->assertSee('Tools')
        ->assertSee('Git')
        ->assertSee('Docker');
});

it('displays practices section', function () {
    Livewire::test(SkillsPage::class)
        ->assertSee('Practices')
        ->assertSee('Clean Code')
        ->assertSee('SOLID');
});
