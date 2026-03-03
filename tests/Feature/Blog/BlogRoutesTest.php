<?php

declare(strict_types = 1);

test('blog index page loads successfully', function (): void {
    $response = $this->get(route('blog.index'));

    $response->assertSuccessful();
    $response->assertSee('Blog');
    $response->assertSee('Back to home');
});

test('blog index lists articles', function (): void {
    $response = $this->get(route('blog.index'));

    $response->assertSee('Vibe coding with AI');
    $response->assertSee(route('blog.show', 'vibe-coding-with-ai-good-servant-bad-master'));
});

test('blog post page loads for existing slug', function (): void {
    $response = $this->get(route('blog.show', 'vibe-coding-with-ai-good-servant-bad-master'));

    $response->assertSuccessful();
    $response->assertSee('Vibe coding with AI');
    $response->assertSee('Back to blog');
    $response->assertSee('Copy link');
    $response->assertSee('workflow');
});

test('blog post returns 404 for non-existent slug', function (): void {
    $response = $this->get(route('blog.show', 'non-existent-article-xyz'));

    $response->assertNotFound();
});

test('blog image endpoint returns image for existing slug', function (): void {
    $response = $this->get(route('blog.image', 'vibe-coding-with-ai-good-servant-bad-master'));

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'image/jpeg');
});

test('blog image endpoint returns 404 for non-existent slug', function (): void {
    $response = $this->get(route('blog.image', 'non-existent-xyz'));

    $response->assertNotFound();
});

test('navigation includes blog link', function (): void {
    $response = $this->get('/');

    $response->assertSee('blog');
    $response->assertSee(route('blog.index'));
});
