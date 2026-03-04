<?php

use App\Actions\Blog\GetAllBlogArticlesAction;
use App\Actions\Blog\GetBlogArticleBySlugAction;
use App\Http\Controllers\BlogImageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome2');
})->name('home');

Route::get('/locale/{locale}', function (string $locale) {
    $supported = config('app.supported_locales', ['en', 'cs']);
    if (!in_array($locale, $supported, true)) {
        abort(400, 'Unsupported locale');
    }
    session()->put('locale', $locale);

    return redirect()->back();
})->name('locale.switch')->whereIn('locale', ['en', 'cs']);

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

Route::get('/blog', fn () => view('blog'))->name('blog.index');
Route::get('/blog/{slug}', function (string $slug, GetBlogArticleBySlugAction $getArticle) {
    $article = $getArticle->execute($slug);
    if ($article === null) {
        abort(404);
    }
    View::share('article', $article);

    return view('blog.show', ['slug' => $slug]);
})->name('blog.show');
Route::get('/blog/{slug}/image', [BlogImageController::class, 'show'])->name('blog.image');

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
    $supportedLocales = config('app.supported_locales', ['en', 'cs']);
    $defaultLocale = config('app.locale', 'en');

    $pages = [
        ['path' => '/', 'priority' => '1.0', 'changefreq' => 'monthly'],
        ['path' => '/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['path' => '/skills', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['path' => '/projects', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ['path' => '/blog', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ['path' => '/privacy-policy', 'priority' => '0.3', 'changefreq' => 'yearly'],
    ];

    $staticUrls = collect($pages)->map(function (array $page) use ($supportedLocales, $defaultLocale): array {
        $viewFile = match ($page['path']) {
            '/' => resource_path('views/welcome2.blade.php'),
            '/about' => resource_path('views/about.blade.php'),
            '/skills' => resource_path('views/skills.blade.php'),
            '/projects' => resource_path('views/projects.blade.php'),
            '/blog' => resource_path('views/blog.blade.php'),
            '/privacy-policy' => resource_path('views/gdpr-en.blade.php'),
            default => null,
        };

        $lastmod = $viewFile && file_exists($viewFile)
            ? date('Y-m-d', filemtime($viewFile))
            : now()->format('Y-m-d');

        $loc = url($page['path']);

        return [
            'loc' => $loc,
            'lastmod' => $lastmod,
            'changefreq' => $page['changefreq'],
            'priority' => $page['priority'],
            'alternates' => $supportedLocales,
            'default_locale' => $defaultLocale,
        ];
    });

    $getAllBlogArticles = app(GetAllBlogArticlesAction::class);
    $blogArticleUrls = $getAllBlogArticles->execute()->map(fn ($article): array => [
        'loc' => url('/blog/' . $article->slug),
        'lastmod' => $article->date->format('Y-m-d'),
        'changefreq' => 'monthly',
        'priority' => '0.8',
        'alternates' => $supportedLocales,
        'default_locale' => $defaultLocale,
    ])->all();

    $urls = array_merge($staticUrls->all(), $blogArticleUrls);

    $urlEntries = collect($urls)->map(function (array $url): string {
        $loc = $url['loc'];
        $locEscaped = e($loc);
        $defaultLocale = $url['default_locale'] ?? 'en';
        $alternates = $url['alternates'] ?? [];

        $alternateLinks = [];
        foreach ($alternates as $locale) {
            $alternateLinks[] = '<xhtml:link rel="alternate" hreflang="' . $locale . '" href="' . $locEscaped . '" />';
        }
        $alternateLinks[] = '<xhtml:link rel="alternate" hreflang="x-default" href="' . $locEscaped . '" />';

        $alternatesXml = $alternateLinks !== []
            ? "\n                " . implode("\n                ", $alternateLinks) . "\n            "
            : '';

        return <<<XML
            <url>
                <loc>{$loc}</loc>
                <lastmod>{$url['lastmod']}</lastmod>
                <changefreq>{$url['changefreq']}</changefreq>
                <priority>{$url['priority']}</priority>{$alternatesXml}
            </url>
        XML;
    })->implode("\n");

    $xml = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
        {$urlEntries}
        </urlset>
        XML;

    return response($xml, 200, [
        'Content-Type' => 'application/xml; charset=UTF-8',
        'X-Robots-Tag' => 'noindex',
    ]);
})->name('sitemap');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function (): void {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
