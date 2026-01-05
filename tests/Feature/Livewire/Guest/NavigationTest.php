<?php

declare(strict_types=1);

use App\Livewire\Guest\Navigation;
use Livewire\Livewire;

it('renders navigation component', function () {
    Livewire::test(Navigation::class)
        ->assertStatus(200)
        ->assertSee('pekral');
});

it('displays all navigation links', function () {
    Livewire::test(Navigation::class)
        ->assertSee('about')
        ->assertSee('skills')
        ->assertSee('projects')
        ->assertSee('contact');
});

it('contains home link', function () {
    Livewire::test(Navigation::class)
        ->assertSeeHtml('href="'.route('home').'"');
});

it('contains about link with route', function () {
    Livewire::test(Navigation::class)
        ->assertSeeHtml('href="'.route('about').'"');
});

it('contains skills link with route', function () {
    Livewire::test(Navigation::class)
        ->assertSeeHtml('href="'.route('skills').'"');
});

it('contains projects link with route', function () {
    Livewire::test(Navigation::class)
        ->assertSeeHtml('href="'.route('projects').'"');
});

it('contains contact email link', function () {
    Livewire::test(Navigation::class)
        ->assertSeeHtml('href="mailto:petr@pekral.cz"');
});
