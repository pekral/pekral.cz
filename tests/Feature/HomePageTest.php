<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Cache::flush();
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'ai-olympus',
                'description' => 'Agentic AI framework for Laravel',
                'html_url' => 'https://github.com/pekral/ai-olympus',
                'language' => 'PHP',
                'stargazers_count' => 1,
                'topics' => ['claude-code'],
            ],
        ], 200),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);
});

test('homepage loads successfully', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertStatus(200);
});

test('homepage contains person section', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('Petr Král');
    $response->assertSee('PHP Developer');
    $response->assertSee('Chlumec nad Cidlinou, Czech Republic');
});

test('homepage contains navigation', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('pekral');
    $response->assertSee('about');
    $response->assertSee('skills');
    $response->assertSee('projects');
    $response->assertSee('contact');
});

test('homepage contains footer', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('Petr Král');
    $response->assertSee('PHP Developer');
});

test('homepage contains sitemap link in head', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('<link rel="sitemap" type="application/xml" title="Sitemap" href="' . url('/sitemap.xml') . '">', escape: false);
});

test('homepage shows latest from the blog section when articles exist', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('Latest from the blog');
    $response->assertSee('View all articles');
    $response->assertSee(route('blog.index'));
});

test('homepage shows at most three latest articles with links', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee(route('blog.show', 'cursor-editor-ai-productivity-developer'));
    $response->assertSee(route('blog.show', 'vibe-coding-with-ai-good-servant-bad-master'));
    $response->assertSee('Cursor Editor for developers');
    $response->assertSee('Vibe coding with AI');
});

test('homepage contains contact section with id and CTA', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('id="contact"', escape: false);
    $response->assertSee('Contact', escape: false);
    $response->assertSee(route('home') . '#contact', escape: false);
});

test('homepage shows the open source repositories loaded from github', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('Open Source PHP Projects');
    $response->assertSee('ai-olympus');
    $response->assertSee('Agentic AI framework for Laravel');
    $response->assertSee('href="https://github.com/pekral/ai-olympus"', escape: false);
});

test('homepage presents the laravel and ai agents positioning', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('built with AI agents.');
    $response->assertSee('How I work');
    $response->assertSee('Agentic AI workflow');
    $response->assertSee('Waiting for human approval');
});
