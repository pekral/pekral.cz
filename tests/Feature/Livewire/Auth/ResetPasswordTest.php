<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;

beforeEach(function (): void {
    /** @var \Tests\TestCase $this */
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
    ]);
});

it('renders reset password component', function (): void {
    /** @var \Tests\TestCase $this */
    $user = $this->user;
    assert($user !== null);
    $token = Password::createToken($user);
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response = $this->get(route('password.reset', $token));

    $response->assertStatus(200)->assertSeeLivewire('auth.reset-password');
});

it('resets password with valid token and data', function (): void {
    /** @var \Tests\TestCase $this */
    $user = $this->user;
    assert($user !== null);
    $token = Password::createToken($user);
    $newPassword = 'newpassword123';

    Livewire::test('auth.reset-password', ['token' => $token])
        ->set('email', 'test@example.com')
        ->set('password', $newPassword)
        ->set('password_confirmation', $newPassword)
        ->call('resetPassword')
        ->assertHasNoErrors();

    $user->refresh();
    expect(Hash::check($newPassword, $user->password))->toBeTrue();
});

it('validates required fields', function (): void {
    /** @var \Tests\TestCase $this */
    $user = $this->user;
    assert($user !== null);
    $token = Password::createToken($user);

    Livewire::test('auth.reset-password', ['token' => $token])
        ->set('email', '')
        ->set('password', '')
        ->set('password_confirmation', '')
        ->call('resetPassword')
        ->assertHasErrors(['email' => 'required', 'password' => 'required']);
});

it('validates email format', function (): void {
    /** @var \Tests\TestCase $this */
    $user = $this->user;
    assert($user !== null);
    $token = Password::createToken($user);

    Livewire::test('auth.reset-password', ['token' => $token])
        ->set('email', 'invalid-email')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertHasErrors(['email' => 'email']);
});

it('validates password confirmation', function (): void {
    /** @var \Tests\TestCase $this */
    $user = $this->user;
    assert($user !== null);
    $token = Password::createToken($user);

    Livewire::test('auth.reset-password', ['token' => $token])
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'different-password')
        ->call('resetPassword')
        ->assertHasErrors(['password' => 'confirmed']);
});

it('validates password requirements', function (): void {
    /** @var \Tests\TestCase $this */
    $user = $this->user;
    assert($user !== null);
    $token = Password::createToken($user);

    Livewire::test('auth.reset-password', ['token' => $token])
        ->set('email', 'test@example.com')
        ->set('password', '123')
        ->set('password_confirmation', '123')
        ->call('resetPassword')
        ->assertHasErrors(['password']);
});

it('fails with invalid token', function (): void {
    Livewire::test('auth.reset-password', ['token' => 'invalid-token'])
        ->set('email', 'test@example.com')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('resetPassword')
        ->assertHasErrors(['email']);
});
