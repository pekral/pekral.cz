<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome2');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/skills', function () {
    return view('skills');
})->name('skills');

Route::get('/projects', function () {
    return view('projects');
})->name('projects');

Route::view('gdpr', 'gdpr')->name('gdpr');

// Robots.txt
Route::get('robots.txt', function () {
    $robots = "User-agent: *\n";
    $robots .= "Allow: /\n\n";
    $robots .= "# Povolit indexování hlavních stránek\n";
    $robots .= "Allow: /\n";
    $robots .= "Allow: /about\n";
    $robots .= "Allow: /skills\n";
    $robots .= "Allow: /projects\n";
    $robots .= "Allow: /gdpr\n\n";
    $robots .= "# Zakázat indexování citlivých oblastí\n";
    $robots .= "Disallow: /dashboard\n";
    $robots .= "Disallow: /settings/\n";
    $robots .= "Disallow: /admin/\n";
    $robots .= "Disallow: /api/\n\n";
    $robots .= "# Zakázat indexování systémových souborů\n";
    $robots .= "Disallow: /storage/\n";
    $robots .= "Disallow: /vendor/\n";
    $robots .= "Disallow: /bootstrap/\n";
    $robots .= "Disallow: /config/\n";
    $robots .= "Disallow: /database/\n";
    $robots .= "Disallow: /resources/\n";
    $robots .= "Disallow: /tests/\n";
    $robots .= "Disallow: /*.env\n";
    $robots .= "Disallow: /*.log\n";
    $robots .= "Disallow: /*.sqlite\n\n";
    $robots .= "# Sitemap\n";
    $robots .= 'Sitemap: '.url('/sitemap.xml')."\n\n";
    $robots .= "# Crawl delay pro šetrné procházení\n";
    $robots .= "Crawl-delay: 1\n";

    return response($robots, 200, [
        'Content-Type' => 'text/plain',
    ]);
})->name('robots');

// Sitemap
Route::get('sitemap.xml', function () {
    $urls = [
        [
            'loc' => url('/'),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '1.0',
        ],
        [
            'loc' => url('/about'),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.8',
        ],
        [
            'loc' => url('/skills'),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.8',
        ],
        [
            'loc' => url('/projects'),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.8',
        ],
        [
            'loc' => url('/gdpr'),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'yearly',
            'priority' => '0.3',
        ],
    ];

    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

    foreach ($urls as $url) {
        $xml .= '  <url>'."\n";
        $xml .= '    <loc>'.htmlspecialchars($url['loc']).'</loc>'."\n";
        $xml .= '    <lastmod>'.$url['lastmod'].'</lastmod>'."\n";
        $xml .= '    <changefreq>'.$url['changefreq'].'</changefreq>'."\n";
        $xml .= '    <priority>'.$url['priority'].'</priority>'."\n";
        $xml .= '  </url>'."\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200, [
        'Content-Type' => 'application/xml',
    ]);
})->name('sitemap');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
