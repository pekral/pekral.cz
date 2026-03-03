<?php

declare(strict_types = 1);

test('sets app locale from session when valid locale in session', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->withSession(['locale' => 'cs'])->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('o mně', false);
});

test('sets app locale to en when session has en', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->withSession(['locale' => 'en'])->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('about');
});

test('does not set locale when session has unsupported value', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->withSession(['locale' => 'de'])->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('about');
});
