<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Cache::flush();
    Http::fake([
        'api.github.com/*' => Http::response([], 200),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);
});

/**
 * Guards the rendered <head> of every public page: no raw translation key may
 * leak into a title or meta description, in any supported locale.
 */

/**
 * @return array<int, string>
 */
function publicPaths(): array
{
    return ['/', '/about', '/skills', '/projects', '/blog', '/privacy-policy'];
}

test('blog index renders a localized title without a translation key', function (string $locale, string $expectedTitle): void {
    /** @var \Tests\TestCase $this */
    $response = $this->withSession(['locale' => $locale])->get('/blog');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee(sprintf('<title>%s</title>', $expectedTitle), escape: false);
    $response->assertDontSee('head.title.', escape: false);
    $response->assertDontSee('head.description.', escape: false);
})->with([
    ['en', 'Laravel, PHP and AI Articles | Petr Král'],
    ['cs', 'Články o Laravelu, PHP a AI | Petr Král'],
]);

test('public pages never render a raw translation key', function (string $locale): void {
    foreach (publicPaths() as $path) {
        /** @var \Tests\TestCase $this */
        $response = $this->withSession(['locale' => $locale])->get($path);
        /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
        $response->assertSuccessful();
        $response->assertDontSee('head.title.', escape: false);
        $response->assertDontSee('head.description.', escape: false);
        $response->assertDontSee('head.meta.', escape: false);

        // Livewire snapshots legitimately contain component names such as
        // "guest.footer", so only two-level translation keys are a leak.
        foreach (array_keys((array) require lang_path('en/guest.php')) as $section) {
            $response->assertDontSee(sprintf('guest.%s.', $section), escape: false);
        }
    }
})->with(['en', 'cs']);

test('every public page has a unique title and meta description', function (string $locale): void {
    $titles = [];
    $descriptions = [];

    foreach (publicPaths() as $path) {
        /** @var \Tests\TestCase $this */
        $response = $this->withSession(['locale' => $locale])->get($path);
        /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
        $html = $response->getContent();

        expect($html)->toBeString();
        /** @var string $html */
        expect(preg_match('~<title>(.*?)</title>~s', $html, $titleMatch))->toBe(1);
        expect(preg_match('~<meta name="description" content="(.*?)">~s', $html, $descriptionMatch))->toBe(1);

        $titles[$path] = $titleMatch[1] ?? '';
        $descriptions[$path] = $descriptionMatch[1] ?? '';
    }

    expect(array_unique($titles))->toHaveCount(count($titles));
    expect(array_unique($descriptions))->toHaveCount(count($descriptions));
})->with(['en', 'cs']);

test('structured data uses the current locale and correctly encoded name', function (string $locale, string $expectedLanguage): void {
    /** @var \Tests\TestCase $this */
    $response = $this->withSession(['locale' => $locale])->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee(sprintf('"inLanguage": "%s"', $expectedLanguage), escape: false);
    $response->assertSee('"name": "Petr Král"', escape: false);
    $response->assertDontSee('Kr?l', escape: false);
})->with([
    ['en', 'en-US'],
    ['cs', 'cs-CZ'],
]);
