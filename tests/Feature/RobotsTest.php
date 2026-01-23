<?php

declare(strict_types=1);

test('robots returns valid text response', function (): void {
    $response = $this->get('/robots.txt');

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
});

test('robots allows crawling of root', function (): void {
    $response = $this->get('/robots.txt');

    $response->assertSee('User-agent: *');
    $response->assertSee('Allow: /');
});

test('robots disallows private areas', function (): void {
    $response = $this->get('/robots.txt');

    $response->assertSee('Disallow: /dashboard');
    $response->assertSee('Disallow: /settings');
    $response->assertSee('Disallow: /livewire');
    $response->assertSee('Disallow: /verify-email');
});

test('robots contains sitemap reference', function (): void {
    $response = $this->get('/robots.txt');

    $response->assertSee('Sitemap: '.url('/sitemap.xml'));
});

test('robots has noindex header to prevent indexing itself', function (): void {
    $response = $this->get('/robots.txt');

    $response->assertHeader('X-Robots-Tag', 'noindex');
});
