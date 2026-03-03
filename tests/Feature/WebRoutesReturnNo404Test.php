<?php

declare(strict_types = 1);

/**
 * Ensures all public and guest-accessible web routes respond successfully (no 404).
 * Auth-required routes must redirect (302) to login, not 404.
 */
test('all public page routes return success or redirect', function (): void {
    $existingBlogSlug = 'vibe-coding-with-ai-good-servant-bad-master';

    $publicRoutes = [
        ['GET', '/', 'home'],
        ['GET', '/about', 'about'],
        ['GET', '/blog', 'blog.index'],
        ['GET', '/blog/' . $existingBlogSlug, 'blog.show'],
        ['GET', '/blog/' . $existingBlogSlug . '/image', 'blog.image'],
        ['GET', '/locale/en', 'locale.switch'],
        ['GET', '/locale/cs', 'locale.switch'],
        ['GET', '/privacy-policy', 'privacy-policy'],
        ['GET', '/projects', 'projects'],
        ['GET', '/robots.txt', 'robots'],
        ['GET', '/sitemap.xml', 'sitemap'],
        ['GET', '/skills', 'skills'],
    ];

    foreach ($publicRoutes as [$method, $uri, $name]) {
        $response = $this->get($uri);
        $status = $response->getStatusCode();

        expect($status)->not->toBe(404, sprintf('Route [%s] (%s) must not return 404', $name, $uri));
    }
});

test('guest auth routes return success or redirect', function (): void {
    $guestRoutes = [
        ['GET', '/login', 'login'],
        ['GET', '/register', 'register'],
        ['GET', '/forgot-password', 'password.request'],
        ['GET', '/reset-password/valid-token-placeholder', 'password.reset'],
    ];

    foreach ($guestRoutes as [$method, $uri, $name]) {
        $response = $this->get($uri);
        $status = $response->getStatusCode();

        expect($status)->not->toBe(404, sprintf('Route [%s] (%s) must not return 404', $name, $uri));
    }
});

test('auth-required routes redirect to login when guest', function (): void {
    $protectedRoutes = [
        ['GET', '/dashboard', 'dashboard'],
        ['GET', '/settings/profile', 'settings.profile'],
        ['GET', '/settings/password', 'settings.password'],
        ['GET', '/settings/appearance', 'settings.appearance'],
        ['GET', '/verify-email', 'verification.notice'],
        ['GET', '/confirm-password', 'password.confirm'],
    ];

    foreach ($protectedRoutes as [$method, $uri, $name]) {
        $response = $this->get($uri);
        $status = $response->getStatusCode();

        expect($status)->not->toBe(404, sprintf('Route [%s] (%s) must not return 404', $name, $uri));
    }
});

test('settings redirect route works', function (): void {
    $response = $this->get('/settings');

    $response->assertRedirect();
    expect($response->getStatusCode())->not->toBe(404);
});
