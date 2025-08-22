<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function () {
    $this->userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];
});

it('renders register component', function () {
    $response = $this->get(route('register'));
    
    $response->assertStatus(200);
    $response->assertSeeLivewire('auth.register');
});

it('registers new user with valid data', function () {
    Livewire::test('auth.register')
        ->set('name', $this->userData['name'])
        ->set('email', $this->userData['email'])
        ->set('password', $this->userData['password'])
        ->set('password_confirmation', $this->userData['password_confirmation'])
        ->call('register')
        ->assertRedirect(route('dashboard'));

    expect(Auth::check())->toBeTrue();
    expect(Auth::user()->name)->toBe($this->userData['name']);
    expect(Auth::user()->email)->toBe($this->userData['email']);
});

it('validates required fields', function () {
    Livewire::test('auth.register')
        ->set('name', '')
        ->set('email', '')
        ->set('password', '')
        ->set('password_confirmation', '')
        ->call('register')
        ->assertHasErrors(['name' => 'required', 'email' => 'required', 'password' => 'required']);
});

it('validates email format', function () {
    Livewire::test('auth.register')
        ->set('name', $this->userData['name'])
        ->set('email', 'invalid-email')
        ->set('password', $this->userData['password'])
        ->set('password_confirmation', $this->userData['password_confirmation'])
        ->call('register')
        ->assertHasErrors(['email' => 'email']);
});

it('validates password confirmation', function () {
    Livewire::test('auth.register')
        ->set('name', $this->userData['name'])
        ->set('email', $this->userData['email'])
        ->set('password', $this->userData['password'])
        ->set('password_confirmation', 'different-password')
        ->call('register')
        ->assertHasErrors(['password' => 'confirmed']);
});

it('validates password length', function () {
    Livewire::test('auth.register')
        ->set('name', $this->userData['name'])
        ->set('email', $this->userData['email'])
        ->set('password', '123')
        ->set('password_confirmation', '123')
        ->call('register')
        ->assertHasErrors(['password']);
});

it('prevents duplicate email registration', function () {
    User::factory()->create(['email' => $this->userData['email']]);

    Livewire::test('auth.register')
        ->set('name', $this->userData['name'])
        ->set('email', $this->userData['email'])
        ->set('password', $this->userData['password'])
        ->set('password_confirmation', $this->userData['password_confirmation'])
        ->call('register')
        ->assertHasErrors(['email' => 'unique']);
});
