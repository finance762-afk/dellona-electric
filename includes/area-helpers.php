<?php
/**
 * includes/area-helpers.php — Phase 6 shared pieces for /service-areas/ and /service-areas/<slug>/.
 *   p1_area_breadcrumb()  visible breadcrumb (schema twin is in p1_area_schema())
 *   p1_area_schema()      WebPage + BreadcrumbList + Electrician (#organization, areaServed = this area)
 *                         + Service nodes for head.php's single @graph
 *   p1_area_page_css()    component CSS shared by the hub and every area page (tokens only)
 * Page copy never lives here: every area page carries its own researched text.
 */

/** Visible breadcrumb: Home / Service Areas[ / <area>]. */
function p1_area_breadcrumb(string $areaName = ''): string {
    $out = '<nav class="breadcrumb svc-crumbs" aria-label="Breadcrumb"><ol>'
         . '<li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>';
    if ($areaName === '') {
        return $out . '<li><span aria-current="page">Service Areas</span></li></ol></nav>';
    }
    return $out . '<li><a href="/service-areas/">Service Areas</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>'
         . '<li><span aria-current="page">' . e($areaName) . '</span></li></ol></nav>';
}

/**
 * JSON-LD nodes for an area page (or the hub when $area is null).
 * The Electrician node reuses the sitewide #organization @id, so JSON-LD merges it with
 * head.php's entity instead of declaring a second business; it adds areaServed for this area.
 * $area: config.php $serviceAreas row plus optional 'sameAs' (Wikipedia URL) and 'containedIn'.
 */
function p1_area_schema(?array $area, string $pageTitle, string $pageDescription, string $canonicalUrl, string $image): array {
    global $siteUrl, $address, $siteName, $phoneRaw, $primaryKeyword;
    $root  = rtrim($siteUrl, '/');
    $state = $address['state'];

    $webPage = generateWebPageSchema($pageTitle, $pageDescription, $canonicalUrl, '/assets/images/' . $image . '.jpg');
    $webPage['speakable']  = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
    $webPage['breadcrumb'] = ['@id' => $canonicalUrl . '#breadcrumb'];

    $crumbs = [['name' => 'Service Areas', 'url' => '/service-areas/']];
    if ($area) $crumbs[] = ['name' => $area['name'], 'url' => '/service-areas/' . $area['slug'] . '/'];
    $breadcrumb = generateBreadcrumbSchema($crumbs);
    unset($breadcrumb['@context']);
    $breadcrumb['@id'] = $canonicalUrl . '#breadcrumb';

    $county = ['@type' => 'AdministrativeArea', 'name' => ($area['county'] ?? 'Sauk') . ' County, ' . $state];
    $places = [];
    if ($area) {
        $city = ['@type' => 'City', 'name' => $area['name'] . ', ' . $state, 'containedInPlace' => $county];
        if (!empty($area['sameAs'])) $city['sameAs'] = $area['sameAs'];
        $places[] = $city;
    } else {
        global $serviceAreas;
        foreach ((array) $serviceAreas as $hubArea) $places[] = ['@type' => 'City', 'name' => $hubArea['name'] . ', ' . $state];
        $places[] = $county;
    }

    $business = [
        '@type'      => 'Electrician',
        '@id'        => $root . '/#organization',
        'name'       => $siteName,
        'telephone'  => $phoneRaw,
        'url'        => $root . '/',
        'areaServed' => $places,
    ];

    $nodes = [$webPage, $breadcrumb, $business];
    if ($area) {
        $nodes[] = [
            '@type'       => 'Service',
            '@id'         => $canonicalUrl . '#service',
            'name'        => $primaryKeyword . ' in ' . $area['name'] . ', ' . $state,
            'serviceType' => $primaryKeyword,
            'url'         => $canonicalUrl,
            'image'       => $root . '/assets/images/' . $image . '.jpg',
            'provider'    => ['@id' => $root . '/#organization'],
            'areaServed'  => $places,
            'mainEntityOfPage' => ['@id' => $canonicalUrl . '#webpage'],
        ];
    }
    return ['@graph' => $nodes];
}

/**
 * Area component CSS (tokens only). Builds on p1_service_page_css() for the layered hero,
 * answer blocks, table, related grid and closing CTA; this adds the area-only pieces:
 * .area-ledger (town fact strip), .area-split (photo + copy), .area-steps (ordered steps),
 * .area-offices (who-to-call cards), .area-why (reasons list).
 */
function p1_area_page_css(): string {
    ob_start(); ?>
<style>
/* ==== Service-area pages — shared components (Phase 6). Page composition follows in each page's own <style>. ==== */
.area-ledger { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); border-block: 1px solid var(--color-line); }
.area-ledger li { display: grid; gap: var(--space-1); align-content: start; padding: var(--space-6) var(--space-5); border-left: 1px solid var(--color-line); }
.area-ledger li:first-child { border-left: 0; padding-left: 0; }
.area-ledger b { font-family: var(--font-accent); font-size: clamp(1.8rem, 1.3rem + 1.6vw, 2.6rem); line-height: 1; letter-spacing: .01em; color: var(--color-ink); }
.area-ledger b small { font-size: .5em; color: var(--color-accent-dark); margin-left: var(--space-1); }
.area-ledger span { font-size: var(--font-size-sm); color: var(--color-ink-2); }
.area-ledger cite { font-style: normal; font-size: var(--font-size-xs); color: var(--color-muted); }
@media (max-width: 900px) {
  .area-ledger { grid-template-columns: 1fr 1fr; }
  .area-ledger li:nth-child(3) { border-left: 0; padding-left: 0; }
  .area-ledger li:nth-child(n+3) { border-top: 1px solid var(--color-line); }
}
@media (max-width: 520px) { .area-ledger { grid-template-columns: 1fr; } .area-ledger li { border-left: 0; padding-left: 0; } .area-ledger li + li { border-top: 1px solid var(--color-line); } }

.area-split { display: grid; grid-template-columns: minmax(0, 1.15fr) minmax(0, .85fr); gap: var(--space-12); align-items: start; }
.area-split--flip > :first-child { order: 2; }
.area-split__copy { display: grid; gap: var(--space-4); }
.area-split__copy p { margin: 0; }
.area-photo { position: relative; margin: 0; }
.area-photo .img-framed { overflow: hidden; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); aspect-ratio: 4 / 5; }
.area-photo img { width: 100%; height: 100%; object-fit: cover; }
.area-photo figcaption { margin-top: var(--space-3); font-size: var(--font-size-sm); color: var(--color-muted); }
@media (max-width: 900px) { .area-split { grid-template-columns: 1fr; gap: var(--space-8); } .area-split--flip > :first-child { order: 0; } }

.area-steps { list-style: none; margin: 0; padding: 0; counter-reset: areastep; display: grid; gap: var(--space-3); }
.area-steps li { counter-increment: areastep; display: grid; grid-template-columns: var(--space-10) 1fr; gap: var(--space-1) var(--space-4); align-items: start; }
.area-steps li::before {
  content: counter(areastep); grid-row: span 2; width: var(--space-10); height: var(--space-10); border-radius: var(--radius-full);
  display: grid; place-items: center; font-family: var(--font-accent); font-size: var(--font-size-lg); background: var(--color-accent); color: var(--color-ink);
}
.area-steps b { font-family: var(--font-heading); }
.area-steps span { font-size: var(--font-size-sm); }

.area-offices { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-5); }
.area-office { display: grid; gap: var(--space-3); align-content: start; padding: var(--space-6); border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.area-office:hover { transform: translateY(-2px); box-shadow: var(--shadow); }
.area-office__tag { justify-self: start; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; padding: var(--space-1) var(--space-3); border-radius: var(--radius-full); background: var(--color-dark); color: var(--color-accent-bright); }
.area-office h3 { font-size: var(--font-size-lg); }
.area-office p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
@media (max-width: 900px) { .area-offices { grid-template-columns: 1fr; } }

.area-why { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-4); }
.area-why li { display: grid; grid-template-columns: 40px 1fr; gap: var(--space-1) var(--space-3); padding-top: var(--space-4); border-top: 1px solid var(--color-line); }
.area-why li svg { grid-row: span 2; color: var(--color-accent-dark); margin-top: var(--space-1); }
.area-why b { font-family: var(--font-heading); color: var(--color-ink); }
.area-why span { font-size: var(--font-size-sm); color: var(--color-ink-2); }

@media (prefers-reduced-motion: reduce) { .area-office, .area-office:hover { transition: none; transform: none; } }
</style>
<?php
    return (string) ob_get_clean();
}
