<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Support\Facades\URL;

it('verifies email and redirects to dashboard', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ],
    );

    /** @var \Tests\TestCase $this */
    $response = $this->actingAs($user)->get($verificationUrl);
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertRedirect(route('dashboard', absolute: false) . '?verified=1');
    $freshUser = $user->fresh();
    assert($freshUser !== null);
    expect($freshUser->hasVerifiedEmail())->toBeTrue();
});

it('redirects already verified user to dashboard', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ],
    );

    /** @var \Tests\TestCase $this */
    $response = $this->actingAs($user)->get($verificationUrl);
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertRedirect(route('dashboard', absolute: false) . '?verified=1');
});
