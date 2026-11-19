<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Cache::flush();
    Storage::fake('local');
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
    Http::assertSentCount(1);
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
    Http::assertSentCount(1);
})->with([
    'not an image' => [200, 'definitely not an image'],
    'rate limited' => [429, 'Too Many Requests'],
]);
