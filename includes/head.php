<?php
/**
 * includes/head.php — doctype, <head>, meta, OG, schema, CSS, preloads; opens <body>.
 *
 * Pages set, before including this file:
 *   $pageTitle, $pageDescription, $canonicalUrl (absolute, trailing slash on directories)
 *   $pageType ('home'|'service'|'city'|'blog'|'about'|'faq'|'contact'|'other'), plus
 *   $serviceSlug / $citySlug where they apply
 * Optional: $ogImage (site-relative or absolute), $ogType, $noindex (true on thank-you),
 *   $schemaMarkup (JSON string or array — page-specific JSON-LD, never FAQPage),
 *   $heroPreload = ['srcset' => '...-480.avif 480w, ...', 'sizes' => '100vw'],
 *   $headExtra (raw markup appended inside <head>).
 * Missing values fall back to sitewide defaults, and the canonical falls back to
 * the request URI, so a page can never ship without them.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$headCity  = $address['city'];
$headState = $address['state'];

$pageTitle = $pageTitle ?? ($siteName . ' | ' . ucwords(strtolower($primaryKeyword)) . ' in ' . $headCity . ', ' . $headState);
$pageDescription = $pageDescription ?? ('Electrical repair services in ' . $headCity . ', ' . $headState . ' from ' . $siteName
    . ': wiring, panel upgrades, lighting and EV chargers. In business since ' . $yearEstablished . '. Call ' . $phone . '.');
$canonicalUrl = $canonicalUrl ?? (rtrim($siteUrl, '/') . currentPath());
$pageType = $pageType ?? (function_exists('p1_page_type_from_path') ? p1_page_type_from_path(currentPath()) : 'other');
$ogType  = $ogType ?? ($pageType === 'blog' ? 'article' : 'website');
$ogImage = $ogImage ?? $ogImageDefault;
if (strpos($ogImage, 'http') !== 0) $ogImage = rtrim($siteUrl, '/') . $ogImage;
$noindex  = $noindex ?? false;

/* Sitewide entity graph: WebSite + Electrician (#organization). Every page
 * carries the same @id so page schema can point at it via "provider". */
$headOrgId = rtrim($siteUrl, '/') . '/#organization';
$headOffers = [];
foreach ($services as $headSvc) {
    $headItem = ['@type' => 'Service', 'name' => $headSvc['name'], 'description' => $headSvc['description']];
    if (p1_page_exists('/services/' . $headSvc['slug'] . '/')) {
        $headItem['url'] = rtrim($siteUrl, '/') . '/services/' . $headSvc['slug'] . '/';
    }
    $headOffers[] = ['@type' => 'Offer', 'itemOffered' => $headItem];
}
$headAreas = [];
foreach ($serviceAreas as $headArea) {
    $headAreas[] = ['@type' => 'City', 'name' => $headArea['name'] . ', ' . $headState];
}
$headPostal = [
    '@type'           => 'PostalAddress',
    'addressLocality' => $headCity,
    'addressRegion'   => $headState,
    'postalCode'      => $address['zip'],
    'addressCountry'  => 'US',
];
if ($addressPublic && !empty($address['street'])) {
    $headPostal = ['@type' => 'PostalAddress', 'streetAddress' => $address['street']] + $headPostal;
}
$headBusiness = [
    '@type'       => 'Electrician',
    '@id'         => $headOrgId,
    'name'        => $siteName,
    'url'         => rtrim($siteUrl, '/') . '/',
    'telephone'   => $phoneRaw,
    'email'       => $email,
    'description' => $siteName . ' is an electrician in ' . $headCity . ', Wisconsin, in business since ' . $yearEstablished
                   . ', handling electrical repair, wiring, panel upgrades, lighting, EV charger and generator installation for homes and businesses.',
    'image'       => rtrim($siteUrl, '/') . $ogImageDefault,
    'logo'        => rtrim($siteUrl, '/') . $logoDark,
    'address'     => $headPostal,
    'areaServed'  => $headAreas,
    'foundingDate' => (string) $yearEstablished,
    'hasMap'      => $gbpMapsUrl,
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => 'Electrical services',
        'itemListElement' => $headOffers,
    ],
    'sameAs'      => array_values(array_filter(array_merge([$gbpMapsUrl], array_values((array) $socialLinks)))),
];
if (!empty($geo['latitude']) && !empty($geo['longitude'])) {
    $headBusiness['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => $geo['latitude'], 'longitude' => $geo['longitude']];
}
if (!empty($openingHoursSpec)) {
    $headBusiness['openingHoursSpecification'] = $openingHoursSpec;
}
$headGraph = [
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'     => 'WebSite',
            '@id'       => rtrim($siteUrl, '/') . '/#website',
            'url'       => rtrim($siteUrl, '/') . '/',
            'name'      => $siteName,
            'publisher' => ['@id' => $headOrgId],
        ],
        $headBusiness,
    ],
];
/* One @graph per page (aeo-content-schema §1.2.3): array page schema is merged
 * into the sitewide graph; a pre-encoded string still prints as its own script. */
if (!empty($schemaMarkup) && is_array($schemaMarkup)) {
    $headPageNodes = isset($schemaMarkup['@graph']) ? $schemaMarkup['@graph'] : (isset($schemaMarkup['@type']) ? [$schemaMarkup] : $schemaMarkup);
    foreach ((array) $headPageNodes as $headNode) {
        if (!is_array($headNode)) continue;
        unset($headNode['@context']);
        $headGraph['@graph'][] = $headNode;
    }
    $schemaMarkup = '';
}
$headJsonFlags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG;
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo generateMetaTags($pageTitle, $pageDescription, $canonicalUrl, $ogImage, $ogType); ?>
<?php if ($ogImage === rtrim($siteUrl, '/') . $ogImageDefault): ?>
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<?php endif; ?>
<meta name="robots" content="<?php echo $noindex ? 'noindex, nofollow' : 'index, follow, max-image-preview:large'; ?>">
<meta name="theme-color" content="#f6f5f1">

<link rel="icon" href="/assets/images/favicon.svg" type="image/svg+xml">
<link rel="icon" href="/assets/images/favicon-32x32.png" type="image/png" sizes="32x32">
<link rel="icon" href="/assets/images/favicon-16x16.png" type="image/png" sizes="16x16">
<link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png">

<!-- Self-hosted fonts (v6.2): preload only the above-the-fold heading face -->
<link rel="preload" href="/assets/fonts/space-grotesk.woff2" as="font" type="font/woff2" crossorigin>

<!-- v6.3 critical CSS inline; framework.css loads non-blocking -->
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/critical.css'; ?></style>
<link rel="preload" href="/assets/css/framework.css?v=<?php echo $cssVersion; ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="/assets/css/framework.css?v=<?php echo $cssVersion; ?>"></noscript>
<?php if (!empty($heroPreload['srcset'])): ?>
<link rel="preload" as="image" type="image/avif" imagesrcset="<?php echo $heroPreload['srcset']; ?>" imagesizes="<?php echo $heroPreload['sizes'] ?? '100vw'; ?>" fetchpriority="high">
<?php endif; ?>

<?php if (!empty($googleAnalyticsId) && $googleAnalyticsId !== 'G-XXXXXXXXXX'): ?>
<script defer src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($googleAnalyticsId); ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo e($googleAnalyticsId); ?>');</script>
<?php else: ?>
<!-- Google Analytics 4 placeholder: set $googleAnalyticsId in includes/config.php post-launch.
<script defer src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-XXXXXXXXXX');</script>
-->
<?php endif; ?>

<script type="application/ld+json"><?php echo json_encode($headGraph, $headJsonFlags); ?></script>
<?php if (!empty($schemaMarkup)): ?>
<script type="application/ld+json"><?php echo is_array($schemaMarkup) ? json_encode($schemaMarkup, $headJsonFlags) : $schemaMarkup; ?></script>
<?php endif; ?>
<?php if (!empty($headExtra)) echo $headExtra; ?>
</head>
<body class="page--<?php echo e($pageType); ?>">
