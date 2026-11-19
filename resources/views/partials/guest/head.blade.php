@php
    $routeName = Route::currentRouteName() ?? 'default';
    $structuredDataLocale = app()->getLocale() === 'cs' ? 'cs-CZ' : 'en-US';
    $isArticle = $routeName === 'blog.show' && isset($article);
    $isProject = $routeName === 'projects.show' && isset($project);
    if ($isProject) {
        $pageTitle = __('head.title.project', ['name' => $project->name]);
        $pageDescription = filled($project->summary()) ? $project->summary() : __('head.description.project', ['name' => $project->name]);
        $pageImage = route('projects.social-image', $project->name);
    } elseif ($isArticle) {
        $pageTitle = $article->title . ' | ' . __('head.meta.site_name');
        $pageDescription = filled($article->description) ? $article->description : __('head.description.blog.show');
        $pageImage = $article->hasImage ? route('blog.image', $article->slug) : asset('assets/profile-photo.jpg');
    } else {
        $pageTitle = __('head.title.' . $routeName);
        $pageDescription = __('head.description.' . $routeName);
        $pageImage = asset('assets/profile-photo.jpg');
    }
    $breadcrumbs = [['name' => __('guest.nav.home'), 'url' => route('home')]];
    if ($isArticle) {
        $breadcrumbs[] = ['name' => __('guest.blog.title'), 'url' => route('blog.index')];
        $breadcrumbs[] = ['name' => $article->title, 'url' => url()->current()];
    } elseif ($isProject) {
        $breadcrumbs[] = ['name' => __('guest.nav.open_source_projects'), 'url' => route('projects')];
        $breadcrumbs[] = ['name' => $project->name, 'url' => url()->current()];
    } elseif ($routeName !== 'home') {
        $breadcrumbs[] = ['name' => $pageTitle, 'url' => url()->current()];
    }
@endphp

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
<meta name="author" content="{{ __('head.meta.author') }}">
<meta name="keywords" content="{{ __('head.meta.keywords') }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="language" content="{{ app()->getLocale() }}">
<meta name="geo.region" content="CZ">
<meta name="geo.placename" content="Chlumec nad Cidlinou">
<meta name="theme-color" content="#0b0d11">
<meta name="color-scheme" content="dark">

<link rel="canonical" href="{{ url()->current() }}">
<link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">
<link rel="alternate" type="application/rss+xml" title="{{ __('head.meta.site_name') }} - {{ __('guest.blog.title') }}" href="{{ route('feed') }}">

<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:type" content="{{ $isArticle ? 'article' : (Route::currentRouteName() === 'home' ? 'profile' : 'website') }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="{{ __('head.meta.site_name') }}">
<meta property="og:locale" content="{{ app()->getLocale() === 'cs' ? 'cs_CZ' : 'en_US' }}">
<meta property="og:image" content="{{ $pageImage }}">
@if($isProject)
<meta property="og:image:width" content="640">
<meta property="og:image:height" content="320">
@elseif(!$isArticle)
<meta property="og:image:width" content="460">
<meta property="og:image:height" content="460">
@endif
<meta property="og:image:alt" content="{{ $isArticle ? $article->title : ($isProject ? $project->name : __('head.meta.image_alt')) }}">
<meta property="og:image:type" content="{{ $isProject ? 'image/webp' : 'image/jpeg' }}">
@if($isArticle)
<meta property="article:published_time" content="{{ $article->date->toIso8601String() }}">
<meta property="article:author" content="{{ __('head.meta.author') }}">
@else
<meta property="profile:first_name" content="Petr">
<meta property="profile:last_name" content="Král">
@endif

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ '@' . basename((string) config('social.x')) }}">
<meta name="twitter:creator" content="{{ '@' . basename((string) config('social.x')) }}">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ $pageImage }}">
<meta name="twitter:image:alt" content="{{ __('head.meta.image_alt_short') }}">

<link rel="icon" type="image/svg+xml" href="/favicon.svg">
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link rel="dns-prefetch" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700|inter:400,500,600,700|instrument-serif:400i" rel="stylesheet" />

@if(Route::currentRouteName() === 'home')
<link rel="preload" href="{{ asset('assets/profile-photo.jpg') }}" as="image" type="image/jpeg">
@endif

@vite(['resources/css/fe.css'])

<!-- JSON-LD Structured Data - Person -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    '@id' => url('/') . '#person',
    'name' => 'Petr Král',
    'givenName' => 'Petr',
    'familyName' => 'Král',
    'jobTitle' => 'PHP Developer building with Laravel',
    'alternateName' => 'Senior PHP Programmer',
    'description' => 'Senior PHP programmer building projects with Laravel, with over 25 years of experience. Open source contributor specializing in backend development, REST APIs, and scalable web applications.',
    'url' => url('/'),
    'image' => [
        '@context' => 'https://schema.org',
        '@type' => 'ImageObject',
        'url' => asset('assets/profile-photo.jpg'),
        'width' => 460,
        'height' => 460
    ],
    'email' => 'mailto:kral.petr.88@gmail.com',
    'address' => [
        '@context' => 'https://schema.org',
        '@type' => 'PostalAddress',
        'addressLocality' => 'Chlumec nad Cidlinou',
        'addressRegion' => 'Královéhradecký kraj',
        'addressCountry' => 'CZ'
    ],
    'nationality' => [
        '@context' => 'https://schema.org',
        '@type' => 'Country',
        'name' => 'Czech Republic'
    ],
    'sameAs' => [
        config('social.github'),
        config('social.linkedin'),
        config('social.x'),
    ],
    'knowsAbout' => [
        'PHP Development',
        'Building applications with Laravel',
        'Open Source Software',
        'Backend Programming',
        'Symfony Framework',
        'REST API Development',
        'MySQL',
        'PostgreSQL',
        'Redis',
        'Docker',
        'Git',
        'Rector PHP',
        'AI-assisted development',
        'Agentic engineering',
        'Claude Code',
        'Automated code review',
        'Clean Code',
        'SOLID Principles',
        'Domain-Driven Design',
        'Test-Driven Development'
    ],
    'hasOccupation' => [
        '@context' => 'https://schema.org',
        '@type' => 'Occupation',
        'name' => 'PHP Developer building with Laravel',
        'description' => 'Senior PHP programmer building applications with Laravel and open source contributions',
        'occupationLocation' => [
            '@context' => 'https://schema.org',
            '@type' => 'Country',
            'name' => 'Czech Republic'
        ],
        'skills' => 'PHP, Laravel, Open Source, Symfony, REST API, MySQL, PostgreSQL, Docker, Git, Clean Code'
    ],
    'worksFor' => [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'ECOMAIL.CZ',
    ],
    'alumniOf' => [
        '@context' => 'https://schema.org',
        '@type' => 'EducationalOrganization',
        'name' => 'Self-taught Developer'
    ]
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP) !!}
</script>

<!-- JSON-LD Structured Data - WebSite -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    '@id' => url('/') . '#website',
    'url' => url('/'),
    'name' => 'Petr Král - Senior PHP Developer',
    'description' => 'Personal portfolio and blog of Petr Král, Senior PHP Developer with 25+ years of experience.',
    'publisher' => [
        '@context' => 'https://schema.org',
        '@id' => url('/') . '#person'
    ],
    'inLanguage' => $structuredDataLocale,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP) !!}
</script>

<!-- JSON-LD Structured Data - WebPage -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => url()->current() . '#webpage',
    'url' => url()->current(),
    'name' => $pageTitle,
    'description' => $pageDescription,
    'isPartOf' => [
        '@context' => 'https://schema.org',
        '@id' => url('/') . '#website'
    ],
    'about' => [
        '@context' => 'https://schema.org',
        '@id' => url('/') . '#person'
    ],
    'inLanguage' => $structuredDataLocale,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP) !!}
</script>

@if(count($breadcrumbs) > 1)
<!-- JSON-LD Structured Data - BreadcrumbList -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => collect($breadcrumbs)->map(static fn (array $crumb, int $index): array => [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $crumb['name'],
        'item' => $crumb['url'],
    ])->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP) !!}
</script>
@endif

@if($isArticle)
<!-- JSON-LD Structured Data - BlogPosting -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    '@id' => url()->current() . '#article',
    'headline' => $article->title,
    'description' => $pageDescription,
    'image' => $pageImage,
    'datePublished' => $article->date->toIso8601String(),
    'dateModified' => $article->date->toIso8601String(),
    'author' => ['@id' => url('/') . '#person'],
    'publisher' => ['@id' => url('/') . '#person'],
    'mainEntityOfPage' => ['@id' => url()->current() . '#webpage'],
    'url' => url()->current(),
    'inLanguage' => 'en',
    'timeRequired' => 'PT' . $article->readingTimeMinutes . 'M',
    'isPartOf' => ['@id' => url('/') . '#website'],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP) !!}
</script>
@endif

@if($isProject)
<!-- JSON-LD Structured Data - SoftwareSourceCode -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'SoftwareSourceCode',
    '@id' => url()->current() . '#software',
    'name' => $project->name,
    'description' => $pageDescription,
    'codeRepository' => $project->url,
    'programmingLanguage' => $project->language,
    'runtimePlatform' => $project->phpVersion !== '' ? 'PHP ' . $project->phpVersion : 'PHP',
    'keywords' => implode(', ', $project->topics),
    'license' => 'https://opensource.org/licenses/MIT',
    'author' => ['@id' => url('/') . '#person'],
    'maintainer' => ['@id' => url('/') . '#person'],
    'url' => url()->current(),
    'image' => $pageImage,
    'isPartOf' => ['@id' => url('/') . '#website'],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP) !!}
</script>
@endif
