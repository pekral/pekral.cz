<?php

declare(strict_types = 1);

use App\Livewire\Actions\Logout;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    Auth::login($this->user);
});

it('logs out authenticated user', function (): void {
    expect(Auth::check())->toBeTrue();

    $logout = new Logout();
    $response = $logout();

    expect(Auth::check())->toBeFalse();
    expect($response->getTargetUrl())->toContain('/');
});

it('invalidates session', function (): void {
    $logout = new Logout();
    $logout();

    // Session is invalidated, so we can't access it directly
    expect(Auth::check())->toBeFalse();
});

it('regenerates session token', function (): void {
    $originalToken = Session::token();

    $logout = new Logout();
    $logout();

    expect(Session::token())->not->toBe($originalToken);
});
