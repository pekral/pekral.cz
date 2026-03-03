<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function (): void {
    /** @var \Tests\TestCase $this */
    $this->user = User::factory()->create([
        'password' => Hash::make('oldpassword'),
    ]);
    $this->actingAs($this->user);
});

it('renders password component', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('settings.password'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertStatus(200)->assertSeeLivewire('settings.password');
});

it('updates password with valid data', function (): void {
    /** @var \Tests\TestCase $this */
    $component = Livewire::test('settings.password');
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component->set('current_password', 'oldpassword');
    $component->set('password', 'newpassword123');
    $component->set('password_confirmation', 'newpassword123');
    $component->call('updatePassword');
    $component->assertHasNoErrors();
    $component->assertDispatched('password-updated');

    $user = $this->user;
    assert($user !== null);
    $user->refresh();
    expect(Hash::check('newpassword123', $user->password))->toBeTrue();
});

it('validates required fields', function (): void {
    Livewire::test('settings.password')
        ->set('current_password', '')
        ->set('password', '')
        ->set('password_confirmation', '')
        ->call('updatePassword')
        ->assertHasErrors(['current_password' => 'required', 'password' => 'required']);
});

it('validates current password', function (): void {
    Livewire::test('settings.password')
        ->set('current_password', 'wrongpassword')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('updatePassword')
        ->assertHasErrors(['current_password' => 'current_password']);
});

it('validates password confirmation', function (): void {
    Livewire::test('settings.password')
        ->set('current_password', 'oldpassword')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'differentpassword')
        ->call('updatePassword')
        ->assertHasErrors(['password' => 'confirmed']);
});

it('validates password length', function (): void {
    Livewire::test('settings.password')
        ->set('current_password', 'oldpassword')
        ->set('password', '123')
        ->set('password_confirmation', '123')
        ->call('updatePassword')
        ->assertHasErrors(['password']);
});

it('clears form after successful update', function (): void {
    Livewire::test('settings.password')
        ->set('current_password', 'oldpassword')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('updatePassword');

    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.password');
    expect($component->get('current_password'))->toBe('');
    expect($component->get('password'))->toBe('');
    expect($component->get('password_confirmation'))->toBe('');
});
