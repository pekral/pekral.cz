<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

beforeEach(function (): void {
    /** @var \Tests\TestCase $this */
    $this->userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];
});

it('renders register component', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('register'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertStatus(200)->assertSeeLivewire('auth.register');
});

it('registers new user with valid data', function (): void {
    /** @var \Tests\TestCase $this */
    $userData = $this->userData;
    assert($userData !== null);
    Livewire::test('auth.register')
        ->set('name', $userData['name'])
        ->set('email', $userData['email'])
        ->set('password', $userData['password'])
        ->set('password_confirmation', $userData['password_confirmation'])
        ->call('register')
        ->assertRedirect(route('dashboard'));

    expect(Auth::check())->toBeTrue();
    $user = Auth::user();
    assert($user !== null);
    expect($user->name)->toBe($userData['name']);
    expect($user->email)->toBe($userData['email']);
});

it('validates required fields', function (): void {
    Livewire::test('auth.register')
        ->set('name', '')
        ->set('email', '')
        ->set('password', '')
        ->set('password_confirmation', '')
        ->call('register')
        ->assertHasErrors(['name' => 'required', 'email' => 'required', 'password' => 'required']);
});

it('validates email format', function (): void {
    /** @var \Tests\TestCase $this */
    $userData = $this->userData;
    assert($userData !== null);
    Livewire::test('auth.register')
        ->set('name', $userData['name'])
        ->set('email', 'invalid-email')
        ->set('password', $userData['password'])
        ->set('password_confirmation', $userData['password_confirmation'])
        ->call('register')
        ->assertHasErrors(['email' => 'email']);
});

it('validates password confirmation', function (): void {
    /** @var \Tests\TestCase $this */
    $userData = $this->userData;
    assert($userData !== null);
    Livewire::test('auth.register')
        ->set('name', $userData['name'])
        ->set('email', $userData['email'])
        ->set('password', $userData['password'])
        ->set('password_confirmation', 'different-password')
        ->call('register')
        ->assertHasErrors(['password' => 'confirmed']);
});

it('validates password length', function (): void {
    /** @var \Tests\TestCase $this */
    $userData = $this->userData;
    assert($userData !== null);
    Livewire::test('auth.register')
        ->set('name', $userData['name'])
        ->set('email', $userData['email'])
        ->set('password', '123')
        ->set('password_confirmation', '123')
        ->call('register')
        ->assertHasErrors(['password']);
});

it('prevents duplicate email registration', function (): void {
    /** @var \Tests\TestCase $this */
    $userData = $this->userData;
    assert($userData !== null);
    User::factory()->create(['email' => $userData['email']]);

    Livewire::test('auth.register')
        ->set('name', $userData['name'])
        ->set('email', $userData['email'])
        ->set('password', $userData['password'])
        ->set('password_confirmation', $userData['password_confirmation'])
        ->call('register')
        ->assertHasErrors(['email' => 'unique']);
});
