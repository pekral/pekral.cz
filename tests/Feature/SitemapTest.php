<?php

declare(strict_types = 1);

test('sitemap returns valid xml response', function (): void {
    $response = $this->get('/sitemap.xml');

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
});

test('sitemap contains all public pages', function (): void {
    $response = $this->get('/sitemap.xml');

    $content = $response->getContent();

    expect($content)->toContain('<loc>' . url('/') . '</loc>');
    expect($content)->toContain('<loc>' . url('/about') . '</loc>');
    expect($content)->toContain('<loc>' . url('/skills') . '</loc>');
    expect($content)->toContain('<loc>' . url('/projects') . '</loc>');
    expect($content)->toContain('<loc>' . url('/privacy-policy') . '</loc>');
});

test('sitemap does not contain private pages', function (): void {
    $response = $this->get('/sitemap.xml');

    $response->assertDontSee('/dashboard');
    $response->assertDontSee('/settings');
    $response->assertDontSee('/livewire');
});

test('sitemap has valid xml structure', function (): void {
    $response = $this->get('/sitemap.xml');

    $content = $response->getContent();

    expect($content)->toContain('<?xml version="1.0" encoding="UTF-8"?>');
    expect($content)->toContain('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
    expect($content)->toContain('</urlset>');
});

test('sitemap entries contain required elements', function (): void {
    $response = $this->get('/sitemap.xml');

    $content = $response->getContent();

    expect($content)->toContain('<url>');
    expect($content)->toContain('<loc>');
    expect($content)->toContain('<lastmod>');
    expect($content)->toContain('<changefreq>');
    expect($content)->toContain('<priority>');
});

test('sitemap homepage has highest priority', function (): void {
    $response = $this->get('/sitemap.xml');

    $xml = simplexml_load_string($response->getContent());
    $homeUrl = $xml->url[0];

    expect((string) $homeUrl->loc)->toBe(url('/'));
    expect((string) $homeUrl->priority)->toBe('1.0');
});
