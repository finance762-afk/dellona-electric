<?php
/**
 * includes/service-helpers.php — Phase 4 shared pieces for /services/ and /services/<slug>/.
 *   $svcCatalog            card data for all 15 config.php services (photo, icon, 3 bullets)
 *   p1_service_cards()     required services-grid / service-card-with-image markup
 *   p1_service_schema()    Service + BreadcrumbList + WebPage (speakable) nodes for head.php's @graph
 *   p1_service_page_css()  the service-page component CSS (tokens only); each page adds its own <style>
 * Page copy never lives here: every page file carries its own headings and text.
 * Card copy describes the work and what the client photos show — no unconfirmed claims
 * (licence, insurance, hours, prices, free estimates) — see /content-confirmations.json.
 */

$svcCatalog = [
    'electrical-repair' => ['icon' => 'wrench', 'img' => 'sunroom-device-install-v1',
        'alt' => 'Dellona Electric electrician kneeling to work on a wall box in a lakeside sunroom',
        'desc' => 'Tracing and fixing dead circuits, short circuits, flickering lights and partial power loss.',
        'bullets' => ['Dead circuits traced to the fault', 'Tripping breakers diagnosed', 'Flicker and buzzing tracked down']],
    'wiring-rewiring' => ['icon' => 'waypoints', 'img' => 'panel-work-basement-v1',
        'alt' => 'Bundles of cable fanning out of a breaker panel along the log joists of an old basement',
        'desc' => 'Repairs to damaged or outdated wiring, and partial or whole-home rewiring for older houses.',
        'bullets' => ['Old and damaged runs replaced', 'Grounded circuits for older homes', 'Rewiring during remodels']],
    'panel-upgrades' => ['icon' => 'zap', 'img' => 'panel-work-basement-v1',
        'alt' => 'Two Dellona Electric electricians working inside an open breaker panel in an unfinished basement',
        'desc' => 'Breaker and panel repair, plus panel and service upgrades for homes that need more capacity.',
        'bullets' => ['Worn breakers replaced', 'Room for new circuits', 'Capacity for chargers and additions']],
    'outlet-switch-repair' => ['icon' => 'plug', 'img' => 'sunroom-device-install-v1',
        'alt' => 'Electrician fitting a device into a wall box on beadboard paneling in a sunroom',
        'desc' => 'Dead, loose, warm or worn outlets and switches repaired or replaced, including GFCI outlets.',
        'bullets' => ['Warm outlets checked first', 'GFCI outlets where code wants them', 'Loose switches made solid']],
    'lighting-installation' => ['icon' => 'lightbulb', 'img' => 'hero-kitchen-lighting-v1',
        'alt' => 'Kitchen with recessed ceiling lights and three pendant lights over a white island',
        'desc' => 'Recessed, pendant, under-cabinet, exterior and security lighting for new and existing homes.',
        'bullets' => ['Recessed and pendant layouts', 'Soffit and porch lighting', 'Motion and dusk-to-dawn lights']],
    'ceiling-fan-installation' => ['icon' => 'wind', 'img' => 'living-room-ceiling-fan-v1',
        'alt' => 'Living room with a large nine-blade ceiling fan and backlit built-in wall niches',
        'desc' => 'Ceiling fans mounted on fan-rated boxes, with wall switch, remote or smart control.',
        'bullets' => ['Fan-rated mounting boxes', 'Old fixtures swapped for fans', 'Separate fan and light control']],
    'ev-charger-installation' => ['icon' => 'battery-charging', 'img' => 'ev-charger-garage-v1',
        'alt' => 'Wall-mounted JuiceBox EV charger plugged into a 240-volt outlet on a garage wall',
        'desc' => 'Level 2 home EV chargers on a dedicated 240-volt circuit, after a check of panel capacity.',
        'bullets' => ['Dedicated 240-volt circuit', 'Panel capacity checked first', 'Plug-in or hardwired units']],
    'generator-installation' => ['icon' => 'power', 'img' => 'standby-generator-log-home-v1',
        'alt' => 'Two Dellona Electric electricians running conduit beside a Kohler standby generator at a log home',
        'desc' => 'Standby generators and portable generator hookups, each with a transfer switch or interlock.',
        'bullets' => ['Standby generator wiring', 'Transfer switch installation', 'Portable generator inlets']],
    'surge-protection' => ['icon' => 'shield-check', 'img' => 'standby-generator-log-home-v1',
        'alt' => 'Air conditioner condenser and standby generator beside a log home, wired to an outdoor disconnect',
        'desc' => 'A surge protective device at the panel that guards furnaces, AC units, appliances and electronics.',
        'bullets' => ['Mounted at the main panel', 'Covers every circuit at once', 'Pairs with point-of-use strips']],
    'smart-home-wiring' => ['icon' => 'home', 'img' => 'living-room-ceiling-fan-v1',
        'alt' => 'Living room TV wall with a recessed media box, backlit niches and recessed ceiling lights',
        'desc' => 'Wiring for smart switches, dimmers, thermostats, video doorbells and wall-mounted TVs.',
        'bullets' => ['Neutral wires checked first', 'Hidden power behind TVs', 'Smart switches and dimmers']],
    'smoke-detector-installation' => ['icon' => 'flame', 'img' => 'new-home-exterior-lighting-v1',
        'alt' => 'New home at dusk with soffit and porch lights on, wired by Dellona Electric',
        'desc' => 'Hardwired, interconnected smoke and carbon monoxide alarms installed and replaced.',
        'bullets' => ['Interconnected so all sound', 'Battery backup on hardwired units', 'CO alarms on every level']],
    'electrical-inspections' => ['icon' => 'clipboard-check', 'img' => 'crew-company-truck-v1',
        'alt' => 'Two members of the Dellona Electric crew standing beside the lettered company truck',
        'desc' => 'Whole-home electrical inspections and maintenance visits that find problems before they fail.',
        'bullets' => ['Panel and breaker check', 'Outlets tested room by room', 'Smoke and CO alarms checked']],
    'new-construction-wiring' => ['icon' => 'hard-hat', 'img' => 'garage-exterior-lighting-night-v1',
        'alt' => 'Newly built garage lit up at night by exterior wall lights, with both doors open',
        'desc' => 'Wiring for new homes, additions, garages and outbuildings, from rough-in to final.',
        'bullets' => ['Rough-in through final', 'Garages and outbuildings', 'Lighting and outlet layout']],
    'commercial-electrical' => ['icon' => 'building-2', 'img' => 'commercial-bar-lighting-v1',
        'alt' => 'Restaurant bar interior with filament pendant lights, a skylight and wood-plank flooring',
        'desc' => 'Repairs, lighting and upgrades for restaurants, shops, offices and light industrial space.',
        'bullets' => ['Dining and retail lighting', 'Circuits for new equipment', 'Exit and emergency lighting']],
    'emergency-electrician' => ['icon' => 'alert-triangle', 'img' => 'truck-trailer-job-site-v1',
        'alt' => 'Dellona Electric pickup and enclosed trailer parked on a job site',
        'desc' => 'Urgent help with burning smells, sparking, hot outlets, partial power loss and storm damage.',
        'bullets' => ['Burning smells and sparks', 'Half the house without power', 'Storm-damaged service masts']],
];

/**
 * services-grid markup for the given slugs (required component; tints rotate 1→2→3).
 * $opt: sizes (img sizes attr), class (extra grid class), featured_label (data attr on card 1).
 */
function p1_service_cards(array $slugs, array $opt = []): string {
    global $svcCatalog;
    $sizes = $opt['sizes'] ?? '(max-width: 440px) 100vw, (max-width: 720px) 50vw, (max-width: 1000px) 33vw, 340px';
    $out = '<div class="services-grid' . (!empty($opt['class']) ? ' ' . e($opt['class']) : '') . '">';
    $i = 0;
    foreach ($slugs as $cardSlug) {
        $cardSvc = p1_service_by_slug($cardSlug);
        $cardCat = $svcCatalog[$cardSlug] ?? null;
        if (!$cardSvc || !$cardCat) continue;
        $tint = ($i % 3) + 1;
        $href = '/services/' . $cardSlug . '/';
        $attr = ($i === 0 && !empty($opt['featured_label'])) ? ' data-featured-label="' . e($opt['featured_label']) . '"' : '';
        $out .= '<article class="service-card-with-image card-tint-' . $tint . ' reveal-up reveal-delay-' . $tint . '"' . $attr . '>';
        $out .= '<div class="service-card__image">' . p1_picture($cardCat['img'], $cardCat['alt'], ['sizes' => $sizes]) . '</div>';
        $out .= '<div class="service-card__body">';
        $out .= '<div class="service-card__icon">' . icon($cardCat['icon'], 22) . '</div>';
        $out .= '<h3>' . e($cardSvc['name']) . '</h3>';
        $out .= '<p class="service-card__desc">' . e($cardCat['desc']) . '</p><ul>';
        foreach ($cardCat['bullets'] as $b) $out .= '<li>' . e($b) . '</li>';
        $out .= '</ul>';
        $out .= p1_page_exists($href)
            ? '<a href="' . e($href) . '" class="service-card__cta">Learn more<span class="sr-only"> about ' . e(strtolower($cardSvc['name'])) . '</span></a>'
            : '<button type="button" class="service-card__cta" data-open-estimate>Ask about ' . e(strtolower($cardSvc['name'])) . '</button>';
        $out .= '</div></article>';
        $i++;
    }
    return $out . '</div>';
}

/**
 * Service page JSON-LD nodes (merged by head.php into the sitewide @graph).
 * Service @id = <page url>#service-<slug>; provider = the sitewide Electrician (#organization).
 */
function p1_service_schema(string $slug, string $pageTitle, string $pageDescription, string $canonicalUrl, string $heroImage, array $extra = []): array {
    global $siteUrl, $serviceAreas, $address, $siteName;
    $svc  = p1_service_by_slug($slug);
    $root = rtrim($siteUrl, '/');
    $areas = [];
    foreach ((array) $serviceAreas as $a) $areas[] = ['@type' => 'City', 'name' => $a['name'] . ', ' . $address['state']];
    $areas[] = ['@type' => 'AdministrativeArea', 'name' => $serviceAreas[0]['county'] . ' County, ' . $address['state']];
    $service = [
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-' . $slug,
        'name'        => $svc['name'],
        'serviceType' => $extra['serviceType'] ?? ($svc['keywords'][0] ?? $svc['name']),
        'description' => $extra['description'] ?? $svc['description'],
        'url'         => $canonicalUrl,
        'image'       => $root . '/assets/images/' . $heroImage . '.jpg',
        'provider'    => ['@id' => $root . '/#organization'],
        'areaServed'  => $areas,
        'mainEntityOfPage' => ['@id' => $canonicalUrl . '#webpage'],
    ];
    if (!empty($svc['keywords'])) $service['alternateName'] = array_values(array_diff($svc['keywords'], [$service['serviceType']]));
    if (empty($service['alternateName'])) unset($service['alternateName']);
    $webPage = generateWebPageSchema($pageTitle, $pageDescription, $canonicalUrl, '/assets/images/' . $heroImage . '.jpg');
    $webPage['speakable'] = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
    $webPage['breadcrumb'] = ['@id' => $canonicalUrl . '#breadcrumb'];
    $crumbs = generateBreadcrumbSchema([
        ['name' => 'Services', 'url' => '/services/'],
        ['name' => $svc['name'], 'url' => '/services/' . $slug . '/'],
    ]);
    unset($crumbs['@context']);
    $crumbs['@id'] = $canonicalUrl . '#breadcrumb';
    return ['@graph' => [$webPage, $service, $crumbs]];
}

/** Visible breadcrumb for a service page (schema twin is in p1_service_schema()). */
function p1_service_breadcrumb(string $name): string {
    return '<nav class="breadcrumb svc-crumbs" aria-label="Breadcrumb"><ol>'
         . '<li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>'
         . '<li><a href="/services/">Services</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>'
         . '<li><span aria-current="page">' . e($name) . '</span></li></ol></nav>';
}

/**
 * Service-page component CSS. Tokens only (no raw colors, shadows or spacing).
 * Sections: .svc-hero (C1 layered hero), .svc-signs (pull quote + bento), .svc-expert
 * (60/40 stat split), .svc-breakdown (sticky process storytelling), .svc-proof (dark grain
 * photo band), .svc-compare (real <table>), .svc-faq, .svc-related, .svc-cta.
 */
function p1_service_page_css(): string {
    ob_start(); ?>
<style>
/* ==== Service pages — shared components (Phase 4). Page-specific composition follows in each page's own <style>. ==== */

/* -- C1 layered hero: dark brushed band, job photo on the right half, ::before glow, ::after grain -- */
.svc-hero { background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 120%); }
.svc-hero::before {
  content: ""; position: absolute; z-index: -1; pointer-events: none; inset: -30% 45% 0 -20%;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 72%);
}
.svc-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.55'/%3E%3C/svg%3E");
}
.svc-hero__media { position: absolute; inset: 0 0 0 46%; z-index: -2; }
.svc-hero__media picture, .svc-hero__media img { display: block; width: 100%; height: 100%; object-fit: cover; }
.svc-hero__media::after {
  content: ""; position: absolute; inset: 0; pointer-events: none;
  background: linear-gradient(90deg, var(--color-dark) 0%, color-mix(in srgb, var(--color-dark) 55%, transparent) 30%, color-mix(in srgb, var(--color-dark) 20%, transparent) 100%);
}
.svc-hero .hero-grid--form { align-items: end; }
.svc-hero .hero-copy { gap: var(--space-4); }
.svc-hero .hero-title .text-accent { color: var(--color-accent-bright); }
.svc-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 86%, transparent); max-width: 34rem; }
.svc-hero .hero-chips li { background: color-mix(in srgb, var(--color-dark) 55%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); backdrop-filter: blur(6px); }
.svc-hero .hero-chips svg { color: var(--color-accent-bright); }
.svc-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.svc-hero .link-call svg { color: var(--color-accent-bright); }
.svc-hero .hero-form-open { background: var(--color-accent); color: var(--color-ink); }
.svc-hero .hero-form-open:hover { background: var(--color-accent-bright); }
.svc-hero .hero-form-card .consent span { color: var(--color-ink-2); }
.svc-hero .hf-pair { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-2); }
.svc-crumbs { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-2); }
.svc-crumbs ol { display: flex; flex-wrap: wrap; gap: var(--space-2); align-items: center; }
.svc-crumbs a:hover { color: var(--color-white); text-decoration: underline; }
.svc-crumbs [aria-current] { color: var(--color-white); }
@media (max-width: 900px) {
  .svc-hero__media { inset: 0; }
  .svc-hero__media::after { background: linear-gradient(180deg, color-mix(in srgb, var(--color-dark) 88%, transparent) 0%, color-mix(in srgb, var(--color-dark) 80%, transparent) 100%); }
}
@media (max-width: 560px) {
  .svc-hero .hero-copy { display: flex; flex-direction: column; }
  .svc-hero .hero-actions { order: 3; }
  .svc-hero .hero-answer { order: 4; font-size: var(--fs-body); }
  .svc-hero .hero-chips { order: 5; }
  .svc-crumbs { display: none; }
}

/* -- Shared section heads + answer blocks -- */
.svc-head { display: grid; gap: var(--space-3); margin-bottom: var(--space-8); max-width: 46rem; }
.svc-head h2 { max-width: 26ch; }
p.answer-block { font-size: var(--fs-lead); line-height: 1.55; color: var(--color-ink); }
.svc-body p { color: var(--color-ink-2); max-width: var(--measure); }
.svc-body a:not(.btn), .svc-inline-link { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; }
.svc-body a:not(.btn):hover { text-decoration-color: var(--color-primary); }

/* -- Problem statement: pull quote beside bento signs -- */
.svc-signs { background: var(--color-paper); }
.svc-signs__layout { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: var(--space-12); align-items: start; }
.svc-signs__lead { display: grid; gap: var(--space-4); position: sticky; top: calc(var(--nav-height) + var(--space-6)); }
.svc-signs .pull-quote { font-style: italic; font-size: clamp(1.4rem, 1rem + 1.6vw, 2.2rem); margin: var(--space-4) 0 0; padding-left: var(--space-4); border-left: 4px solid var(--color-accent); }
.svc-signs .bento-grid { grid-auto-rows: minmax(120px, auto); }
.svc-sign { display: grid; gap: var(--space-2); align-content: start; box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.svc-sign:hover { transform: translateY(-2px); box-shadow: var(--shadow); }
.svc-sign h3 { font-size: var(--font-size-lg); }
.svc-sign p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
.svc-sign__icon { width: 40px; height: 40px; border-radius: var(--radius); display: grid; place-items: center; background: var(--color-card-tint-3); color: var(--color-accent-dark); }
.bento-grid .svc-sign.bento-large { background: var(--color-card-tint-1); }
.bento-grid .svc-sign.bento-medium { background: var(--color-card-tint-2); }
.bento-grid .svc-sign.bento-small:nth-child(even) { background: var(--color-card-tint-3); }
@media (max-width: 900px) { .svc-signs__layout { grid-template-columns: 1fr; gap: var(--space-8); } .svc-signs__lead { position: static; } }

/* -- Expert positioning: 60/40 split, big technical number, evidence list -- */
.svc-expert { background: var(--color-surface); }
.svc-expert__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.2fr); gap: var(--space-12); align-items: center; }
.svc-expert__figure { position: relative; margin: 0; }
.svc-expert__figure .img-framed { overflow: hidden; aspect-ratio: 4 / 5; }
.svc-expert__figure img { width: 100%; height: 100%; object-fit: cover; }
.svc-expert__stat {
  position: absolute; right: calc(-1 * var(--space-6)); bottom: var(--space-8); z-index: 2;
  background: var(--color-dark); color: var(--color-white); border-radius: var(--radius); padding: var(--space-4) var(--space-5);
  box-shadow: var(--shadow-lg); display: grid; gap: var(--space-1); max-width: 14rem;
}
.svc-expert__stat b { font-family: var(--font-accent); font-size: clamp(2.4rem, 1.6rem + 2.6vw, 3.6rem); line-height: .95; color: var(--color-accent-bright); letter-spacing: .01em; }
.svc-expert__stat span { font-size: var(--font-size-sm); color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.svc-expert__copy { display: grid; gap: var(--space-4); }
.svc-proofs { list-style: none; margin: var(--space-2) 0 0; padding: 0; display: grid; gap: var(--space-4); }
.svc-proofs li { display: grid; grid-template-columns: 36px 1fr; gap: var(--space-1) var(--space-3); align-items: start; padding-top: var(--space-4); border-top: 1px solid var(--color-line); }
.svc-proofs li svg { grid-row: span 2; color: var(--color-accent-dark); margin-top: var(--space-1); }
.svc-proofs b { font-family: var(--font-heading); color: var(--color-ink); }
.svc-proofs span { font-size: var(--font-size-sm); color: var(--color-ink-2); }
@media (max-width: 900px) { .svc-expert__grid { grid-template-columns: 1fr; } .svc-expert__stat { right: var(--space-4); } }

/* -- Service breakdown: included list + sticky-scroll process (C2.6 storytelling) -- */
.svc-breakdown { background: var(--color-paper-2); }
.svc-breakdown__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-12); align-items: start; }
.svc-breakdown__sticky { position: sticky; top: calc(var(--nav-height) + var(--space-6)); display: grid; gap: var(--space-4); }
.svc-checklist { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-3); }
.svc-checklist li { display: grid; grid-template-columns: 24px 1fr; gap: var(--space-3); align-items: start; color: var(--color-ink-2); }
.svc-checklist li svg { color: var(--color-success); margin-top: var(--space-1); }
.svc-checklist strong { color: var(--color-ink); }
.svc-steps { list-style: none; margin: 0; padding: 0; counter-reset: svcstep; display: grid; gap: var(--space-4); }
.svc-steps li {
  counter-increment: svcstep; position: relative; background: var(--color-surface); border: 1px solid var(--color-line);
  border-radius: var(--radius-lg); padding: var(--space-6) var(--space-6) var(--space-6) calc(var(--space-16) + var(--space-2));
  box-shadow: var(--shadow-sm);
}
.svc-steps li::before {
  content: counter(svcstep, decimal-leading-zero); position: absolute; left: var(--space-6); top: var(--space-6);
  font-family: var(--font-accent); font-size: var(--font-size-xl); color: var(--color-accent-dark);
}
.svc-steps li + li::after {
  content: ""; position: absolute; left: calc(var(--space-6) + var(--space-3)); top: calc(-1 * var(--space-4)); width: 2px; height: var(--space-4); background: var(--color-line);
}
.svc-steps h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-1); }
.svc-steps p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
@media (max-width: 900px) { .svc-breakdown__grid { grid-template-columns: 1fr; gap: var(--space-8); } .svc-breakdown__sticky { position: static; } }

/* -- Proof: dark grain band, captioned client photos, Google link -- */
.svc-proof .svc-proof__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.1fr); gap: var(--space-12); align-items: center; }
.svc-proof__copy { display: grid; gap: var(--space-4); }
.svc-proof__copy p { margin: 0; }
.svc-proof__photo { margin: 0; position: relative; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); }
.svc-proof__photo img { width: 100%; height: 100%; object-fit: cover; }
.svc-proof__photo figcaption {
  position: absolute; inset: auto 0 0 0; padding: var(--space-8) var(--space-4) var(--space-3);
  background: linear-gradient(to top, color-mix(in srgb, var(--color-black) 82%, transparent), transparent);
  color: var(--color-white); font-size: var(--font-size-sm);
}
.svc-proof .actions { display: flex; flex-wrap: wrap; gap: var(--space-3); }
.svc-proof p.answer-block { background: color-mix(in srgb, var(--color-white) 7%, transparent); color: var(--color-white); }
.svc-proof a:not(.btn) { color: var(--color-accent-bright); }
.svc-proof .sp-gallery-grid { min-height: 460px; }
.svc-proof .sp-gallery-item picture { display: block; height: 100%; }
@media (max-width: 900px) { .svc-proof .svc-proof__grid { grid-template-columns: 1fr; } .svc-proof .sp-gallery-grid { min-height: 0; } }

/* -- Comparison: real table, the column you are reading about wins the accent -- */
.svc-compare { background: var(--color-surface); }
.svc-table-wrap { overflow-x: auto; border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); }
.svc-table { width: 100%; border-collapse: collapse; font-size: var(--font-size-sm); min-width: 560px; }
.svc-table caption { text-align: left; padding: var(--space-4) var(--space-5) 0; font-size: var(--font-size-sm); color: var(--color-muted); caption-side: bottom; padding-bottom: var(--space-4); }
.svc-table th, .svc-table td { text-align: left; padding: var(--space-4) var(--space-5); border-bottom: 1px solid var(--color-line); vertical-align: top; }
.svc-table thead th { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-muted); background: var(--color-paper); }
.svc-table tbody th { font-family: var(--font-heading); color: var(--color-ink); width: 26%; }
.svc-table td { color: var(--color-ink-2); }
.svc-table .is-pick { background: color-mix(in srgb, var(--color-accent) 9%, var(--color-surface)); }
.svc-table thead .is-pick { color: var(--color-accent-dark); background: color-mix(in srgb, var(--color-accent) 16%, var(--color-surface)); }
.svc-table tbody tr:last-child th, .svc-table tbody tr:last-child td { border-bottom: 0; }
.svc-table tbody tr:hover td, .svc-table tbody tr:hover th { background: var(--color-paper); }

/* -- FAQ: narrow column of native details -- */
.svc-faq { background: var(--color-paper); }
.svc-faq .faq summary { font-size: var(--font-size-lg); }
.svc-faq .faq p { font-size: var(--fs-body); }

/* -- Related services: 3-up required grid -- */
.svc-related { background: var(--color-paper-2); }
.svc-related .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.svc-related .section-title { max-width: 48rem; }
button.service-card__cta { background: none; border: 0; padding: var(--space-2) 0 0; font: inherit; cursor: pointer; text-align: left; }
@media (max-width: 900px) { .svc-related .services-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 560px) { .svc-related .services-grid { grid-template-columns: 1fr; } }

/* -- Final CTA: closing band -- */
.svc-cta .container-wide { display: grid; grid-template-columns: minmax(0, 1.3fr) auto; gap: var(--space-8); align-items: center; }
.svc-cta h2 { max-width: 26ch; margin-bottom: var(--space-3); }
.svc-cta p { max-width: 58ch; margin: 0; }
.svc-cta .actions { display: flex; flex-wrap: wrap; gap: var(--space-3); }
@media (max-width: 800px) { .svc-cta .container-wide { grid-template-columns: 1fr; } }

@media (prefers-reduced-motion: reduce) { .svc-sign, .svc-sign:hover { transition: none; transform: none; } }
</style>
<?php
    return (string) ob_get_clean();
}
