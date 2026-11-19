<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Http::fake([
        'api.github.com/*' => Http::response([], 200),
    ]);
});

test('resolves the app locale from the session and falls back to english', function (string $sessionLocale, string $expectedText): void {
    /** @var \Tests\TestCase $this */
    $response = $this->withSession(['locale' => $sessionLocale])->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee($expectedText, escape: false);
})->with([
    'czech from session' => ['cs', 'o mně'],
    'english from session' => ['en', 'about'],
    'unsupported locale falls back to english' => ['de', 'about'],
]);
