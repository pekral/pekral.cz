<?php

use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders appearance component', function () {
    $response = $this->get(route('settings.appearance'));
    
    $response->assertStatus(200);
    $response->assertSeeLivewire('settings.appearance');
});

it('displays appearance options', function () {
    Livewire::test('settings.appearance')
        ->assertSee('Light')
        ->assertSee('Dark')
        ->assertSee('System');
});

it('has appearance selection controls', function () {
    Livewire::test('settings.appearance')
        ->assertSee('Light')
        ->assertSee('Dark')
        ->assertSee('System');
});
