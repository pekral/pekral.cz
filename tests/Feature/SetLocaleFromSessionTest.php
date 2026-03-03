<?php

declare(strict_types = 1);

test('sets app locale from session when valid locale in session', function (): void {
    $response = $this->withSession(['locale' => 'cs'])->get('/');

    $response->assertSuccessful();
    $response->assertSee('o mně', false);
});

test('sets app locale to en when session has en', function (): void {
    $response = $this->withSession(['locale' => 'en'])->get('/');

    $response->assertSuccessful();
    $response->assertSee('about');
});

test('does not set locale when session has unsupported value', function (): void {
    $response = $this->withSession(['locale' => 'de'])->get('/');

    $response->assertSuccessful();
    $response->assertSee('about');
});
