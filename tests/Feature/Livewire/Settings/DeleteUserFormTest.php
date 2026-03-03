<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

beforeEach(function (): void {
    /** @var \Tests\TestCase $this */
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders delete user form component', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('settings.profile'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertStatus(200)->assertSeeLivewire('settings.delete-user-form');
});

it('deletes user account with valid password', function (): void {
    /** @var \Tests\TestCase $this */
    $user = $this->user;
    assert($user !== null);
    $user->update(['password' => bcrypt('password123')]);

    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.delete-user-form');
    $component->set('password', 'password123');
    $component->call('deleteUser');
    $component->assertHasNoErrors();
    $component->assertRedirect('/');

    expect(Auth::check())->toBeFalse();
    expect(User::find($user->id))->toBeNull();
});

it('validates required password field', function (): void {
    Livewire::test('settings.delete-user-form')
        ->set('password', '')
        ->call('deleteUser')
        ->assertHasErrors(['password' => 'required']);
});

it('fails with invalid password', function (): void {
    /** @var \Tests\TestCase $this */
    $user = $this->user;
    assert($user !== null);
    $user->update(['password' => bcrypt('password123')]);

    Livewire::test('settings.delete-user-form')
        ->set('password', 'wrongpassword')
        ->call('deleteUser')
        ->assertHasErrors(['password' => 'current_password']);
});
