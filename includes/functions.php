<?php
/**
 * includes/functions.php — shared helpers (Phase 2).
 * Loaded once by head.php (require_once). Needs config.php first.
 * No FAQPage helper on purpose: FAQPage JSON-LD is never emitted (visible FAQ text only).
 */

require_once __DIR__ . '/p1-form-helpers.php';   // p1_lead_hidden_fields(), p1_consent_row(), p1_service_options()

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

/** Public href for an area: its own /service-areas/<slug>/ page once built, else the hub anchor, else ''. */
function areaHref(array $area): string {
    $own = '/service-areas/' . $area['slug'] . '/';
    if (is_dir(rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/') . '/service-areas/' . $area['slug']) && p1_page_exists($own)) return $own;
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
 * Responsive variants on disk for a photo basename, e.g. 'hero-kitchen-lighting-v1'.
 * Returns [width => '/assets/images/<name>-<width>.<ext>'] sorted by width. Variants are never
 * upscaled, so a 720px original ships -480 and -720 (the native width) rather than a fake -960.
 */
function p1_image_variants(string $name, string $ext): array {
    static $cache = [];
    $key = $name . '.' . $ext;
    if (isset($cache[$key])) return $cache[$key];
    $dir = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/') . '/assets/images/';
    $out = [];
    foreach ((array) glob($dir . $name . '-*.' . $ext) as $file) {
        if (preg_match('/-(\d+)\.' . preg_quote($ext, '/') . '$/', $file, $m)) {
            $out[(int) $m[1]] = '/assets/images/' . basename($file);
        }
    }
    ksort($out);
    return $cache[$key] = $out;
}

/** "url 480w, url 960w" srcset string for a photo basename and format ('' when no variants exist). */
function p1_srcset(string $name, string $ext = 'webp'): string {
    $parts = [];
    foreach (p1_image_variants($name, $ext) as $w => $url) $parts[] = $url . ' ' . $w . 'w';
    return implode(', ', $parts);
}

/**
 * <picture> for a local photo (v6.3): AVIF source first, WebP srcset on the <img>, the
 * base .jpg as src, explicit width/height from the jpg (no CLS).
 * $opt: sizes, class (on <img>), loading ('lazy'|'eager'), priority (true = fetchpriority high,
 * hero only), width/height overrides.
 */
function p1_picture(string $name, string $alt, array $opt = []): string {
    $root  = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');
    $src   = '/assets/images/' . $name . '.jpg';
    $dims  = @getimagesize($root . $src) ?: [1200, 900];
    $w     = (int) ($opt['width'] ?? $dims[0]);
    $h     = (int) ($opt['height'] ?? $dims[1]);
    $sizes = $opt['sizes'] ?? '(max-width: 768px) 100vw, 600px';
    $eager = !empty($opt['priority']) || ($opt['loading'] ?? 'lazy') === 'eager';
    $avif  = p1_srcset($name, 'avif');
    $webp  = p1_srcset($name, 'webp');
    $out   = '<picture>';
    if ($avif !== '') $out .= '<source type="image/avif" srcset="' . e($avif) . '" sizes="' . e($sizes) . '">';
    $out  .= '<img src="' . e($src) . '"';
    if ($webp !== '') $out .= ' srcset="' . e($webp) . '" sizes="' . e($sizes) . '"';
    $out  .= ' alt="' . e($alt) . '" width="' . $w . '" height="' . $h . '"';
    if (!empty($opt['class'])) $out .= ' class="' . e($opt['class']) . '"';
    $out  .= $eager ? ' loading="eager"' : ' loading="lazy" decoding="async"';
    if (!empty($opt['priority'])) $out .= ' fetchpriority="high"';
    $out  .= '></picture>';
    return $out;
}

/** Look up a config.php $services row by slug (null when absent). */
function p1_service_by_slug(string $slug): ?array {
    global $services;
    foreach ((array) $services as $s) {
        if (($s['slug'] ?? '') === $slug) return $s;
    }
    return null;
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

/**
 * WebPage JSON-LD node tied to the sitewide #website / #organization nodes.
 * head.php merges array schema into its single @graph.
 */
function generateWebPageSchema(string $name, string $description, string $url, string $image = ''): array {
    global $siteUrl;
    $root = rtrim($siteUrl, '/');
    $node = [
        '@type'       => 'WebPage',
        '@id'         => $url . '#webpage',
        'url'         => $url,
        'name'        => $name,
        'description' => $description,
        'isPartOf'    => ['@id' => $root . '/#website'],
        'about'       => ['@id' => $root . '/#organization'],
        'inLanguage'  => 'en-US',
    ];
    if ($image !== '') {
        $node['primaryImageOfPage'] = ['@type' => 'ImageObject', 'url' => strpos($image, 'http') === 0 ? $image : $root . $image];
    }
    return $node;
}

/**
 * The full lead form (contact-form-standard.md): name, phone, email, service, message,
 * three unbundled consent boxes (email optional, SMS optional, terms required), all
 * hidden fields via p1_lead_hidden_fields(). $formId is the form_location/attribution id
 * and must be unique on the page; $prefix keeps element ids unique.
 */
function p1_full_lead_form(string $formId, string $prefix, string $submitLabel = 'Send my request'): string {
    global $formAction, $siteName, $email;
    $p = e($prefix);
    ob_start(); ?>
<form action="<?php echo e($formAction); ?>" method="POST" class="estimate-form" id="<?php echo $p; ?>-form">
<?php echo p1_lead_hidden_fields($formId); ?>
  <div class="form-grid">
    <div class="field"><label for="<?php echo $p; ?>-name">Your name *</label><input id="<?php echo $p; ?>-name" type="text" name="name" autocomplete="name" required></div>
    <div class="field"><label for="<?php echo $p; ?>-phone">Phone *</label><input id="<?php echo $p; ?>-phone" type="tel" name="phone" autocomplete="tel" required></div>
    <div class="field full"><label for="<?php echo $p; ?>-email">Email *</label><input id="<?php echo $p; ?>-email" type="email" name="email" autocomplete="email" required></div>
    <div class="field full"><label for="<?php echo $p; ?>-service">Service needed</label><select id="<?php echo $p; ?>-service" name="service"><?php echo p1_service_options(); ?></select></div>
    <div class="field full"><label for="<?php echo $p; ?>-message">What's going on?</label><textarea id="<?php echo $p; ?>-message" name="message" rows="3" placeholder="Breaker keeps tripping, adding a charger in the garage, wiring a new build…"></textarea></div>
  </div>
  <fieldset class="form-consent-fieldset">
    <legend class="form-consent-legend">Communication consent</legend>
    <label class="form-consent-item" for="<?php echo $p; ?>-email-opt">
      <input id="<?php echo $p; ?>-email-opt" type="checkbox" name="email_opt_in" value="yes" class="consent-checkbox">
      <span class="consent-label"><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo e($siteName); ?> about my inquiry, services, promotions and news. I can unsubscribe anytime via the link in any email or by emailing <?php echo e($email); ?>. Message frequency varies.</span>
    </label>
    <label class="form-consent-item" for="<?php echo $p; ?>-sms-opt">
      <input id="<?php echo $p; ?>-sms-opt" type="checkbox" name="sms_opt_in" value="yes" class="consent-checkbox">
      <span class="consent-label"><strong>SMS/Text messages (optional):</strong> I agree to receive text messages from <?php echo e($siteName); ?> at the phone number I provided. Message types may include appointment reminders, service updates and promotional offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. <strong>Consent is not a condition of purchase.</strong></span>
    </label>
    <label class="form-consent-item form-consent-required" for="<?php echo $p; ?>-terms">
      <input id="<?php echo $p; ?>-terms" type="checkbox" name="terms_accepted" value="yes" class="consent-checkbox" required>
      <span class="consent-label">I have read and agree to the <a href="/privacy-policy/">Privacy Policy</a> and <a href="/terms/">Terms of Service</a>. <span class="required-star">*</span></span>
    </label>
  </fieldset>
  <button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo e($submitLabel); ?></button>
</form>
<?php
    return (string) ob_get_clean();
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
