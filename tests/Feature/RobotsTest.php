<?php

declare(strict_types = 1);

test('robots returns valid text response', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/robots.txt');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
});

test('robots allows crawling of root', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/robots.txt');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('User-agent: *');
    $response->assertSee('Allow: /');
});

test('robots disallows private areas', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/robots.txt');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('Disallow: /dashboard');
    $response->assertSee('Disallow: /settings');
    $response->assertSee('Disallow: /livewire');
    $response->assertSee('Disallow: /verify-email');
});

test('robots contains sitemap reference', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/robots.txt');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('Sitemap: ' . url('/sitemap.xml'));
});

test('robots has noindex header to prevent indexing itself', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/robots.txt');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertHeader('X-Robots-Tag', 'noindex');
});
