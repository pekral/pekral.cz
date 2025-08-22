<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders delete user form component', function () {
    $response = $this->get(route('settings.profile'));
    
    $response->assertStatus(200);
    $response->assertSeeLivewire('settings.delete-user-form');
});

it('deletes user account with valid password', function () {
    $this->user->update(['password' => bcrypt('password123')]);

    Livewire::test('settings.delete-user-form')
        ->set('password', 'password123')
        ->call('deleteUser')
        ->assertHasNoErrors()
        ->assertRedirect('/');

    expect(Auth::check())->toBeFalse();
    expect(User::find($this->user->id))->toBeNull();
});

it('validates required password field', function () {
    Livewire::test('settings.delete-user-form')
        ->set('password', '')
        ->call('deleteUser')
        ->assertHasErrors(['password' => 'required']);
});

it('fails with invalid password', function () {
    $this->user->update(['password' => bcrypt('password123')]);

    Livewire::test('settings.delete-user-form')
        ->set('password', 'wrongpassword')
        ->call('deleteUser')
        ->assertHasErrors(['password' => 'current_password']);
});


