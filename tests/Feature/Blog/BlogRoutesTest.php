<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Http::fake([
        'api.github.com/*' => Http::response([], 200),
    ]);
});

test('blog index page loads successfully', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('blog.index'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('Blog');
    $response->assertSee('Back to home');
});

test('blog index lists articles', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('blog.index'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('Vibe coding with AI');
    $response->assertSee(route('blog.show', 'vibe-coding-with-ai-good-servant-bad-master'));
});

test('blog index accepts page query parameter', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('blog.index') . '?page=1');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
});

test('blog post page loads for existing slug', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('blog.show', 'vibe-coding-with-ai-good-servant-bad-master'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('Vibe coding with AI');
    $response->assertSee('Back to blog');
    $response->assertSee('Copy link');
    $response->assertSee('workflow');
});

test('blog post returns 404 for non-existent slug', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('blog.show', 'non-existent-article-xyz'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertNotFound();
});

test('blog image endpoint returns image for existing slug', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('blog.image', 'vibe-coding-with-ai-good-servant-bad-master'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'image/jpeg');
});

test('blog image endpoint returns 404 for non-existent slug', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('blog.image', 'non-existent-xyz'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertNotFound();
});

test('navigation includes blog link', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('blog');
    $response->assertSee(route('blog.index'));
});

test('blog post page renders the article head tags and the table of contents', function (string $fragment): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('blog.show', 'vibe-coding-with-ai-good-servant-bad-master'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee($fragment, escape: false);
})->with([
    'title' => ['<title>Vibe coding with AI'],
    'open graph title' => ['og:title'],
    'table of contents heading' => ['Contents'],
    'table of contents link' => ['href="#it-starts-like-any-other-project"'],
]);
