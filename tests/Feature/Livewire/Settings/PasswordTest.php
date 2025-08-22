<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create([
        'password' => Hash::make('oldpassword'),
    ]);
    $this->actingAs($this->user);
});

it('renders password component', function () {
    $response = $this->get(route('settings.password'));
    
    $response->assertStatus(200);
    $response->assertSeeLivewire('settings.password');
});

it('updates password with valid data', function () {
    Livewire::test('settings.password')
        ->set('current_password', 'oldpassword')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('updatePassword')
        ->assertHasNoErrors()
        ->assertDispatched('password-updated');

    $this->user->refresh();
    expect(Hash::check('newpassword123', $this->user->password))->toBeTrue();
});

it('validates required fields', function () {
    Livewire::test('settings.password')
        ->set('current_password', '')
        ->set('password', '')
        ->set('password_confirmation', '')
        ->call('updatePassword')
        ->assertHasErrors(['current_password' => 'required', 'password' => 'required']);
});

it('validates current password', function () {
    Livewire::test('settings.password')
        ->set('current_password', 'wrongpassword')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('updatePassword')
        ->assertHasErrors(['current_password' => 'current_password']);
});

it('validates password confirmation', function () {
    Livewire::test('settings.password')
        ->set('current_password', 'oldpassword')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'differentpassword')
        ->call('updatePassword')
        ->assertHasErrors(['password' => 'confirmed']);
});

it('validates password length', function () {
    Livewire::test('settings.password')
        ->set('current_password', 'oldpassword')
        ->set('password', '123')
        ->set('password_confirmation', '123')
        ->call('updatePassword')
        ->assertHasErrors(['password']);
});

it('clears form after successful update', function () {
    Livewire::test('settings.password')
        ->set('current_password', 'oldpassword')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('updatePassword');

    $component = Livewire::test('settings.password');
    expect($component->get('current_password'))->toBe('');
    expect($component->get('password'))->toBe('');
    expect($component->get('password_confirmation'))->toBe('');
});
