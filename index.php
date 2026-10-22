<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * Homepage — Phase 3 (archetype: minimal-tech; section script: editorial +
 * recent-work gallery, 11 client photos on disk).
 * Every fact below traces to build-plan.json / config.php or to what the
 * client's own photos visibly show. Unconfirmed facts (licence, insurance,
 * hours, emergency availability, pricing, process) are left out of the copy
 * and listed in /content-confirmations.json.
 * ------------------------------------------------------------------------- */
$pageTitle       = 'Dellona Electric | Electrical Repair in Reedsburg, WI';
$pageDescription = 'Dellona Electric handles electrical repair, panel upgrades, lighting, EV chargers and generators in Reedsburg, WI since 2018. Call (608) 477-8453 today.';
$canonicalUrl    = $siteUrl . '/';
$ogImage         = $ogImageDefault;
$currentPage     = 'home';
$pageType        = 'home';

/* Hero photo: finished kitchen lighting (landscape, 2048px original). */
$heroImage        = 'hero-kitchen-lighting-v1';
$heroImageSizes   = '(max-width: 900px) 100vw, 55vw';
$heroPreload      = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroImageSizes];
$heroPreloadImage = '/assets/images/' . $heroImage . '.jpg';

/* Home services grid: 8 of the 15 config services, each paired with the client
 * photo that shows that work. The other 7 are listed under the grid. */
$homeServiceCards = [
    ['slug' => 'electrical-repair', 'icon' => 'wrench', 'img' => 'sunroom-device-install-v1',
     'alt' => 'Dellona Electric electrician kneeling to work on a wall box in a sunroom with lake-view windows',
     'desc' => 'Tracing and fixing dead circuits, short circuits, flickering lights and partial power loss.',
     'bullets' => ['Dead outlets and circuits traced', 'Tripping breakers found at the source', 'Short circuits located and repaired']],
    ['slug' => 'panel-upgrades', 'icon' => 'zap', 'img' => 'panel-work-basement-v1',
     'alt' => 'Two Dellona Electric electricians working inside an open breaker panel in an unfinished basement',
     'desc' => 'Breaker and panel repair, plus panel upgrades for homes that need more capacity.',
     'bullets' => ['Worn breakers replaced', 'Room for new circuits', 'Capacity for chargers and additions']],
    ['slug' => 'lighting-installation', 'icon' => 'lightbulb', 'img' => 'new-home-exterior-lighting-v1',
     'alt' => 'New home at dusk with recessed soffit lights and porch lights switched on',
     'desc' => 'Recessed, pendant, exterior and security lighting for new and existing homes.',
     'bullets' => ['Recessed and pendant fixtures', 'Soffit and porch lighting', 'Exterior security lights']],
    ['slug' => 'ceiling-fan-installation', 'icon' => 'wind', 'img' => 'living-room-ceiling-fan-v1',
     'alt' => 'Living room with a large ceiling fan and backlit built-in wall niches',
     'desc' => 'Ceiling fans mounted on fan-rated boxes, with wall switch or remote control.',
     'bullets' => ['Fan-rated mounting boxes', 'Wall switch or remote', 'Old fixtures swapped for fans']],
    ['slug' => 'ev-charger-installation', 'icon' => 'battery-charging', 'img' => 'ev-charger-garage-v1',
     'alt' => 'Wall-mounted JuiceBox EV charger with its cable looped below it on a garage wall',
     'desc' => 'Home EV chargers on a dedicated circuit, after a check of panel capacity.',
     'bullets' => ['Dedicated 240-volt circuit', 'Panel capacity checked first', 'Garage or exterior mounting']],
    ['slug' => 'generator-installation', 'icon' => 'power', 'img' => 'standby-generator-log-home-v1',
     'alt' => 'Two Dellona Electric electricians running conduit beside a Kohler standby generator at a log home',
     'desc' => 'Standby and portable generator hookups with a transfer switch for outage backup.',
     'bullets' => ['Standby generator wiring', 'Transfer switch installation', 'Portable generator inlets']],
    ['slug' => 'new-construction-wiring', 'icon' => 'hard-hat', 'img' => 'garage-exterior-lighting-night-v1',
     'alt' => 'Newly built garage lit up at night by exterior wall lights, with both doors open',
     'desc' => 'Wiring for new homes, additions and outbuildings, from rough-in to final.',
     'bullets' => ['Rough-in through final', 'Additions and outbuildings', 'Outlet and lighting layout']],
    ['slug' => 'commercial-electrical', 'icon' => 'building-2', 'img' => 'commercial-bar-lighting-v1',
     'alt' => 'Restaurant bar interior with pendant lights, a skylight and wood-plank flooring',
     'desc' => 'Repairs, lighting and upgrades for shops, offices, restaurants and light industrial space.',
     'bullets' => ['Dining and retail lighting', 'Repairs and service upgrades', 'Circuits for new equipment']],
];
$homeCardSlugs = array_column($homeServiceCards, 'slug');
$homeMoreServices = array_values(array_filter($services, function ($s) use ($homeCardSlugs) {
    return !in_array($s['slug'], $homeCardSlugs, true);
}));

/* Recent-work gallery — captions describe only what each photo shows. */
$galleryItems = [
    ['img' => 'hero-kitchen-lighting-v1', 'wide' => true,  'tag' => 'Lighting',         'cap' => 'Recessed lights and three pendants over a kitchen island', 'alt' => 'Kitchen with recessed ceiling lights and three pendant lights over a white island'],
    ['img' => 'panel-work-basement-v1',               'wide' => false, 'tag' => 'Panel work',       'cap' => 'Two electricians working in a breaker panel in a basement', 'alt' => 'Two electricians working in an open breaker panel with wiring running into the ceiling joists'],
    ['img' => 'ev-charger-garage-v1',                 'wide' => false, 'tag' => 'EV charger',       'cap' => 'JuiceBox charger mounted on a garage wall', 'alt' => 'JuiceBox electric vehicle charger mounted on a garage wall'],
    ['img' => 'garage-exterior-lighting-night-v1',    'wide' => true,  'tag' => 'New construction', 'cap' => 'Exterior lights on a new garage, switched on after dark', 'alt' => 'New garage at night with exterior wall lights on and both doors open'],
    ['img' => 'standby-generator-log-home-v1',        'wide' => false, 'tag' => 'Generator',        'cap' => 'Running conduit to a Kohler standby generator at a log home', 'alt' => 'Electricians beside a Kohler standby generator and conduit at a log home'],
    ['img' => 'sunroom-device-install-v1',            'wide' => false, 'tag' => 'Repair',           'cap' => 'Working on a wall box in a sunroom', 'alt' => 'Electrician kneeling on a patterned tile floor working on a wall box in a sunroom'],
    ['img' => 'living-room-ceiling-fan-v1',           'wide' => true,  'tag' => 'Ceiling fan',      'cap' => 'Large ceiling fan and backlit wall niches in a living room', 'alt' => 'Living room with a large ceiling fan and backlit built-in niches around a TV wall'],
    ['img' => 'commercial-bar-lighting-v1',           'wide' => false, 'tag' => 'Commercial',       'cap' => 'Pendant lighting in a restaurant bar under a skylight', 'alt' => 'Restaurant bar and dining tables under pendant lights and a skylight'],
    ['img' => 'new-home-exterior-lighting-v1',        'wide' => false, 'tag' => 'Exterior lighting', 'cap' => 'Soffit and porch lights on a new home at dusk', 'alt' => 'New home at dusk with soffit and porch lights on'],
    ['img' => 'truck-trailer-job-site-v1',            'wide' => true,  'tag' => 'On site',          'cap' => 'The Dellona Electric truck and trailer on a new-build lot', 'alt' => 'Black pickup truck and enclosed Dellona Electric trailer parked on a new-build lot'],
    ['img' => 'crew-company-truck-v1',                'wide' => false, 'tag' => 'The crew',         'cap' => 'Two of the crew with the company truck', 'alt' => 'Two members of the Dellona Electric crew standing beside the lettered company truck'],
];

/* FAQs: research-brief questions that intake can answer, plus service questions
 * the client's own photos answer. Visible text only — never FAQPage JSON-LD. */
$faqs = [
    ['q' => 'Do you serve Reedsburg and the surrounding area?',
     'a' => 'Yes. Dellona Electric is based at ' . $address['street'] . ' in Reedsburg and works in Reedsburg and the surrounding Sauk County area. If your property is farther out, call ' . $phone . ' with the address and you will get a straight answer on whether the job is in range.'],
    ['q' => 'How much does an electrical repair or installation cost?',
     'a' => 'It depends on the job: how many circuits are involved, the age and capacity of your panel, and how far new wiring has to run. Describe the work on the estimate form or call ' . $phone . ', and Dellona Electric will talk through what the job involves and how it is priced.'],
    ['q' => 'Do electrical upgrades need a permit in Wisconsin?',
     'a' => 'Often, yes. Panel upgrades, service changes, new circuits and new-construction wiring commonly need an electrical permit and inspection in Wisconsin, and the details depend on where the property is. Ask when you call and Dellona Electric will tell you whether your job needs one.'],
    ['q' => 'Can you install an EV charger in my garage?',
     'a' => 'Yes. Dellona Electric installs home EV chargers, including wall-mounted units like the JuiceBox in the photos above, on a dedicated 240-volt circuit. The first step is checking whether your panel has room for that circuit or needs an upgrade first.'],
    ['q' => 'Do you install standby generators?',
     'a' => 'Yes. Dellona Electric wires standby generators, like the Kohler unit shown at a log home above, and portable generator hookups. Both go in with a transfer switch, which keeps generator power separate from the utility line when the grid goes down.'],
    ['q' => 'Do you work on new construction and commercial buildings?',
     'a' => 'Yes. Alongside repairs in existing homes, Dellona Electric wires new houses, additions and outbuildings from rough-in through final, and handles repairs, lighting and upgrades in commercial spaces such as restaurants, shops and offices.'],
];

/* Lead forms: p1_lead_hidden_fields('<form id>') (includes/p1-form-helpers.php) emits _next, _honey, form_location,
   consent_version/consent_page, p1_attribution_fields('<form id>') and the _ft/_js spam shield in one call.
   Form ids on this page: hero, estimate-section (+ dialog in footer.php). */

/* Page schema — merged by head.php into the sitewide @graph (WebSite + Electrician). */
$schemaMarkup = ['@graph' => [
    generateWebPageSchema($pageTitle, $pageDescription, $canonicalUrl, $heroPreloadImage),
]];

$homePhoneHref = 'tel:' . $phoneRaw;
$homeAddressLine = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$homeServicesHub = p1_page_exists('/services/');
?>
<?php ob_start(); /* page-specific CSS, printed inside <head> by head.php via $headExtra */ ?>
<style>
/* ==== Homepage — page-specific composition (tokens only; scaffold classes are not restyled) ==== */

/* -- Hero: dark type-led band (minimal-tech) with the job photo carried to the viewport edge -- */
.home-hero { background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 58%, var(--color-primary-deep) 100%); }
.home-hero::before {
  content: ""; position: absolute; z-index: -1; pointer-events: none;
  inset: -20% 40% 10% -15%;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 22%, transparent), transparent 72%);
}
.home-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .35; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.55'/%3E%3C/svg%3E");
}
.home-hero .eyebrow { color: var(--color-accent-bright); }
.home-hero .hero-title .text-accent { color: var(--color-accent-bright); }
.home-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.home-hero .hero-chips li {
  background: color-mix(in srgb, var(--color-white) 7%, transparent);
  border-color: color-mix(in srgb, var(--color-white) 18%, transparent);
  color: var(--color-white);
}
.home-hero .hero-chips svg { color: var(--color-accent-bright); }
.home-hero .hero-visual { min-height: 540px; }
.home-hero .hero-visual__img { border: 1px solid color-mix(in srgb, var(--color-white) 10%, transparent); border-right: 0; }
.home-hero .hero-visual__img picture { display: block; height: 100%; }
.home-hero .hero-visual__img::after {
  content: ""; position: absolute; inset: 0; pointer-events: none;
  background: linear-gradient(90deg, color-mix(in srgb, var(--color-dark) 45%, transparent) 0%, transparent 35%);
}
.home-hero .photo-stack__tag { max-width: 15rem; }
.home-hero .photo-stack__tag b { color: var(--color-accent-dark); font-size: var(--font-size-lg); }
.home-hero .hero-form-open { background: var(--color-accent); color: var(--color-ink); }
.home-hero .hero-form-open:hover { background: var(--color-accent-bright); }
.home-hero .hero-form-card { border-color: color-mix(in srgb, var(--color-white) 30%, transparent); }
.home-hero .hero-form-card h2 { color: var(--color-ink); }
.home-hero .hero-form .consent span { color: var(--color-ink-2); }
.home-hero .hero-form .consent a { color: var(--color-primary); }
@media (max-width: 900px) {
  .home-hero .hero-visual { min-height: 0; }
  .home-hero .hero-visual__img::after { display: none; }
}
@media (max-width: 560px) {
  .home-hero .hero-answer { font-size: var(--fs-body); }
  .home-hero .hero-text { gap: var(--space-4); }
}

/* -- Ticker: service names in the accent face, icons in amber -- */
.home-ticker { padding-block: var(--space-4); }
.home-ticker .ticker-track svg { color: var(--color-accent-dark); }
.home-ticker .ticker-track > span + span::before {
  content: ""; width: 6px; height: 6px; border-radius: var(--radius-full);
  background: var(--color-line); margin-right: var(--space-4);
}

/* -- Services: wide container, header split into question | answer -- */
.home-services .section-title {
  max-width: none; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
  column-gap: var(--space-12); align-items: end;
}
.home-services .section-title .eyebrow-label,
.home-services .section-title h2 { grid-column: 1; }
.home-services .section-title h2 { max-width: 24ch; }
.home-services .section-title .hero-answer { grid-column: 2; grid-row: 1 / span 3; max-width: 34rem; font-size: var(--fs-body); }
.home-services .section-title .section-subtitle { grid-column: 1; }
.home-services .service-card__body { text-align: left; }
.home-services .service-card-with-image h3 { color: var(--color-ink); }
.home-services .service-card__image::after {
  content: ""; position: absolute; inset: auto 0 0 0; height: 40%; pointer-events: none;
  background: linear-gradient(to top, color-mix(in srgb, var(--color-dark) 35%, transparent), transparent);
}
.home-services .service-card-with-image:hover .service-card__image img { transform: scale(1.04); }
.home-services .service-card__image img { transition: transform var(--transition-slow); }
.home-more {
  margin-top: var(--space-8); padding-top: var(--space-6);
  border-top: 1px solid var(--color-line);
  display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-4) var(--space-6);
}
.home-more__label {
  font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em;
  text-transform: uppercase; color: var(--color-muted);
}
.home-more .svc-groups { margin: 0; flex: 1 1 32rem; }
.home-more .svc-groups li > span {
  display: inline-flex; align-items: center; gap: var(--space-2);
  font-size: var(--font-size-sm); font-weight: 500; color: var(--color-ink-2);
  background: var(--color-surface); border: 1px solid var(--color-line);
  border-radius: var(--radius-full); padding: var(--space-2) var(--space-4);
}
@media (max-width: 900px) {
  .home-services .section-title { grid-template-columns: 1fr; }
  .home-services .section-title .hero-answer { grid-column: 1; grid-row: auto; }
}

/* -- Proof strip: dark brushed band, verifiable facts only -- */
.home-proof.stats-band {
  background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 120%);
  color: var(--color-white); border-block: 0;
}
.home-proof .stat-item { border-left-color: color-mix(in srgb, var(--color-white) 14%, transparent); }
.home-proof .stat-number { color: var(--color-white); font-size: clamp(1.6rem, 1.2rem + 1.2vw, 2.3rem); text-transform: uppercase; }
.home-proof .stat-number span { color: var(--color-accent-bright); }
.home-proof .stat-label { color: color-mix(in srgb, var(--color-white) 72%, transparent); }
@media (max-width: 800px) {
  .home-proof .stat-item:nth-child(n+3) { border-top: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); }
}

/* -- Recent work gallery (signature section): full-bleed track on white -- */
.home-gallery { background: var(--color-surface); }
.home-gallery .gallery-head {
  display: grid; grid-template-columns: minmax(0, 1fr) auto; align-items: end;
  gap: var(--space-4) var(--space-8); margin-bottom: var(--space-8);
}
.home-gallery .gallery-head > div { display: grid; gap: var(--space-3); max-width: 46rem; }
.home-gallery .gallery-head p { margin: 0; color: var(--color-ink-2); }
.home-gallery .gallery-track {
  padding-inline: max(var(--space-4), calc((100vw - var(--container-wide)) / 2));
  scroll-padding-inline: max(var(--space-4), calc((100vw - var(--container-wide)) / 2));
}
.home-gallery .gallery-track:focus-visible { outline-offset: calc(-1 * var(--space-1)); }
.home-gallery .gallery-item picture { display: block; height: 100%; }
.home-gallery .gallery-foot { margin-top: var(--space-6); display: flex; flex-wrap: wrap; gap: var(--space-4); align-items: center; }
.home-gallery .floating-ring--a { top: var(--space-8); right: -6%; }
.home-gallery .floating-ring--b { bottom: -10%; left: -8%; width: 220px; height: 220px; border-width: 18px; }
@media (max-width: 700px) { .home-gallery .gallery-head { grid-template-columns: 1fr; } }

/* -- About / process: the page's asymmetric section (60 / 40, offset frame, clipped photo) -- */
.home-about { background: var(--color-paper-2); }
.home-about .about-split { grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); align-items: start; }
.home-about .about-left { display: grid; gap: var(--space-4); }
.home-about .about-left > p { margin: 0; color: var(--color-ink-2); max-width: var(--measure); }
.home-about .about-left > p:first-of-type { font-size: var(--fs-lead); color: var(--color-ink); }
.home-about .process-head { margin-top: var(--space-6); font-size: var(--fs-h3); }
.home-about .process-steps li { background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius); padding: var(--space-4); }
.home-about .process-steps li::before { border-color: var(--color-accent); }
.home-about .about-right { margin-top: var(--space-16); }
.home-about .about-image { margin-top: 0; }
.home-about .about-image::before { inset: calc(-1 * var(--space-6)) var(--space-6) var(--space-6) calc(-1 * var(--space-6)); }
.home-about .about-image-primary { aspect-ratio: 4 / 5; }
.home-about .about-image-primary picture, .home-about .about-image-primary img { width: 100%; height: 100%; object-fit: cover; }
.home-about .about-stat-card { display: grid; gap: var(--space-1); max-width: 15rem; }
.home-about .about-stat-card b { font-family: var(--font-heading); font-size: var(--font-size-lg); color: var(--color-ink); }
.home-about .about-stat-card span { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.home-about .about-stat-card small { font-size: var(--font-size-sm); color: var(--color-muted); }
@media (max-width: 900px) {
  .home-about .about-split { grid-template-columns: 1fr; }
  .home-about .about-right { margin: var(--space-8) var(--space-6) var(--space-8) var(--space-6); }
}

/* -- Mid-page CTA: dark grain band, parallelogram edge, wide container -- */
.home-cta .container-wide { display: grid; grid-template-columns: minmax(0, 1.3fr) auto; gap: var(--space-8); align-items: center; }
.home-cta h2 { max-width: 24ch; }
.home-cta p { max-width: 58ch; margin: 0; }
.home-cta .actions .btn-accent svg { color: var(--color-ink); }
@media (max-width: 800px) { .home-cta .container-wide { grid-template-columns: 1fr; } }

/* -- Google reviews (renders only when the feed has written reviews) -- */
.home-reviews { background: var(--color-paper-2); }

/* -- FAQ: white band, two columns -- */
.home-faq { background: var(--color-surface); }
.home-faq .section-head { max-width: 44rem; }
.home-faq .faq summary { padding-block: var(--space-1); }
.home-faq .faq[open] summary { color: var(--color-ink); }
.home-faq .faq-grid > div { display: grid; align-content: start; }

/* -- Estimate section: curved edge, wide container, form card + next steps -- */
.home-estimate { background: var(--color-paper-2); }
@media (min-width: 901px) { .home-estimate .estimate { grid-template-columns: minmax(0, 1.15fr) minmax(0, .85fr); } }
.home-estimate .card { display: grid; gap: var(--space-4); }
.home-estimate .card h2 { margin: 0; }
.home-estimate .estimate-aside { display: grid; gap: var(--space-4); align-content: start; padding-top: var(--space-4); }
.home-estimate .estimate-aside h3 { font-size: var(--fs-h3); }
.home-estimate .estimate-aside .area-note { margin: 0; color: var(--color-ink-2); font-size: var(--font-size-sm); }
.home-estimate .form-consent-fieldset { margin-block: var(--space-4) var(--space-2); }

/* -- Cross-document view transitions (C13) -- */
::view-transition-old(root) { animation: home-vt-out .18s ease both; }
::view-transition-new(root) { animation: home-vt-in .22s ease both; }
@keyframes home-vt-out { to { opacity: 0; } }
@keyframes home-vt-in { from { opacity: 0; } }
@media (prefers-reduced-motion: reduce) {
  ::view-transition-old(root), ::view-transition-new(root) { animation: none; }
  .home-services .service-card__image img { transition: none; }
}
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content">

  <!-- HERO — dark type-led band, client job photo right, compact estimate card (desktop) -->
  <section class="hero hero--type home-hero" aria-labelledby="hero-title">
    <div class="container">
      <div class="hero-grid hero-grid--visual">
        <div class="hero-text">
          <span class="eyebrow"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?> · <?php echo e($serviceAreas[0]['county']); ?> County</span>
          <h1 class="hero-title" id="hero-title">Electrical repair services in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer"><?php echo e($siteName); ?> has handled electrical repair in <?php echo e($address['city'] . ', ' . $address['state']); ?> since <?php echo (int) $yearEstablished; ?>: dead circuits and tripping breakers, faulty wiring and panel upgrades, indoor and outdoor lighting, EV chargers, standby generators and new-construction wiring for homes and businesses across the Sauk County area.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($homePhoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('battery-charging', 16); ?> EV charger installs</li>
            <li><?php echo icon('power', 16); ?> Standby generators</li>
            <li><?php echo icon('hard-hat', 16); ?> New-build wiring</li>
          </ul>
        </div>
        <div class="hero-visual">
          <div class="hero-visual__img">
            <?php echo p1_picture($heroImage, 'Kitchen wired by Dellona Electric with recessed ceiling lights and three pendant lights over the island', ['sizes' => $heroImageSizes, 'priority' => true]); ?>
          </div>
          <div class="photo-stack__tag"><b>Recent work</b><span>Recessed and pendant lighting in a new kitchen</span></div>
          <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
            <h2 id="hero-form-title"><?php echo e($estimateCtaLabel); ?></h2>
            <p class="hero-form-tagline">No obligation. Tell us what's going on.</p>
            <form action="<?php echo e($formAction); ?>" method="POST" class="hero-form">
              <?php echo p1_lead_hidden_fields('hero'); ?>
              <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
              <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" required></div>
              <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options(); ?></select></div>
              <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
              <button type="submit" class="btn btn-primary btn-block">Send my request</button>
            </form>
          </aside>
        </div>
      </div>
    </div>
  </section>

  <!-- TICKER — service names, pure CSS loop, decorative -->
  <div class="ticker-strip home-ticker" aria-hidden="true">
    <div class="ticker-track">
      <?php
      $tickerItems = [['wrench', 'Electrical repair'], ['zap', 'Panel upgrades'], ['plug', 'Wiring and rewiring'], ['lightbulb', 'Lighting installation'],
                      ['wind', 'Ceiling fans'], ['battery-charging', 'EV chargers'], ['power', 'Standby generators'], ['shield-check', 'Surge protection'],
                      ['hard-hat', 'New construction'], ['building-2', 'Commercial electrical']];
      for ($tickerPass = 0; $tickerPass < 2; $tickerPass++):
          foreach ($tickerItems as $tickerItem): ?>
      <span><?php echo icon($tickerItem[0], 16); ?><?php echo e($tickerItem[1]); ?></span>
      <?php endforeach; endfor; ?>
    </div>
  </div>

  <!-- SERVICES — tinted image cards (required component) -->
  <section class="section home-services" aria-label="Electrical services">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2>What electrical work does <span class="text-accent">Dellona Electric</span> handle in <span class="text-accent">Reedsburg</span>?</h2>
        <p class="hero-answer"><?php echo e($siteName); ?> handles <?php echo count($services); ?> kinds of electrical work for homes, new builds and businesses in <?php echo e($address['city']); ?>, from a dead outlet or a breaker that keeps tripping to a panel upgrade, an EV charger in the garage or a standby generator beside the house. Pick the card closest to your job, or describe it on the estimate form.</p>
        <span class="section-subtitle">Homes · New builds · Businesses</span>
      </div>

      <div class="services-grid">
        <?php foreach ($homeServiceCards as $cardI => $card):
            $cardSvc  = p1_service_by_slug($card['slug']);
            if (!$cardSvc) continue;
            $cardTint = ($cardI % 3) + 1;
            $cardHref = '/services/' . $card['slug'] . '/';
            $cardLive = p1_page_exists($cardHref); ?>
        <article class="service-card-with-image card-tint-<?php echo $cardTint; ?> reveal-up reveal-delay-<?php echo $cardTint; ?>">
          <div class="service-card__image">
            <?php echo p1_picture($card['img'], $card['alt'], ['sizes' => '(max-width: 440px) 100vw, (max-width: 720px) 50vw, (max-width: 1000px) 33vw, 340px']); ?>
          </div>
          <div class="service-card__body">
            <div class="service-card__icon"><?php echo icon($card['icon'], 22); ?></div>
            <h3><?php echo e($cardSvc['name']); ?></h3>
            <p class="service-card__desc"><?php echo e($card['desc']); ?></p>
            <ul>
              <?php foreach ($card['bullets'] as $cardBullet): ?>
              <li><?php echo e($cardBullet); ?></li>
              <?php endforeach; ?>
            </ul>
            <?php if ($cardLive): ?>
            <a href="<?php echo e($cardHref); ?>" class="service-card__cta">Learn more</a>
            <?php else: ?>
            <a href="#estimate" class="service-card__cta">Ask about <?php echo e(strtolower($cardSvc['name'])); ?></a>
            <?php endif; ?>
          </div>
        </article>
        <?php endforeach; ?>
      </div>

      <div class="home-more reveal-up">
        <span class="home-more__label">Also from <?php echo e($siteName); ?></span>
        <ul class="svc-groups">
          <?php foreach ($homeMoreServices as $moreSvc):
              $moreHref = '/services/' . $moreSvc['slug'] . '/'; ?>
          <li><?php if (p1_page_exists($moreHref)): ?><a href="<?php echo e($moreHref); ?>"><?php echo e($moreSvc['name']); ?></a><?php else: ?><span><?php echo e($moreSvc['name']); ?></span><?php endif; ?></li>
          <?php endforeach; ?>
        </ul>
        <?php if ($homeServicesHub): ?>
        <a href="/services/" class="btn btn-secondary">View All <?php echo count($services); ?> Services →</a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- PROOF STRIP — four facts from intake, no invented numbers -->
  <section class="stats-band texture-grain slant-top home-proof" aria-labelledby="proof-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <h2 class="sr-only" id="proof-title"><?php echo e($siteName); ?> at a glance</h2>
      <div class="stats-row">
        <div class="stat-item reveal-scale reveal-delay-1"><span class="stat-number">Est. <span><?php echo (int) $yearEstablished; ?></span></span><span class="stat-label">Founded in <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></div>
        <div class="stat-item reveal-scale reveal-delay-2"><span class="stat-number"><span><?php echo count($services); ?></span> Services</span><span class="stat-label">From outlet repair to service upgrades</span></div>
        <div class="stat-item reveal-scale reveal-delay-3"><span class="stat-number"><?php echo e($serviceAreas[0]['county']); ?> <span>County</span></span><span class="stat-label">Based on Briar Bluff Rd, <?php echo e($address['city']); ?></span></div>
        <div class="stat-item reveal-scale reveal-delay-4"><span class="stat-number">Homes + <span>Business</span></span><span class="stat-label">Residential, new-build and commercial work</span></div>
      </div>
    </div>
  </section>

  <!-- RECENT WORK GALLERY — signature section, full-bleed scroll-snap -->
  <section class="section gallery-section home-gallery" aria-labelledby="gallery-title">
    <span class="floating-ring floating-ring--a" aria-hidden="true"></span>
    <span class="floating-ring floating-ring--b float-animate-slow" aria-hidden="true"></span>
    <div class="container-wide">
      <div class="gallery-head reveal-left">
        <div>
          <span class="eyebrow">Recent Work</span>
          <h2 id="gallery-title">Panels, chargers, generators and lighting from the <span class="text-accent">Dellona Electric</span> crew</h2>
          <p>New-home kitchens, a standby generator at a log home, a restaurant bar and the panel work behind them. Scroll sideways for more.</p>
        </div>
        <p class="gallery-hint"><?php echo icon('arrow-right', 16); ?> Swipe or use arrow keys</p>
      </div>
    </div>
    <div class="gallery-track" data-p1-dynamic tabindex="0" aria-label="Project photos — scroll horizontally">
      <?php foreach ($galleryItems as $galItem): ?>
      <figure class="gallery-item<?php echo $galItem['wide'] ? ' gallery-item--wide' : ''; ?>">
        <?php echo p1_picture($galItem['img'], $galItem['alt'], ['sizes' => $galItem['wide'] ? '(max-width: 700px) 80vw, 480px' : '(max-width: 700px) 60vw, 320px']); ?>
        <figcaption><span class="gallery-item__tag"><?php echo e($galItem['tag']); ?></span><span class="gallery-item__cap"><?php echo e($galItem['cap']); ?></span></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
    <div class="container-wide gallery-foot">
      <?php if ($homeServicesHub): ?>
      <a href="/services/" class="btn btn-secondary">See all services</a>
      <?php endif; ?>
      <button type="button" class="btn btn-primary" data-open-estimate>Ask about a job like these</button>
    </div>
  </section>

  <!-- ABOUT / PROCESS — asymmetric 60/40 with offset framed photo -->
  <section class="section home-about" aria-labelledby="about-title">
    <div class="container">
      <div class="about-split">
        <div class="about-left reveal-left">
          <span class="eyebrow">About <?php echo e($siteName); ?></span>
          <h2 id="about-title">Who is behind <span class="text-accent">Dellona Electric</span>?</h2>
          <p><?php echo e($siteName); ?> is a <?php echo e($address['city']); ?> electrical company owned by <?php echo e($ownerName); ?>. It works on existing homes, new construction and commercial buildings from its base on Briar Bluff Rd, and takes on anything from one dead outlet to the wiring for a whole new house.</p>
          <p>The photos on this page show the range: a JuiceBox charger on a garage wall, conduit run to a Kohler standby generator at a log home, pendant lighting in a restaurant bar, a full kitchen of recessed lights in a new house. Fixing something or building something, it is one number to call.</p>
          <h3 class="process-head">How a job with <?php echo e($siteName); ?> goes</h3>
          <ol class="process-steps">
            <li><b>Call or send the form</b><span>Call <?php echo e($phone); ?> or send the estimate form with a short description of the problem or project.</span></li>
            <li><b>Look at what's there</b><span>The panel, the wiring and the space get checked before the work is priced.</span></li>
            <li><b>Do the work</b><span>The crew completes the repair, upgrade or installation.</span></li>
            <li><b>Walk you through it</b><span>You see what was done and how to use anything new, like a charger, a transfer switch or new controls.</span></li>
          </ol>
        </div>
        <div class="about-right reveal-right">
          <div class="about-image">
            <div class="about-image-primary img-clipped">
              <?php echo p1_picture('crew-company-truck-v1', 'Two members of the Dellona Electric crew standing beside the lettered company truck', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <div class="about-stat-card">
              <span>Owner</span>
              <b><?php echo e($ownerName); ?></b>
              <small><?php echo e($siteName); ?>, <?php echo e($address['city']); ?></small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MID-PAGE CTA — dark grain band -->
  <section class="cta-banner texture-grain edge-parallelogram-top home-cta" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Don't wait on it</span>
        <h2 id="cta-title">Breaker tripping, outlet warm or a light that keeps flickering?</h2>
        <p>Those are common signs of a loose connection, an overloaded circuit or a failing breaker, and they rarely fix themselves. Call <?php echo e($siteName); ?> and have it checked before a warm outlet becomes a burned one.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($homePhoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

  <?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
  $homeReviews = p1_google_reviews($slug, ['heading' => 'What ' . $address['city'] . ' customers say on Google']);
  if ($homeReviews !== ''): ?>
  <section class="section home-reviews" aria-label="Google reviews"><div class="container"><?php echo $homeReviews; ?></div></section>
  <?php endif; ?>

  <!-- FAQ — native details, visible text only (no FAQPage JSON-LD) -->
  <section class="section home-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="section-head reveal-up">
        <span class="eyebrow">Common Questions</span>
        <h2 id="faq-title">Before you call <span class="text-accent">Dellona Electric</span></h2>
        <p>Straight answers on service area, pricing, permits, EV chargers, generators and new construction.</p>
      </div>
      <div class="faq-grid">
        <?php foreach (array_chunk($faqs, 3) as $faqColI => $faqCol): ?>
        <div class="<?php echo $faqColI === 0 ? 'reveal-left' : 'reveal-right'; ?>">
          <?php foreach ($faqCol as $faqI => $faq): ?>
          <details class="faq"<?php echo ($faqColI === 0 && $faqI === 0) || ($faqColI === 1 && $faqI === 0) ? ' open' : ''; ?>>
            <summary><?php echo e($faq['q']); ?></summary>
            <p><?php echo e($faq['a']); ?></p>
          </details>
          <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ESTIMATE — full form + what happens next + NAP -->
  <section class="section home-estimate edge-curve-top" id="estimate" aria-labelledby="estimate-title">
    <div class="container-wide">
      <div class="estimate">
        <div class="card reveal-up">
          <span class="eyebrow"><?php echo e($estimateCtaLabel); ?></span>
          <h2 id="estimate-title">Tell us about the job</h2>
          <?php echo p1_full_lead_form('estimate-section', 'est', 'Send my request'); ?>
        </div>
        <div class="estimate-aside reveal-right">
          <h3>What happens next</h3>
          <ol class="next-steps">
            <li><strong>Your request goes to <?php echo e($siteName); ?></strong>It lands in the company inbox with the service and details you entered.</li>
            <li><strong>You get a call back</strong>To ask a few questions about the job and set a time to look at it.</li>
            <li><strong>You decide</strong>Go ahead when you are ready. Requesting an estimate carries no obligation.</li>
          </ol>
          <div class="nap">
            <div><?php echo icon('phone', 18); ?><a href="<?php echo e($homePhoneHref); ?>"><?php echo e($phone); ?></a></div>
            <div><?php echo icon('mail', 18); ?><a href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a></div>
            <div><?php echo icon('map-pin', 18); ?><a href="<?php echo e($directionsUrl); ?>" target="_blank" rel="noopener"><?php echo e($homeAddressLine); ?></a></div>
          </div>
          <p class="area-note"><?php echo e($siteName); ?> works in <?php echo e($address['city']); ?> and the surrounding <?php echo e($serviceAreas[0]['county']); ?> County area.</p>
        </div>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
