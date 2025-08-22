<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);
    $this->actingAs($this->user);
});

it('renders profile component', function () {
    $response = $this->get(route('settings.profile'));
    
    $response->assertStatus(200);
    $response->assertSeeLivewire('settings.profile');
});

it('loads current user data', function () {
    Livewire::test('settings.profile')
        ->assertSet('name', 'Original Name')
        ->assertSet('email', 'original@example.com');
});

it('updates profile information', function () {
    Livewire::test('settings.profile')
        ->set('name', 'Updated Name')
        ->set('email', 'updated@example.com')
        ->call('updateProfileInformation')
        ->assertHasNoErrors()
        ->assertDispatched('profile-updated');

    $this->user->refresh();
    expect($this->user->name)->toBe('Updated Name');
    expect($this->user->email)->toBe('updated@example.com');
});

it('validates required fields', function () {
    Livewire::test('settings.profile')
        ->set('name', '')
        ->set('email', '')
        ->call('updateProfileInformation')
        ->assertHasErrors(['name' => 'required', 'email' => 'required']);
});

it('validates email format', function () {
    Livewire::test('settings.profile')
        ->set('name', 'Test Name')
        ->set('email', 'invalid-email')
        ->call('updateProfileInformation')
        ->assertHasErrors(['email' => 'email']);
});

it('prevents duplicate email', function () {
    User::factory()->create(['email' => 'existing@example.com']);

    Livewire::test('settings.profile')
        ->set('name', 'Test Name')
        ->set('email', 'existing@example.com')
        ->call('updateProfileInformation')
        ->assertHasErrors(['email' => 'unique']);
});

it('allows same email for current user', function () {
    Livewire::test('settings.profile')
        ->set('name', 'Updated Name')
        ->set('email', 'original@example.com')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();
});

it('resets email verification when email changes', function () {
    $this->user->update(['email_verified_at' => now()]);

    Livewire::test('settings.profile')
        ->set('name', 'Test Name')
        ->set('email', 'newemail@example.com')
        ->call('updateProfileInformation');

    $this->user->refresh();
    expect($this->user->email_verified_at)->toBeNull();
});

it('sends verification email when requested', function () {
    $this->user->update(['email_verified_at' => null]);

    Livewire::test('settings.profile')
        ->call('resendVerificationNotification')
        ->assertRedirect(route('dashboard'));
});

it('redirects verified user when resending verification', function () {
    $this->user->update(['email_verified_at' => now()]);

    Livewire::test('settings.profile')
        ->call('resendVerificationNotification')
        ->assertRedirect(route('dashboard'));
});
