<?php

declare(strict_types=1);

test('homepage loads successfully', function (): void {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('homepage contains person section', function (): void {
    $response = $this->get('/');

    $response->assertSee('Petr Král');
    $response->assertSee('PHP Developer');
    $response->assertSee('Chlumec nad Cidlinou, Czech Republic');
});

test('homepage contains navigation', function (): void {
    $response = $this->get('/');

    $response->assertSee('pekral');
    $response->assertSee('about');
    $response->assertSee('skills');
    $response->assertSee('projects');
    $response->assertSee('contact');
});

test('homepage contains footer', function (): void {
    $response = $this->get('/');

    $response->assertSee('Petr Král');
    $response->assertSee('PHP Developer');
});
