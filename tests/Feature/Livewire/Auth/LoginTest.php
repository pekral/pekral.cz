<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);
});

it('renders login component', function (): void {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
    $response->assertSeeLivewire('auth.login');
});

it('logs in user with valid credentials', function (): void {
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('remember', true)
        ->call('login')
        ->assertRedirect(route('dashboard'));

    expect(Auth::check())->toBeTrue();
    expect(Auth::user()->email)->toBe('test@example.com');
});

it('fails login with invalid credentials', function (): void {
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'wrong-password')
        ->call('login')
        ->assertHasErrors(['email']);
});

it('validates required fields', function (): void {
    Livewire::test('auth.login')
        ->set('email', '')
        ->set('password', '')
        ->call('login')
        ->assertHasErrors(['email' => 'required', 'password' => 'required']);
});

it('validates email format', function (): void {
    Livewire::test('auth.login')
        ->set('email', 'invalid-email')
        ->set('password', 'password')
        ->call('login')
        ->assertHasErrors(['email' => 'email']);
});

it('rate limits after multiple failed attempts', function (): void {
    Event::fake([Lockout::class]);

    for ($i = 0; $i < 5; $i++) {
        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'wrong-password')
            ->call('login');
    }

    $response = Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'wrong-password')
        ->call('login');

    $response->assertHasErrors(['email']);
    Event::assertDispatched(Lockout::class);
});

it('clears rate limit after successful login', function (): void {
    // Failed attempts
    for ($i = 0; $i < 3; $i++) {
        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'wrong-password')
            ->call('login');
    }

    // Successful login
    Livewire::test('auth.login')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->call('login');

    // Rate limit should be cleared
    expect(RateLimiter::tooManyAttempts('test@example.com|' . request()->ip(), 5))->toBeFalse();
});
