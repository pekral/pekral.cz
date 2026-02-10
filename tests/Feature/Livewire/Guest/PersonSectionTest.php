<?php

declare(strict_types = 1);

use App\Livewire\Guest\PersonSection;
use Livewire\Livewire;

it('renders person section component', function (): void {
    Livewire::test(PersonSection::class)
        ->assertStatus(200);
});
