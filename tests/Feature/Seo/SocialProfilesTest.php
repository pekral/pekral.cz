<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Cache::flush();
    Http::fake([
        'api.github.com/*' => Http::response([], 200),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);
});

/**
 * The canonical profile URLs live in config/social.php. These tests fail if a
 * template reintroduces a hardcoded or outdated profile link.
 */
test('canonical social profile urls are configured', function (): void {
    expect(Config::string('social.website'))->toBe('https://pekral.cz');
    expect(Config::string('social.github'))->toBe('https://github.com/pekral');
    expect(Config::string('social.x'))->toBe('https://x.com/kral_petr_88');
    expect(Config::string('social.linkedin'))->toBe('https://cz.linkedin.com/in/petr-kral-88-php');
});

test('structured data exposes only the canonical profile urls', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee(Config::string('social.github'), escape: false);
    $response->assertSee(Config::string('social.linkedin'), escape: false);
    $response->assertSee(Config::string('social.x'), escape: false);
});

test('no page renders an outdated linkedin url', function (string $path): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get($path);
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertDontSee('petr-kral-60223752', escape: false);
    $response->assertDontSee('petr-kr%C3%A1l', escape: false);
    $response->assertDontSee('petr-král-60223752', escape: false);
})->with(['/', '/about', '/projects', '/blog']);
