<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PHP & Laravel vývojář – 20+ let zkušeností | Enterprise projekty | Petr Král</title>
<meta name="description" content="Vývoj moderních webových aplikací v PHP a Laravelu. 20+ let zkušeností, enterprise projekty, čistý kód, výkonná API, optimalizace databází. SaaS řešení a webové prezentace.">
<meta name="author" content="Petr Král">
<meta name="keywords" content="PHP, Laravel, vývoj webových aplikací, enterprise projekty, čistý kód, optimalizace kódu, API, databáze, optimalizace databází, SaaS, webové prezentace">
<meta name="robots" content="index, follow">
<meta name="language" content="cs">

<link rel="canonical" href="{{ url()->current() }}">

<meta property="og:title" content="PHP & Laravel vývojář – 20+ let zkušeností | Enterprise projekty">
<meta property="og:description" content="Vývoj moderních webových aplikací v PHP a Laravelu. 20+ let zkušeností, enterprise projekty, čistý kód, výkonná API, optimalizace databází. SaaS řešení a webové prezentace.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="Petr Král - PHP & Laravel Developer">
<meta property="og:locale" content="cs_CZ">
<meta property="og:image" content="{{ asset('assets/profile.jpg') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Petr Král - PHP/Laravel Developer">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="PHP & Laravel vývojář – 20+ let zkušeností | Enterprise projekty">
<meta name="twitter:description" content="Vývoj moderních webových aplikací v PHP a Laravelu. 20+ let zkušeností, enterprise projekty, čistý kód, výkonná API, optimalizace databází.">
<meta name="twitter:image" content="{{ asset('assets/profile.jpg') }}">
<meta name="twitter:image:alt" content="Petr Král - PHP/Laravel Developer">

<link rel="icon" type="image/svg+xml" href="/favicon.svg">
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link rel="preconnect" href="https://www.google-analytics.com">
<link rel="preconnect" href="https://www.googletagmanager.com">

@vite(['resources/css/fe.css'])

<!-- Google Analytics 4 - načítá se pouze po souhlasu s cookies -->
<script>
    // Funkce pro načtení Google Analytics po souhlasu s cookies
    function loadGoogleAnalytics() {
        // Google Analytics 4
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-5Y5XCMQSTB', {
            'anonymize_ip': true,
            'cookie_flags': 'SameSite=None;Secure'
        });
        
        // Načtení GA4 scriptu
        const script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=G-5Y5XCMQSTB';
        document.head.appendChild(script);
    }

    // Načtení GA po souhlasu s cookies
    document.addEventListener('DOMContentLoaded', function() {
        // Zkontrolovat, zda uživatel již souhlasil s cookies
        if (document.cookie.indexOf('laravel_cookie_consent=1') !== -1) {
            loadGoogleAnalytics();
        }
        
        // Poslouchat událost souhlasu s cookies
        document.addEventListener('cookie-consent-agreed', function() {
            loadGoogleAnalytics();
        });
    });
</script>

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => 'Petr Král',
    'jobTitle' => 'PHP/Laravel Developer',
    'description' => 'PHP/Laravel Developer s 20+ let zkušeností v enterprise projektech. Specializuji se na čistý kód, výkonnost, škálovatelnost, DevOps automatizaci a komplexní integrační řešení.',
    'url' => url('/'),
    'image' => asset('assets/profile.jpg'),
    'email' => 'kral.petr.88@gmail.com',
    'telephone' => '+420733382412',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'Družstevní 709',
        'addressLocality' => 'Chlumec nad Cidlinou',
        'postalCode' => '503 51',
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
        'MySQL',
        'DynamoDB',
        'Redis',
        'API Development',
        'Enterprise Software',
        'DevOps',
        'Database Design',
        'Web Development',
        'SaaS Solutions'
    ],
    'hasOccupation' => [
        '@type' => 'Occupation',
        'name' => 'PHP/Laravel Developer',
        'description' => 'Vývoj moderních webových aplikací v PHP a Laravelu s důrazem na čistý kód, výkonnost a škálovatelnost enterprise aplikací.'
    ],
    'alumniOf' => [
        '@type' => 'Organization',
        'name' => '20+ let zkušeností v IT'
    ]
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
