<?php

declare(strict_types = 1);

use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    /** @var \Tests\TestCase $this */
    $this->user = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);
    $this->actingAs($this->user);
});

it('renders profile component', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('settings.profile'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertStatus(200)->assertSeeLivewire('settings.profile');
});

it('loads current user data', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.profile');
    $component->assertSet('name', 'Original Name');
    $component->assertSet('email', 'original@example.com');
});

it('updates profile information', function (): void {
    /** @var \Tests\TestCase $this */
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.profile');
    $component->set('name', 'Updated Name');
    $component->set('email', 'updated@example.com');
    $component->call('updateProfileInformation');
    $component->assertHasNoErrors();
    $component->assertDispatched('profile-updated');

    $user = $this->user;
    assert($user !== null);
    $user->refresh();
    expect($user->name)->toBe('Updated Name');
    expect($user->email)->toBe('updated@example.com');
});

it('validates required fields', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.profile');
    $component->set('name', '')
        ->set('email', '')
        ->call('updateProfileInformation')
        ->assertHasErrors(['name' => 'required', 'email' => 'required']);
});

it('validates email format', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.profile');
    $component->set('name', 'Test Name')
        ->set('email', 'invalid-email')
        ->call('updateProfileInformation')
        ->assertHasErrors(['email' => 'email']);
});

it('prevents duplicate email', function (): void {
    User::factory()->create(['email' => 'existing@example.com']);

    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.profile');
    $component->set('name', 'Test Name')
        ->set('email', 'existing@example.com')
        ->call('updateProfileInformation')
        ->assertHasErrors(['email' => 'unique']);
});

it('allows same email for current user', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.profile');
    $component->set('name', 'Updated Name')
        ->set('email', 'original@example.com')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();
});

it('resets email verification when email changes', function (): void {
    /** @var \Tests\TestCase $this */
    $user = $this->user;
    assert($user !== null);
    $user->update(['email_verified_at' => now()]);

    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.profile');
    $component->set('name', 'Test Name');
    $component->set('email', 'newemail@example.com');
    $component->call('updateProfileInformation');

    $user->refresh();
    expect($user->email_verified_at)->toBeNull();
});

it('sends verification email when requested', function (): void {
    /** @var \Tests\TestCase $this */
    $user = $this->user;
    assert($user !== null);
    $user->update(['email_verified_at' => null]);

    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.profile');
    $component->call('resendVerificationNotification');
    $component->assertRedirect(route('dashboard'));
});

it('redirects verified user when resending verification', function (): void {
    /** @var \Tests\TestCase $this */
    $user = $this->user;
    assert($user !== null);
    $user->update(['email_verified_at' => now()]);

    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.profile');
    $component->call('resendVerificationNotification');
    $component->assertRedirect(route('dashboard'));
});
