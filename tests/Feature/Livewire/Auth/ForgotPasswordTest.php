<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
    ]);
});

it('renders forgot password component', function () {
    $response = $this->get(route('password.request'));
    
    $response->assertStatus(200);
    $response->assertSeeLivewire('auth.forgot-password');
});

it('sends password reset link for valid email', function () {
    Notification::fake();

    Livewire::test('auth.forgot-password')
        ->set('email', 'test@example.com')
        ->call('sendPasswordResetLink')
        ->assertHasNoErrors();
});

it('validates required email field', function () {
    Livewire::test('auth.forgot-password')
        ->set('email', '')
        ->call('sendPasswordResetLink')
        ->assertHasErrors(['email' => 'required']);
});

it('validates email format', function () {
    Livewire::test('auth.forgot-password')
        ->set('email', 'invalid-email')
        ->call('sendPasswordResetLink')
        ->assertHasErrors(['email' => 'email']);
});

it('handles non-existent email gracefully', function () {
    Livewire::test('auth.forgot-password')
        ->set('email', 'nonexistent@example.com')
        ->call('sendPasswordResetLink')
        ->assertHasNoErrors();
});
