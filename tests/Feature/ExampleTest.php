<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Http::fake([
        'api.github.com/*' => Http::response([], 200),
    ]);
});

it('returns a successful response', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertStatus(200);
});
