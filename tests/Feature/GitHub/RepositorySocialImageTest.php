<?php

declare(strict_types = 1);

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Cache::flush();
    Storage::fake('local');
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'rector-rules',
                'description' => 'Curated Rector rule set',
                'html_url' => 'https://github.com/pekral/rector-rules',
                'language' => 'PHP',
            ],
        ], 200),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);
});

function socialPreviewPng(): string
{
    $image = imagecreatetruecolor(1_200, 600);
    $orange = imagecolorallocate($image, 240, 120, 30);
    assert($orange !== false);
    imagefill($image, 0, 0, $orange);
    ob_start();
    imagepng($image);
    $png = ob_get_clean();
    assert(is_string($png));

    return $png;
}

test('social image endpoint resizes the github preview to webp and reuses the stored file', function (): void {
    Http::fake([
        'opengraph.githubassets.com/*' => Http::response(socialPreviewPng(), 200, ['Content-Type' => 'image/png']),
    ]);

    /** @var \Tests\TestCase $this */
    $response = $this->get(route('projects.social-image', 'rector-rules'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'image/webp');
    $response->assertHeader('Cache-Control', 'max-age=14400, public');
    Storage::disk('local')->assertExists('github-social/rector-rules.webp');

    $stored = Storage::disk('local')->get('github-social/rector-rules.webp');
    assert(is_string($stored));
    $size = getimagesizefromstring($stored);
    assert(is_array($size));
    expect($size[0])->toBe(640)
        ->and($size[1])->toBe(320)
        ->and($size['mime'])->toBe('image/webp');

    /** @var \Tests\TestCase $this */
    $second = $this->get(route('projects.social-image', 'rector-rules'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $second */
    $second->assertSuccessful();
    Http::assertSentCount(4);
});

test('social image endpoint redirects to github when the preview cannot be fetched and remembers the failure', function (int $status, string $body): void {
    Http::fake([
        'opengraph.githubassets.com/*' => Http::response($body, $status),
    ]);

    /** @var \Tests\TestCase $this */
    $response = $this->get(route('projects.social-image', 'rector-rules'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertRedirect('https://opengraph.githubassets.com/pekral/pekral/rector-rules');

    /** @var \Tests\TestCase $this */
    $again = $this->get(route('projects.social-image', 'rector-rules'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $again */
    $again->assertRedirect();
    Http::assertSentCount(4);
})->with([
    'not an image' => [200, 'definitely not an image'],
    'rate limited' => [429, 'Too Many Requests'],
]);

test('social image endpoint does not become the previous url of the locale switch', function (): void {
    Http::fake([
        'opengraph.githubassets.com/*' => Http::response(socialPreviewPng(), 200, ['Content-Type' => 'image/png']),
    ]);

    /** @var \Tests\TestCase $this */
    $this->get('/about')->assertSuccessful();
    /** @var \Tests\TestCase $this */
    $this->get(route('projects.social-image', 'rector-rules'))->assertSuccessful();

    /** @var \Tests\TestCase $this */
    $response = $this->get('/locale/cs');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertRedirect(url('/about'));
});

test('social image endpoint returns 404 for an unknown repository without fetching anything', function (): void {
    Http::fake([
        'opengraph.githubassets.com/*' => Http::response(socialPreviewPng(), 200, ['Content-Type' => 'image/png']),
    ]);

    /** @var \Tests\TestCase $this */
    $response = $this->get(route('projects.social-image', 'unknown-repo'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertNotFound();
    Http::assertNotSent(static fn (Request $request): bool => str_contains($request->url(), 'opengraph.githubassets.com'));
    Storage::disk('local')->assertMissing('github-social/unknown-repo.webp');
});

test('social image endpoint redirects to github when the preview download times out', function (): void {
    Http::fake([
        'opengraph.githubassets.com/*' => Http::failedConnection('timeout'),
    ]);

    /** @var \Tests\TestCase $this */
    $response = $this->get(route('projects.social-image', 'rector-rules'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertRedirect('https://opengraph.githubassets.com/pekral/pekral/rector-rules');
});
