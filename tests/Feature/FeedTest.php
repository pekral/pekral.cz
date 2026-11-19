<?php

declare(strict_types = 1);

test('rss feed lists every blog article with its permalink', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/feed.xml');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');
    $response->assertHeader('X-Robots-Tag', 'noindex');
    $response->assertSee('<rss version="2.0"', escape: false);
    $response->assertSee('<atom:link href="' . url('/feed.xml') . '" rel="self"', escape: false);
    $response->assertSee('<guid isPermaLink="true">' . url('/blog/vibe-coding-with-ai-good-servant-bad-master') . '</guid>', escape: false);
    $response->assertSee('<enclosure url="' . url('/blog/vibe-coding-with-ai-good-servant-bad-master/image') . '"', escape: false);
    $response->assertSee('Vibe coding with AI');

    $content = $response->getContent();
    assert(is_string($content));
    $xml = simplexml_load_string($content);
    assert($xml !== false);
    expect($xml->channel->item)->toHaveCount(3);
});

test('guest pages link the rss feed in the head', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/blog');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('<link rel="alternate" type="application/rss+xml"', escape: false);
    $response->assertSee('href="' . route('feed') . '"', escape: false);
});
