<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
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

test('llms.txt describes the site, its pages and articles for ai agents', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/llms.txt');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
    $response->assertHeader('X-Robots-Tag', 'noindex');
    $response->assertSee('# Petr Král - pekral.cz');
    $response->assertSee('AI agents');
    $response->assertSee('](' . url('/projects') . ')');
    $response->assertSee('](' . url('/blog/vibe-coding-with-ai-good-servant-bad-master') . ')');
    $response->assertSee(Config::string('social.github'));
    $response->assertSee('](' . url('/projects/rector-rules') . '): Curated Rector rule set');
    $response->assertSee('Sitemap: ' . url('/sitemap.xml'));
    $response->assertSee('RSS feed: ' . url('/feed.xml'));
});

test('llms.txt follows the visitor locale', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->withSession(['locale' => 'cs'])->get('/llms.txt');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('AI agenty');
});
