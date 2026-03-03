@php
    $routeName = Route::currentRouteName() ?? 'default';
    $pageTitle = __('head.title.' . $routeName);
    $pageDescription = __('head.description.' . $routeName);
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

<link rel="canonical" href="{{ url()->current() }}">

<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:type" content="{{ Route::currentRouteName() === 'home' ? 'profile' : 'website' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="{{ __('head.meta.site_name') }}">
<meta property="og:locale" content="{{ app()->getLocale() === 'cs' ? 'cs_CZ' : 'en_US' }}">
<meta property="og:image" content="{{ asset('assets/profile-photo.jpg') }}">
<meta property="og:image:width" content="460">
<meta property="og:image:height" content="460">
<meta property="og:image:alt" content="{{ __('head.meta.image_alt') }}">
<meta property="og:image:type" content="image/jpeg">
<meta property="profile:first_name" content="Petr">
<meta property="profile:last_name" content="Kr?l">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@kral_petr_88">
<meta name="twitter:creator" content="@kral_petr_88">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ asset('assets/profile-photo.jpg') }}">
<meta name="twitter:image:alt" content="{{ __('head.meta.image_alt_short') }}">

<link rel="icon" type="image/svg+xml" href="/favicon.svg">
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link rel="dns-prefetch" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700|inter:400,500,600,700" rel="stylesheet" />

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
    'name' => 'Petr Kr?l',
    'givenName' => 'Petr',
    'familyName' => 'Kr?l',
    'jobTitle' => 'PHP Developer building with Laravel',
    'alternateName' => 'Senior PHP Programmer',
    'description' => 'Senior PHP programmer building projects with Laravel, with over 20 years of experience. Open source contributor specializing in backend development, REST APIs, and scalable web applications.',
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
        'addressRegion' => 'Kr?lov?hradeck? kraj',
        'addressCountry' => 'CZ'
    ],
    'nationality' => [
        '@context' => 'https://schema.org',
        '@type' => 'Country',
        'name' => 'Czech Republic'
    ],
    'sameAs' => [
        'https://github.com/pekral',
        'https://www.linkedin.com/in/petr-kr?l-60223752/',
        'https://x.com/kral_petr_88'
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
    'alumniOf' => [
        '@context' => 'https://schema.org',
        '@type' => 'EducationalOrganization',
        'name' => 'Self-taught Developer'
    ]
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

<!-- JSON-LD Structured Data - WebSite -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    '@id' => url('/') . '#website',
    'url' => url('/'),
    'name' => 'Petr Kr?l - Senior PHP Developer',
    'description' => 'Personal portfolio and blog of Petr Kr?l, Senior PHP Developer with 20+ years of experience.',
    'publisher' => [
        '@context' => 'https://schema.org',
        '@id' => url('/') . '#person'
    ],
    'inLanguage' => 'en-US'
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
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
    'inLanguage' => 'en-US'
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
