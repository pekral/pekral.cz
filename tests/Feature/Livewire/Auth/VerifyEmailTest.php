<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'email_verified_at' => null,
    ]);
});

it('renders verify email component for unverified user', function () {
    $this->actingAs($this->user);
    
    $response = $this->get(route('verification.notice'));
    
    $response->assertStatus(200);
    $response->assertSeeLivewire('auth.verify-email');
});

it('handles verified user correctly', function () {
    $this->user->update(['email_verified_at' => now()]);
    $this->actingAs($this->user);
    
    Livewire::test('auth.verify-email')
        ->call('sendVerification')
        ->assertHasNoErrors();
});

it('sends verification email', function () {
    $this->actingAs($this->user);
    Notification::fake();

    Livewire::test('auth.verify-email')
        ->call('sendVerification')
        ->assertHasNoErrors();
});

it('shows verification link sent message', function () {
    $this->actingAs($this->user);
    
    session(['status' => 'verification-link-sent']);

    Livewire::test('auth.verify-email')
        ->assertSee('A new verification link has been sent to the email address you provided during registration.');
});
