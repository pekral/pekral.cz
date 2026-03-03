<?php

declare(strict_types = 1);

test('sitemap returns valid xml response', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/sitemap.xml');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
});

test('sitemap contains all public pages', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/sitemap.xml');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $content = $response->getContent();

    expect($content)->toContain('<loc>' . url('/') . '</loc>');
    expect($content)->toContain('<loc>' . url('/about') . '</loc>');
    expect($content)->toContain('<loc>' . url('/skills') . '</loc>');
    expect($content)->toContain('<loc>' . url('/projects') . '</loc>');
    expect($content)->toContain('<loc>' . url('/blog') . '</loc>');
    expect($content)->toContain('<loc>' . url('/privacy-policy') . '</loc>');
});

test('sitemap does not contain private pages', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/sitemap.xml');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertDontSee('/dashboard');
    $response->assertDontSee('/settings');
    $response->assertDontSee('/livewire');
});

test('sitemap has valid xml structure', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/sitemap.xml');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $content = $response->getContent();

    expect($content)->toContain('<?xml version="1.0" encoding="UTF-8"?>');
    expect($content)->toContain('urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"');
    expect($content)->toContain('xmlns:xhtml="http://www.w3.org/1999/xhtml"');
    expect($content)->toContain('</urlset>');
});

test('sitemap entries contain required elements', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/sitemap.xml');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $content = $response->getContent();

    expect($content)->toContain('<url>');
    expect($content)->toContain('<loc>');
    expect($content)->toContain('<lastmod>');
    expect($content)->toContain('<changefreq>');
    expect($content)->toContain('<priority>');
});

test('sitemap homepage has highest priority', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/sitemap.xml');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $content = $response->getContent();
    assert(is_string($content));
    $xml = simplexml_load_string($content);
    assert($xml !== false);
    $homeUrl = $xml->url[0];

    expect((string) $homeUrl->loc)->toBe(url('/'));
    expect((string) $homeUrl->priority)->toBe('1.0');
});
