<?php

use App\Actions\Blog\GetAllBlogArticlesAction;
use App\Actions\Blog\GetBlogArticleBySlugAction;
use App\Http\Controllers\BlogImageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
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
            '/' => resource_path('views/welcome.blade.php'),
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

Route::get('feed.xml', function (GetAllBlogArticlesAction $getAllBlogArticles) {
    $articles = $getAllBlogArticles->execute();
    $siteName = __('head.meta.site_name');
    $blogUrl = url('/blog');
    $feedUrl = url('/feed.xml');
    $feedDescription = e(__('head.description.blog.index'));
    $lastBuildDate = ($articles->first()?->date ?? now(config('app.timezone')))->toRfc2822String();

    $items = $articles->map(static function ($article): string {
        $articleUrl = url('/blog/' . $article->slug);
        $title = e($article->title);
        $description = e($article->description);
        $pubDate = $article->date->toRfc2822String();
        $enclosure = $article->hasImage
            ? sprintf('<enclosure url="%s" type="image/jpeg" length="0" />', e(url('/blog/' . $article->slug . '/image')))
            : '';

        return <<<XML
                <item>
                    <title>{$title}</title>
                    <link>{$articleUrl}</link>
                    <guid isPermaLink="true">{$articleUrl}</guid>
                    <pubDate>{$pubDate}</pubDate>
                    <description>{$description}</description>
                    {$enclosure}
                </item>
            XML;
    })->implode("\n");

    $xml = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
            <channel>
                <title>{$siteName} - Blog</title>
                <link>{$blogUrl}</link>
                <atom:link href="{$feedUrl}" rel="self" type="application/rss+xml" />
                <description>{$feedDescription}</description>
                <language>en</language>
                <lastBuildDate>{$lastBuildDate}</lastBuildDate>
        {$items}
            </channel>
        </rss>
        XML;

    return response($xml, 200, [
        'Content-Type' => 'application/rss+xml; charset=UTF-8',
        'X-Robots-Tag' => 'noindex',
    ]);
})->name('feed');

Route::get('llms.txt', function (GetAllBlogArticlesAction $getAllBlogArticles) {
    $pages = collect([
        ['/', 'head.title.home', 'head.description.home'],
        ['/about', 'head.title.about', 'head.description.about'],
        ['/skills', 'head.title.skills', 'head.description.skills'],
        ['/projects', 'head.title.projects', 'head.description.projects'],
        ['/blog', 'head.title.blog.index', 'head.description.blog.index'],
    ])->map(static fn (array $page): string => sprintf('- [%s](%s): %s', __($page[1]), url($page[0]), __($page[2])))->implode("\n");

    $articles = $getAllBlogArticles->execute()
        ->map(static fn ($article): string => sprintf('- [%s](%s): %s', $article->title, url('/blog/' . $article->slug), $article->description))
        ->implode("\n");

    $github = config('social.github');
    $linkedin = config('social.linkedin');
    $description = __('head.description.home');
    $sitemapUrl = url('/sitemap.xml');
    $feedUrl = url('/feed.xml');

    $text = <<<MARKDOWN
        # Petr Král - pekral.cz

        > {$description}

        ## Pages

        {$pages}

        ## Blog articles (English)

        {$articles}

        ## Open source

        - [GitHub profile]({$github}): Laravel packages, Rector rules, PHPCS rules, Claude Code and Codex agent skills (ai-olympus, cursor-rules, test-redundancy, github-readme-generator).
        - [LinkedIn]({$linkedin})

        ## Machine-readable resources

        - Sitemap: {$sitemapUrl}
        - RSS feed: {$feedUrl}
        MARKDOWN;

    return response($text, 200, [
        'Content-Type' => 'text/markdown; charset=UTF-8',
        'X-Robots-Tag' => 'noindex',
    ]);
})->name('llms');

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

// Runs inside the "web" group so the 404 page is rendered in the visitor's locale.
Route::fallback(fn () => response()->view('errors.404', [], 404));
