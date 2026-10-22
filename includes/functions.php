<?php
/**
 * includes/functions.php — shared helpers (Phase 2).
 * Loaded once by head.php (require_once). Needs config.php first.
 * No FAQPage helper on purpose: FAQPage JSON-LD is never emitted (visible FAQ text only).
 */

if (!function_exists('e')) {
    /** HTML-escape shorthand. */
    function e($value): string {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

/** Request path without query string, with /index.php collapsed to its directory. */
function currentPath(): string {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $path = preg_replace('#/index\.php$#', '/', $path);
    return $path === '' ? '/' : $path;
}

/**
 * True when $page is the current page ('/' matches the homepage only).
 * Pass $section = true to also match descendants (/services/ is active on /services/panel-upgrades/).
 */
function isActivePage(string $page, bool $section = false): bool {
    $current = currentPath();
    if ($page === '/') return $current === '/';
    $page = '/' . trim($page, '/') . '/';
    $cur  = rtrim($current, '/') . '/';
    return $section ? strpos($cur, $page) === 0 : $cur === $page;
}

/**
 * Link integrity: true when an internal href resolves to a page on disk.
 * Nav, footer and partial links render only when this passes, so a page that
 * is not built yet is never linked (one 404 = phase not complete).
 */
function p1_page_exists(string $href): bool {
    static $cache = [];
    $path = parse_url($href, PHP_URL_PATH) ?: '/';
    if (isset($cache[$path])) return $cache[$path];
    $root = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');
    if ($path === '/sitemap.xml') {
        $ok = is_file($root . '/sitemap.php') || is_file($root . '/sitemap.xml');
    } elseif (substr($path, -1) === '/') {
        $ok = is_file($root . $path . 'index.php') || is_file($root . $path . 'index.html');
    } else {
        $ok = is_file($root . $path) || is_file($root . $path . '.php');
    }
    return $cache[$path] = $ok;
}

/** (608) 477-8453 style display format from any US number. */
function formatPhone(string $phone): string {
    $digits = preg_replace('/\D+/', '', $phone);
    if (strlen($digits) === 11 && $digits[0] === '1') $digits = substr($digits, 1);
    if (strlen($digits) !== 10) return $phone;
    return sprintf('(%s) %s-%s', substr($digits, 0, 3), substr($digits, 3, 3), substr($digits, 6));
}

/** E.164 for tel: links and schema. */
function phoneE164(string $phone): string {
    $digits = preg_replace('/\D+/', '', $phone);
    if (strlen($digits) === 10) $digits = '1' . $digits;
    return '+' . $digits;
}

/** URL slug from any label. */
function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = str_replace('&', ' and ', $text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

/** Service slug: the config.php slug when the name matches, else a slugified name. */
function getServiceSlug(string $name): string {
    global $services;
    foreach ((array) $services as $s) {
        if (strcasecmp($s['name'] ?? '', $name) === 0) return $s['slug'];
    }
    return slugify($name);
}

/** Area slug: the config.php slug when the city matches, else a slugified city. */
function getAreaSlug(string $city): string {
    global $serviceAreas;
    foreach ((array) $serviceAreas as $a) {
        if (strcasecmp($a['name'] ?? '', $city) === 0) return $a['slug'];
    }
    return slugify($city);
}

/** Public href for an area: its own page once built, else the overview anchor, else ''. */
function areaHref(array $area): string {
    $own = '/areas/' . $area['slug'] . '/';
    if (is_dir(rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/') . '/areas/' . $area['slug']) && p1_page_exists($own)) return $own;
    if (p1_page_exists('/service-areas/')) return '/service-areas/#' . $area['slug'];
    return '';
}

/**
 * Inline Lucide icon (v6.2 — build-time SVG, never runtime injection).
 * Reads references/lucide-icons/<name>.svg, strips the licence comment and
 * adds aria-hidden + size. Returns '' for an unknown icon.
 */
function icon(string $name, int $size = 20, string $class = ''): string {
    static $cache = [];
    if (!preg_match('/^[a-z0-9-]+$/', $name)) return '';
    if (!isset($cache[$name])) {
        $file = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/') . '/references/lucide-icons/' . $name . '.svg';
        $svg  = is_file($file) ? (string) file_get_contents($file) : '';
        $svg  = preg_replace('/<!--.*?-->/s', '', $svg);
        $svg  = preg_replace('/\s+/', ' ', trim($svg));
        $svg  = preg_replace('/\s(width|height)="\d+"/', '', $svg);
        $cache[$name] = $svg;
    }
    if ($cache[$name] === '') return '';
    $attrs = ' width="' . $size . '" height="' . $size . '" aria-hidden="true" focusable="false"';
    $svg = preg_replace('/^<svg/', '<svg' . $attrs, $cache[$name]);
    if ($class !== '') $svg = preg_replace('/class="([^"]*)"/', 'class="$1 ' . e($class) . '"', $svg, 1);
    return $svg;
}

/**
 * Service JSON-LD (array — json_encode it or pass to head.php via $schemaMarkup).
 * $service is a config.php $services row. Provider references the sitewide #organization.
 */
function generateServiceSchema(array $service): array {
    global $siteUrl, $serviceAreas, $address;
    $url = rtrim($siteUrl, '/') . '/services/' . $service['slug'] . '/';
    $areas = [];
    foreach ((array) $serviceAreas as $a) {
        $areas[] = ['@type' => 'City', 'name' => $a['name'] . ', ' . $address['state']];
    }
    return [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $url . '#service',
        'name'        => $service['name'],
        'serviceType' => $service['keywords'][0] ?? $service['name'],
        'description' => $service['description'],
        'url'         => $url,
        'provider'    => ['@id' => rtrim($siteUrl, '/') . '/#organization'],
        'areaServed'  => $areas,
    ];
}

/** BreadcrumbList JSON-LD from [['name' => 'Services', 'url' => '/services/'], ...] (Home is prepended). */
function generateBreadcrumbSchema(array $crumbs): array {
    global $siteUrl;
    $items = [['name' => 'Home', 'url' => '/']];
    foreach ($crumbs as $c) $items[] = $c;
    $list = [];
    foreach ($items as $i => $c) {
        $list[] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $c['name'],
            'item'     => rtrim($siteUrl, '/') . $c['url'],
        ];
    }
    return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $list];
}

/**
 * Title, description, canonical and Open Graph tags. head.php calls this once;
 * no meta keywords and no twitter:* tags (both forbidden).
 */
function generateMetaTags(string $title, string $description, string $canonical, string $ogImage = '', string $ogType = 'website'): string {
    global $siteName;
    $out  = '<title>' . e($title) . "</title>\n";
    $out .= '<meta name="description" content="' . e($description) . "\">\n";
    $out .= '<link rel="canonical" href="' . e($canonical) . "\">\n";
    $out .= '<meta property="og:type" content="' . e($ogType) . "\">\n";
    $out .= '<meta property="og:title" content="' . e($title) . "\">\n";
    $out .= '<meta property="og:description" content="' . e($description) . "\">\n";
    $out .= '<meta property="og:url" content="' . e($canonical) . "\">\n";
    if ($ogImage !== '') {
        $out .= '<meta property="og:image" content="' . e($ogImage) . "\">\n";
        $out .= '<meta property="og:image:alt" content="' . e($siteName) . " logo\">\n";
    }
    $out .= '<meta property="og:site_name" content="' . e($siteName) . "\">\n";
    $out .= "<meta property=\"og:locale\" content=\"en_US\">\n";
    return $out;
}
