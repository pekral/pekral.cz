<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Cache::flush();
    Storage::fake('local');
});

test('company icon endpoint serves the live favicon of a company from the timeline and stores it for a month', function (): void {
    Http::fake([
        'www.google.com/s2/favicons*' => Http::response('png-bytes', 200, ['Content-Type' => 'image/png']),
    ]);

    /** @var \Tests\TestCase $this */
    $response = $this->get(route('company.icon', 'ecomail.cz'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'image/png');
    $response->assertHeader('Cache-Control', 'max-age=2592000, public');
    Storage::disk('local')->assertExists('company-icons/ecomail.cz.png');

    /** @var \Tests\TestCase $this */
    $this->get(route('company.icon', 'ecomail.cz'))->assertSuccessful();
    Http::assertSentCount(1);
});

test('company icon endpoint never fetches a host that is not on the timeline', function (): void {
    Http::fake();

    /** @var \Tests\TestCase $this */
    $response = $this->get(route('company.icon', 'evil.example'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'image/png');
    $response->assertHeader('Cache-Control', 'max-age=3600, public');
    Http::assertNothingSent();
    Storage::disk('local')->assertMissing('company-icons/evil.example.png');
});

test('company icon endpoint falls back to a transparent pixel and remembers a failed fetch', function (int $status, string $contentType): void {
    Http::fake([
        'www.google.com/s2/favicons*' => Http::response('nope', $status, ['Content-Type' => $contentType]),
    ]);

    /** @var \Tests\TestCase $this */
    $this->get(route('company.icon', 'www.slevomat.cz'))->assertSuccessful()->assertHeader('Cache-Control', 'max-age=3600, public');
    /** @var \Tests\TestCase $this */
    $this->get(route('company.icon', 'www.slevomat.cz'))->assertSuccessful();
    Http::assertSentCount(1);
    Storage::disk('local')->assertMissing('company-icons/www.slevomat.cz.png');
})->with([
    'not an image' => [200, 'text/html'],
    'server error' => [500, 'image/png'],
]);

test('about page timeline links each company favicon through the icon endpoint', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/about');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('src="' . route('company.icon', 'ecomail.cz') . '"', escape: false);
    $response->assertSee('src="' . route('company.icon', 'www.cis.cz') . '"', escape: false);
});
