<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);
    $this->actingAs($this->user);
});

it('renders confirm password component', function () {
    $response = $this->get(route('password.confirm'));
    
    $response->assertStatus(200);
    $response->assertSeeLivewire('auth.confirm-password');
});

it('confirms password with valid credentials', function () {
    Livewire::test('auth.confirm-password')
        ->set('password', 'password123')
        ->call('confirmPassword')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));
});

it('validates required password field', function () {
    Livewire::test('auth.confirm-password')
        ->set('password', '')
        ->call('confirmPassword')
        ->assertHasErrors(['password' => 'required']);
});

it('fails with invalid password', function () {
    Livewire::test('auth.confirm-password')
        ->set('password', 'wrong-password')
        ->call('confirmPassword')
        ->assertHasErrors(['password']);
});

it('stores password confirmation timestamp', function () {
    Livewire::test('auth.confirm-password')
        ->set('password', 'password123')
        ->call('confirmPassword');

    expect(session('auth.password_confirmed_at'))->not->toBeNull();
});
