<?php

declare(strict_types=1);

test('gdpr page loads successfully', function () {
    $response = $this->get('/gdpr');

    $response->assertStatus(200);
});

test('gdpr page contains title', function () {
    $response = $this->get('/gdpr');

    $response->assertSee('Zásady ochrany osobních údajů (GDPR)');
});

test('gdpr page contains contact information', function () {
    $response = $this->get('/gdpr');

    $response->assertSee('Petr Král');
    $response->assertSee('19326343');
    $response->assertSee('kral.petr.88 [at] gmail.com');
});

test('gdpr page contains required sections', function () {
    $response = $this->get('/gdpr');

    $response->assertSee('Správce osobních údajů');
    $response->assertSee('Jaké osobní údaje zpracováváme');
    $response->assertSee('Účel zpracování osobních údajů');
    $response->assertSee('Právní základ zpracování');
    $response->assertSee('Google Analytics');
    $response->assertSee('Doba uchovávání osobních údajů');
    $response->assertSee('Vaše práva');
    $response->assertSee('Kontakt');
});

test('gdpr page contains back link', function () {
    $response = $this->get('/gdpr');

    $response->assertSee('Zpět na hlavní stránku');
});
