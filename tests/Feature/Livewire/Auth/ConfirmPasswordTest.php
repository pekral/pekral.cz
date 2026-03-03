<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function (): void {
    /** @var \Tests\TestCase $this */
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);
    $this->actingAs($this->user);
});

it('renders confirm password component', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('password.confirm'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertStatus(200)->assertSeeLivewire('auth.confirm-password');
});

it('confirms password with valid credentials', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('auth.confirm-password');
    $component->set('password', 'password123');
    $component->call('confirmPassword');
    $component->assertHasNoErrors();
    $component->assertRedirect(route('dashboard'));
});

it('validates required password field', function (): void {
    Livewire::test('auth.confirm-password')
        ->set('password', '')
        ->call('confirmPassword')
        ->assertHasErrors(['password' => 'required']);
});

it('fails with invalid password', function (): void {
    Livewire::test('auth.confirm-password')
        ->set('password', 'wrong-password')
        ->call('confirmPassword')
        ->assertHasErrors(['password']);
});

it('stores password confirmation timestamp', function (): void {
    Livewire::test('auth.confirm-password')
        ->set('password', 'password123')
        ->call('confirmPassword');

    expect(session('auth.password_confirmed_at'))->not->toBeNull();
});
