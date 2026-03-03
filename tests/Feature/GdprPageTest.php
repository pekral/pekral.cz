<?php

declare(strict_types = 1);

test('privacy policy page loads successfully', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/privacy-policy');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertStatus(200);
});

test('privacy policy page contains title', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/privacy-policy');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('Privacy Policy (GDPR)');
});

test('privacy policy page contains contact information', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/privacy-policy');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('Petr Král');
    $response->assertSee('19326343');
    $response->assertSee('kral.petr.88 [at] gmail.com');
});

test('privacy policy page contains required sections', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/privacy-policy');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('Data Controller');
    $response->assertSee('Personal Data We Process');
    $response->assertSee('Purpose of Personal Data Processing');
    $response->assertSee('Legal Basis for Processing');
    $response->assertSee('Google Analytics');
    $response->assertSee('Data Retention Period');
    $response->assertSee('Your Rights');
    $response->assertSee('Contact');
});

test('privacy policy page contains back link', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/privacy-policy');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSee('Back to homepage');
});
