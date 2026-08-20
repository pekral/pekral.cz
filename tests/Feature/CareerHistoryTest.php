<?php

declare(strict_types = 1);

/**
 * The career history rendered on the site must match the public LinkedIn
 * profile: ECOMAIL.CZ is an ongoing role, and the self-employed work runs
 * alongside it rather than replacing it.
 */
test('ecomail role is described as ongoing in every locale', function (string $locale, string $expectedPeriod): void {
    app()->setLocale($locale);

    /** @var array<int, array{role: string, company: string, period: string, description: string}> $experiences */
    $experiences = __('guest.about.experiences');
    $ecomail = collect($experiences)->firstWhere('company', 'ECOMAIL.CZ');

    expect($ecomail)->not->toBeNull();
    /** @var array{role: string, company: string, period: string, description: string} $ecomail */
    expect($ecomail['period'])->toBe($expectedPeriod);
    expect($ecomail['role'])->toBe('Senior PHP Developer');
})->with([
    ['en', 'Jan 2018 – Present'],
    ['cs', 'leden 2018 – dosud'],
]);

test('career history never claims the unverified lead developer title', function (string $locale): void {
    app()->setLocale($locale);

    /** @var array<int, array{role: string, company: string, period: string, description: string}> $experiences */
    $experiences = __('guest.about.experiences');

    expect(collect($experiences)->pluck('role'))->not->toContain('PHP Lead Developer');
})->with(['en', 'cs']);

test('linkedin copy makes no unverified follower claims', function (string $locale): void {
    app()->setLocale($locale);

    /** @var string $copy */
    $copy = __('guest.about.connect_linkedin');

    expect($copy)->not->toMatch('~\d+\+~');
})->with(['en', 'cs']);
