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

Route::view('privacy-policy', 'gdpr-en')->name('privacy-policy');

Route::get('robots.txt', function () {
    $sitemapUrl = url('/sitemap.xml');

    $robots = <<<ROBOTS
        # robots.txt for pekral.cz

        User-agent: *
        Allow: /
        Disallow: /dashboard
        Disallow: /settings
        Disallow: /livewire
        Disallow: /verify-email

        # Sitemap location
        Sitemap: {$sitemapUrl}
        ROBOTS;

    return response($robots, 200, [
        'Content-Type' => 'text/plain; charset=UTF-8',
        'X-Robots-Tag' => 'noindex',
    ]);
})->name('robots');

Route::get('sitemap.xml', function () {
    $pages = [
        ['path' => '/', 'priority' => '1.0', 'changefreq' => 'monthly'],
        ['path' => '/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['path' => '/skills', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['path' => '/projects', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ['path' => '/privacy-policy', 'priority' => '0.3', 'changefreq' => 'yearly'],
    ];

    $urls = collect($pages)->map(function (array $page): array {
        $viewFile = match ($page['path']) {
            '/' => resource_path('views/welcome2.blade.php'),
            '/about' => resource_path('views/about.blade.php'),
            '/skills' => resource_path('views/skills.blade.php'),
            '/projects' => resource_path('views/projects.blade.php'),
            '/privacy-policy' => resource_path('views/gdpr-en.blade.php'),
            default => null,
        };

        $lastmod = $viewFile && file_exists($viewFile)
            ? date('Y-m-d', filemtime($viewFile))
            : now()->format('Y-m-d');

        return [
            'loc' => url($page['path']),
            'lastmod' => $lastmod,
            'changefreq' => $page['changefreq'],
            'priority' => $page['priority'],
        ];
    });

    $urlEntries = $urls->map(fn (array $url): string => <<<XML
            <url>
                <loc>{$url['loc']}</loc>
                <lastmod>{$url['lastmod']}</lastmod>
                <changefreq>{$url['changefreq']}</changefreq>
                <priority>{$url['priority']}</priority>
            </url>
        XML)->implode("\n");

    $xml = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        {$urlEntries}
        </urlset>
        XML;

    return response($xml, 200, [
        'Content-Type' => 'application/xml; charset=UTF-8',
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
