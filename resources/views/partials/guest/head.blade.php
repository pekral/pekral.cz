<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Petr Král | PHP Developer</title>
<meta name="description" content="PHP developer passionate about clean code, automated refactoring with Rector, and building scalable web applications. Contributing to the PHP ecosystem.">
<meta name="author" content="Petr Král">
<meta name="keywords" content="PHP, Laravel, Developer, Clean Code, Rector, Web Development, Open Source">
<meta name="robots" content="index, follow">
<meta name="language" content="en">

<link rel="canonical" href="{{ url()->current() }}">

<meta property="og:title" content="Petr Král | PHP Developer">
<meta property="og:description" content="PHP developer passionate about clean code, automated refactoring with Rector, and building scalable web applications.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="Petr Král">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="{{ asset('assets/profile-photo.jpg') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Petr Král - PHP Developer">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Petr Král | PHP Developer">
<meta name="twitter:description" content="PHP developer passionate about clean code, automated refactoring with Rector, and building scalable web applications.">
<meta name="twitter:image" content="{{ asset('assets/profile-photo.jpg') }}">
<meta name="twitter:image:alt" content="Petr Král - PHP Developer">

<link rel="icon" type="image/svg+xml" href="/favicon.svg">
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700|inter:400,500,600,700" rel="stylesheet" />

@vite(['resources/css/fe.css'])

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => 'Petr Král',
    'jobTitle' => 'PHP Developer',
    'description' => 'PHP developer passionate about clean code, automated refactoring with Rector, and building scalable web applications.',
    'url' => url('/'),
    'image' => asset('assets/profile-photo.jpg'),
    'email' => 'petr@pekral.cz',
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Chlumec nad Cidlinou',
        'addressCountry' => 'CZ'
    ],
    'sameAs' => [
        'https://github.com/pekral',
        'https://www.linkedin.com/in/petr-král-60223752/',
        'https://x.com/kral_petr_88'
    ],
    'knowsAbout' => [
        'PHP',
        'Laravel',
        'Symfony',
        'Rector',
        'Clean Code',
        'SOLID',
        'DDD',
        'TDD'
    ]
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
