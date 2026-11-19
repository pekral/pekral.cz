<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Http::fake([
        'api.github.com/*' => Http::response([], 200),
    ]);
});

test('blog article page carries blog posting structured data and article open graph tags', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/blog/vibe-coding-with-ai-good-servant-bad-master');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('"@type": "BlogPosting"', escape: false);
    $response->assertSee('"datePublished": "2026-02-04', escape: false);
    $response->assertSee('"timeRequired": "PT', escape: false);
    $response->assertSee('<meta property="og:type" content="article">', escape: false);
    $response->assertSee('<meta property="article:published_time"', escape: false);
    $response->assertSee('<meta property="og:image" content="' . route('blog.image', 'vibe-coding-with-ai-good-servant-bad-master') . '">', escape: false);
    $response->assertSee('"@type": "BreadcrumbList"', escape: false);
    $response->assertSee('"position": 3', escape: false);
});

test('inner pages carry a breadcrumb list and the homepage does not', function (): void {
    /** @var \Tests\TestCase $this */
    $about = $this->get('/about');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $about */
    $about->assertSuccessful();
    $about->assertSee('"@type": "BreadcrumbList"', escape: false);
    $about->assertSee('"position": 2', escape: false);

    /** @var \Tests\TestCase $this */
    $home = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $home */
    $home->assertSuccessful();
    $home->assertDontSee('BreadcrumbList', escape: false);
    $home->assertSee('<meta property="og:type" content="profile">', escape: false);
    $home->assertSee('"worksFor"', escape: false);
    $home->assertSee('"Agentic engineering"', escape: false);
});
