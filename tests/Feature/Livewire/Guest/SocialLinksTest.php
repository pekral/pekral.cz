<?php

declare(strict_types=1);

use App\Livewire\Guest\SocialLinks;
use Livewire\Livewire;

it('renders social links component', function () {
    Livewire::test(SocialLinks::class)
        ->assertStatus(200);
});

it('displays github link', function () {
    Livewire::test(SocialLinks::class)
        ->assertSee('GitHub')
        ->assertSeeHtml('href="https://github.com/pekral"');
});

it('displays twitter link', function () {
    Livewire::test(SocialLinks::class)
        ->assertSee('X (Twitter)')
        ->assertSeeHtml('href="https://x.com/kral_petr_88"');
});

it('displays linkedin link', function () {
    Livewire::test(SocialLinks::class)
        ->assertSee('LinkedIn')
        ->assertSeeHtml('href="https://www.linkedin.com/in/petr-kr');
});

it('displays website link', function () {
    Livewire::test(SocialLinks::class)
        ->assertSee('Website')
        ->assertSeeHtml('href="https://pekral.cz"');
});
