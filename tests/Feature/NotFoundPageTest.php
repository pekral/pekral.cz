<?php

declare(strict_types = 1);

test('unknown url returns the custom 404 page', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/this-page-does-not-exist');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertNotFound();
    $response->assertSee(__('errors.404.heading'));
});

test('the 404 page respects the current locale', function (string $locale, string $expectedHeading): void {
    /** @var \Tests\TestCase $this */
    $response = $this->withSession(['locale' => $locale])->get('/this-page-does-not-exist');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertNotFound();
    $response->assertSee($expectedHeading);
    $response->assertSee(sprintf('<html lang="%s">', $locale), escape: false);
})->with([
    ['en', 'Page not found'],
    ['cs', 'Stránka nenalezena'],
]);
