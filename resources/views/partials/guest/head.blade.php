@php
    $pageTitle = match(Route::currentRouteName()) {
        'home' => 'Petr Král | PHP & Laravel Developer | Open Source Programmer',
        'about' => 'About Petr Král | Senior PHP Developer & Laravel Programmer',
        'skills' => 'PHP Developer Skills | Laravel, Symfony, Open Source | Petr Král',
        'projects' => 'Open Source PHP Projects | Laravel Developer Petr Král',
        'gdpr' => 'Privacy Policy | Petr Král - PHP Developer',
        default => 'Petr Král | PHP & Laravel Developer'
    };

    $pageDescription = match(Route::currentRouteName()) {
        'home' => 'Petr Král is a Senior PHP Developer and Laravel programmer with 20+ years of experience. Specializing in Laravel development, PHP backend programming, and open source contributions. Building scalable web applications and APIs.',
        'about' => 'Meet Petr Král - a passionate PHP developer and Laravel programmer with over 20 years of experience. Open source contributor, backend architect, and advocate for clean code practices.',
        'skills' => 'Technical skills of Petr Král, PHP developer: Laravel, Symfony, PHP 8, REST API development, MySQL, PostgreSQL, Docker. Experienced programmer focused on open source and best practices.',
        'projects' => 'Open source PHP projects by developer Petr Král. Laravel applications, PHP libraries, Rector rules, and developer tools. Active contributor to the PHP and open source community.',
        'gdpr' => 'Privacy policy for the portfolio website of Petr Král, Senior PHP Developer and Laravel programmer.',
        default => 'Petr Král - Senior PHP Developer and Laravel programmer specializing in open source, API development, and scalable backend solutions.'
    };
@endphp

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
<meta name="author" content="Petr Král">
<meta name="keywords" content="Petr Král, PHP Developer, Laravel Developer, PHP Programmer, Open Source, Senior Developer, Backend Programmer, Symfony, REST API, Clean Code, Rector, Web Development, Czech Republic">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="language" content="en">
<meta name="geo.region" content="CZ">
<meta name="geo.placename" content="Chlumec nad Cidlinou">

<link rel="canonical" href="{{ url()->current() }}">

<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:type" content="{{ Route::currentRouteName() === 'home' ? 'profile' : 'website' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="Petr Král - Senior PHP Developer">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="{{ asset('assets/profile-photo.jpg') }}">
<meta property="og:image:width" content="460">
<meta property="og:image:height" content="460">
<meta property="og:image:alt" content="Petr Král - Senior PHP Developer specializing in Laravel and API development">
<meta property="og:image:type" content="image/jpeg">
<meta property="profile:first_name" content="Petr">
<meta property="profile:last_name" content="Král">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@kral_petr_88">
<meta name="twitter:creator" content="@kral_petr_88">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ asset('assets/profile-photo.jpg') }}">
<meta name="twitter:image:alt" content="Petr Král - Senior PHP Developer">

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
    'name' => 'Petr Král',
    'givenName' => 'Petr',
    'familyName' => 'Král',
    'jobTitle' => 'PHP & Laravel Developer',
    'alternateName' => 'Senior PHP Programmer',
    'description' => 'Senior PHP programmer and Laravel developer with over 20 years of experience. Open source contributor specializing in backend development, REST APIs, and scalable web applications.',
    'url' => url('/'),
    'image' => [
        '@type' => 'ImageObject',
        'url' => asset('assets/profile-photo.jpg'),
        'width' => 460,
        'height' => 460
    ],
    'email' => 'mailto:kral.petr.88@gmail.com',
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Chlumec nad Cidlinou',
        'addressRegion' => 'Královéhradecký kraj',
        'addressCountry' => 'CZ'
    ],
    'nationality' => [
        '@type' => 'Country',
        'name' => 'Czech Republic'
    ],
    'sameAs' => [
        'https://github.com/pekral',
        'https://www.linkedin.com/in/petr-král-60223752/',
        'https://x.com/kral_petr_88'
    ],
    'knowsAbout' => [
        'PHP Development',
        'Laravel Framework',
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
        '@type' => 'Occupation',
        'name' => 'PHP & Laravel Developer',
        'description' => 'Senior PHP programmer specializing in Laravel development and open source contributions',
        'occupationLocation' => [
            '@type' => 'Country',
            'name' => 'Czech Republic'
        ],
        'skills' => 'PHP, Laravel, Open Source, Symfony, REST API, MySQL, PostgreSQL, Docker, Git, Clean Code'
    ],
    'alumniOf' => [
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
    'name' => 'Petr Král - Senior PHP Developer',
    'description' => 'Personal portfolio and blog of Petr Král, Senior PHP Developer with 20+ years of experience.',
    'publisher' => [
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
        '@id' => url('/') . '#website'
    ],
    'about' => [
        '@id' => url('/') . '#person'
    ],
    'inLanguage' => 'en-US'
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
