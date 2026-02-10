<?php

declare(strict_types = 1);

use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders appearance component', function (): void {
    $response = $this->get(route('settings.appearance'));

    $response->assertStatus(200);
    $response->assertSeeLivewire('settings.appearance');
});

it('displays appearance options', function (): void {
    Livewire::test('settings.appearance')
        ->assertSee('Light')
        ->assertSee('Dark')
        ->assertSee('System');
});

it('has appearance selection controls', function (): void {
    Livewire::test('settings.appearance')
        ->assertSee('Light')
        ->assertSee('Dark')
        ->assertSee('System');
});
